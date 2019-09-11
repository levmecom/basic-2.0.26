<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-11 15:55
 *
 * 项目：levme  -  $  - threadList.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

use app\modules\ucenter\models\User;
use app\modules\ucenter\widgets\Ucenter;

$model = new \app\modules\forum\models\Threads();
$user = new User();
?>


<?php foreach ($threadList as $v):?>
    <li class="ts-info" pid="<?=$v['id']?>" user="<?=$users[$v['uid']]['username']?>">
        <div class="item-content">
            <div class="item-media">
                <a href="<?=Yii::$app->homeUrl?>ucenter/<?=$v['uid']?>" target="_screen"><img src="<?=Ucenter::avatar($v['uid'])?>" class="avatar"></a></div>
            <div class="item-inner">
                <div class="item-title-row">
                    <a class="item-text"><?=$users[$v['uid']]['username']?></a>
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
                <div class="item-subtitle toPhotoBrowserBox targetEl_x_<?=$v['id']?>">
                    <a class="item-text tdtitle" href="<?=Yii::$app->homeUrl,'forum/view/',$v['id']?>" target="_screen"><?=$v['title'];?>
                    <?php if ($v['attachs']) : ?>
                    <div class="imgbox">
                        <?php foreach ($v['attachs'] as $ath) :?>
                            <img src="<?=\levmecom\aalevme\levHelpers::getHomeFull(),$ath['src']?>">
                        <?php endforeach;?>
                    </div>
                    <?php endif;?>
                    </a>
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
                        <?=\levmecom\modules\forum\widgets\threadList::replyHtmls($v)?>
                    </ul>
                </div>
            </div>
        </div>
    </li>
<?php endforeach;?>
