<?php

use app\modules\ucenter\widgets\Ucenter;
/* @var $this yii\web\View */

$this->title = '用户中心 - '.Yii::$app->params['SiteName'];
$this->blocks['pageName'] = 'ucenter';
$userinfo = Ucenter::userinfo();
?>
<style>
    .ucenter-index {max-width: 1200px;margin: auto;background:#f3f3f3;height: 100%;}
    .ucenter-index .item-media i.fa {font-size:18px;}
    .ucenter-index .list.first-list {margin-top: 0;}
    .ucenter-index .list ul::before {height:0;}
    .item-media.avatar-box img {width: 80px;height: 80px;border-radius: 5px;}
    .mymoneybox {padding-left: 15px;height:80px;margin-top: 10px;}
    .mymoneybox .moneytitle {vertical-align: top;font-size: 14px;}
    .mymoneybox .mymoney {font-size: 30px;font-family: 'Hiragino Sans GB', Arial;font-weight: bold;margin-top: 15px;}
    .ucenter-index .top-title, .top-title .item-text, .username {background: #6998ca;color: #fff;}
    .roow.username {font-size: 16px;}
    .ucenter-index .top-title .fa.fa-gear {font-size: 22px;color: #fff;}
    .item-title.u-t-nav .fa {font-size: 20px;color: #fff;margin-right: 10px;vertical-align: middle;}
    .item-title.u-t-nav .fa.fa-chevron-left {font-size: 18px;}
</style>

<div class="ucenter-index">
    <div class="list first-list">
        <ul class="top-title">
            <li>
                <div class="item-content">
                    <div class="item-inner">
                        <div class="item-title u-t-nav">
                            <a class="link goback back"><i class="fa fa-chevron-left"></i></a>
                            <a href="<?=Yii::$app->homeUrl?>" class="link"><i class="fa fa-home"></i></a>
                        </div>
                        <div class="item-after">
                            <div class="roow username"><?= $userinfo['username'] ?></div>
                        </div>
                        <div class="item-after" onclick="UploadAvatarSheet()"><i class="fa fa-gear fa-spin fa-fw" aria-hidden="true"></i></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="item-content">
                    <div class="item-inner">
                        <div class="item-media avatar-box">
                            <div class="item-title">
                                <div class="roow" onclick="UploadAvatarSheet()"><img src="<?= Ucenter::avatar() ?>"></div>
                            </div>
                        </div>
                        <div class="item-title mymoneybox">
                            <div class="roow moneytitle">帐户余额(元):</div>
                            <div class="roow mymoney">1234567890.00</div>
                        </div>
                        <div class="item-after"></div>
                    </div>
                </div>
            </li>
        </ul>
        <ul>
            <li>
                <a class="item-link item-content">
                    <div class="item-media"><i class="fa fa-credit-card" aria-hidden="true"></i></div>
                    <div class="item-inner">
                        <div class="item-text">充值</div>
                        <div class="item-after">提现</div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
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
                <a class="item-link item-content" onclick="logout()">
                    <div class="item-media"><i class="fa fa-sign-out" aria-hidden="true"></i></div>
                    <div class="item-inner">
                        <div class="item-text">退出登陆</div>
                    </div>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<?= $this->render('UploadAvatarForm')?>
