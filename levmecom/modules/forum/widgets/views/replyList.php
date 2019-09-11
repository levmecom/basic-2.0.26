<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-15 10:05
 *
 * 项目：levme  -  $  - threadView.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

use app\modules\ucenter\models\User;
use app\modules\ucenter\widgets\Ucenter;
use levmecom\aalevme\levHelpers;
use levmecom\modules\forum\widgets\threadList;
use levmecom\modules\forum\widgets\forum;

$model = new \app\modules\forum\models\Threads();
$user = new User();

$thread = $model->find()->where(['id'=>$pid, 'status'=>0])->asArray()->one();

$limit = 20;
$page = max(intval(\Yii::$app->request->get('page')), 1);
$offset = $limit * ($page - 1);

if ($thread['rootid']) {
    $where = ['pid'=>$thread['id']];
}else {
    $where = ['rootid'=>$thread['id']];//, 'touid'=>$thread['uid']
}

$fid = intval(Yii::$app->request->get('fid'));
if ($fid) $where['fid'] = $fid;

$replyList = $model->find()->where($where)->with('contents', 'replyListPid', 'attachs')->orderBy(['textlen'=>SORT_DESC])
    ->limit($limit)->offset($offset)->asArray()->all();//print_r($replyList);exit;

$insql = levHelpers::inSql(array_merge($thread, $replyList), 'uid,touid', 'replyListPid');

$users = !$insql ? [] : (new User())->find()->where("id IN ($insql)")->select(['id', 'username'])->indexBy('id')->asArray()->all();
$users[0] = ['id'=>0, 'username'=>'游客'];

?>

<?php foreach ($replyList as $k => $v):?>
    <li class="ts-info" pid="<?=$v['id']?>" user="<?=$users[$v['uid']]['username']?>">
        <div class="item-content">
            <div class="item-media">
                <div class="item-text">
                <a href="<?=Yii::$app->homeUrl?>ucenter/<?=$v['uid']?>" target="_screen">
                    <img src="<?=Ucenter::avatar($v['uid'])?>" class="avatar">
                </a>
                <floors><?=$floor = forum::getFloor($v['id'], $thread['id'], $thread['replies'])?>楼</floors>
                </div>
            </div>
            <div class="item-inner">
                <div class="item-title-row">
                    <?php if ( $v['touid'] && !in_array($v['touid'], array($v['uid'])) && $v['pid']!=$thread['id'] ) : ?>
                        <a class="item-text"><?=$users[$v['uid']]['username']?></a>
                        <gray>怼</gray>
                        <a class="item-text"><?=$users[$v['touid']]['username']?><sup><?=forum::getFloor($v['pid'],$thread['id'],$thread['replies'])?>楼</sup></a>
                    <?php else : ?>
                        <a class="item-text"><?=$users[$v['uid']]['username']?></a>
                    <?php endif; ?>
                    <div class="item-after f-thumb-box first-d">
                        <small><?=$v['views']?></small>
                        <a><i class="fa fa-street-view" aria-hidden="true"></i></a>
                    </div>
                    <div class="item-after f-thumb-box">
                        <a class="prt10 suport-btn" onclick="doSuports(this)">
                            <small><?=$v['suports']?></small><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="list floor-content-box targetEl_x_<?=$v['id']?>">
                    <div class="max-show" onclick="replyTA(this)">
                        <div class="block ck-content toPhotoBrowserBox">
                        <p><?=$v['title'];?></p>
                        <p><?=$v['contents']['contents'];?></p>
                        </div>
                    </div>
                </div>
                <div class="item-title-row bottox">
                    <div class="item-text">
                        <address class="<?=$v['address']?'openziframescreen':''?>" force="1" href="<?=\yii\helpers\Url::toRoute(['/amap/default/show-point', 'address'=>$v['address']])?>"><?=$v['address']?:'神迷网友';?></address>
                        <i class="fa fa-circle"></i>
                        <?= Yii::$app->formatter->asRelativeTime($v['addtime'], time()) ?>
                        <i class="fa fa-circle"></i>
                        <a class="reply-ta-<?=$v['id']?>" onclick="replyTA(this)">怼TA</a>
                    </div>
                    <div class="item-after"><a onclick="myMoreBtnPopover(this)" class="prt10" pid="<?=$v['id']?>">
                            <i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i>
                        </a>
                    </div>
                </div>
                <div class="item-subtitle replies-box toPhotoBrowserBox openziframescreen" href="<?=Yii::$app->homeUrl,'forum/view/',$v['id']?>">
                    <ul>
                        <?=threadList::replyHtmls($v, $users)?>
                    </ul>
                </div>
            </div>
        </div>
    </li>
<?php endforeach;?>

