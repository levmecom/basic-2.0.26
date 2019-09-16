<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-15 09:08
 *
 * 项目：levme  -  $  - layout.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

use app\modules\forum\models\ForumForums;
use app\modules\ucenter\widgets\Ucenter;
use levmecom\aalevme\levHelpers;
use levmecom\modules\forum\widgets\sendThread;
use levmecom\modules\forum\widgets\threadList;

\app\modules\forum\assets\forumAssets::register($this);

$userinfo = Ucenter::userinfo();

$fid = intval(Yii::$app->request->get('fid')) ?: 0;

if (Yii::$app->user->isGuest) {
    $loginshow = json_decode(levHelpers::stget('loginshow', 'forum'), true);
}

$forums = ForumForums::find()->where(['status'=>0])->orderBy(['displayorder'=>SORT_ASC])->indexBy('id')->asArray()->all();
foreach ($forums as $v) {
    if (isset($loginshow) && in_array($v['id'], $loginshow)) continue;
    $pforums[$v['pid']][$v['id']] = $v;
}

if (isset($forums[$fid])) {
    if (isset($pforums[$fid])) {
        $_forums[$fid] = isset($forums[$fid]) ? $forums[$fid] : [];
        $forums = $_forums + $pforums[$fid];
    } elseif (isset($forums[$fid]['pid']) && isset($pforums[$forums[$fid]['pid']])) {
        $pid = $forums[$fid]['pid'];
        $_forums[$pid] = isset($forums[$pid]) ? $forums[$pid] : [];
        $forums = $_forums + $pforums[$pid];
    }
}else {
    ksort($pforums);
    $forums = reset($pforums);
}
?>

<?php $this->beginBlock('navbar') ?>
<div class="navbar navbar-fixed-top forum">
    <div class="navbar-inner">
        <div class="left wdh">
            <div class="item-text">
                <a href="<?=Yii::$app->homeUrl?>">
                    <img src="<?=Yii::$app->homeUrl?>statics/mobileIcon.png" class="logo">
                    <h2><?=Yii::$app->params['SiteName']?></h2>
                </a>
                <a class="link" href="<?=Yii::$app->homeUrl?>">首页</a>
                <?php if ($fid) :?>
                    <a class="link oned" href="<?=Yii::$app->homeUrl?>forum/<?=$forums[$fid]['id']?>"><?=$forums[$fid]['name']?></a>
                <?php endif;?>
                <?php foreach ($forums as $v) : ?>
                    <?php if ($v['id'] == $fid) continue; ?>
                    <a class="link" href="<?=Yii::$app->homeUrl?>forum/<?=$v['id']?>"><?=$v['name']?></a>
                <?php endforeach;?>
            </div>
            <div class="item-input searchbar-box" style="display:none">
            <form class="searchbar">
                <div class="searchbar-inner">
                    <div class="searchbar-input-wrap">
                        <input type="search" placeholder="Search">
                        <i class="searchbar-icon"></i>
                        <span class="input-clear-button"></span>
                    </div>
                </div>
            </form>
            </div>
        </div>
        <div class="right">
            <a class="link panel-open" data-panel="right"><i class="fa fa-bars" aria-hidden="true"></i></a>
        </div>
    </div>
</div>
<?php $this->endBlock() ?>


<?php $this->beginBlock('layoutsTop') ?>
<div class="panel panel-right panel-cover">
    <div class="list">
        <ul>
            <?php if ($userinfo['username'] == SUPER_ADMIN) : ?>
            <li>
                <a class="item-link item-content external" target="_blank" href="<?=Yii::$app->homeUrl?>admin">
                    <div class="item-media"><i class="fa fa-user-md" aria-hidden="true"></i></div>
                    <div class="item-inner">
                        <div class="item-text">管理后台</div>
                    </div>
                </a>
            </li>
            <?php endif; ?>
            <?php if (Yii::$app->user->isGuest):?>
                <li>
                    <a class="item-link item-content">
                        <div class="item-media"><i class="fa fa-sign-in" aria-hidden="true"></i></div>
                        <div class="item-inner">
                            <div class="item-text" style="width:80%;" onclick="login()">登陆</div>
                            <div class="item-after" onclick="signup()">立即注册</div>
                        </div>
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <div class="item-link item-content">
                        <div class="item-media"><img src="<?=Ucenter::avatar()?>" width="20" height="20"></div>
                        <div class="item-inner">
                            <div class="item-text"><a href="<?=Yii::$app->homeUrl?>ucenter"><?=$userinfo['username']?></a></div>
                            <div class="item-after item-text" onclick="logout()">退出登陆</div>
                        </div>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="list">
        <ul>
            <li>
                <a class="item-link item-content external" target="_top" href="<?=Yii::$app->homeUrl?>">
                    <div class="item-media"><i class="fa fa-home" aria-hidden="true"></i></div>
                    <div class="item-inner">
                        <div class="item-text">首页</div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<?= sendThread::widget(['bottom' => true, 'counts' => isset($counts)?$counts:0, 'user' => isset($user)?$user:'']) ?>

<?= threadList::widget(['registerJs' => true]) ?>

<?= \levmecom\widgets\nativeShare\nativeShare::widget() ?>

<?php $this->endBlock() ?>


