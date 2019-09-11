<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-08-14 22:17
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

use app\modules\ucenter\widgets\Ucenter;use yii\web\View;
/* @var $this yii\web\View */

$userinfo = Ucenter::userinfo($uid);

$this->title = $userinfo['username'].'用户资料 - '.Yii::$app->params['SiteName'];

?>
<style>
    .ucenter-index {max-width: 1200px;margin: auto;background:#f3f3f3;height: 100%;}
    .ucenter-index .item-media i.fa {font-size:18px;}
    .ucenter-index .list.first-list {margin-top: 0;}
    .ucenter-index .list ul::before {height:0;}
    .item-media.avatar-box img {width: 80px;height: 80px;border-radius: 5px;}
    .myuseribox {padding-left: 15px;height:80px;margin-top: 10px;}
    .myuseribox .userititle {vertical-align: top;font-size:28px;}
    .myuseribox .myuseri {font-size:12px;font-family: 'Hiragino Sans GB', Arial;font-weight: bold;margin-top: 15px;}
    .ucenter-index .top-title, .top-title .item-text, .username {background: #6998ca;color: #fff;}
    .roow.username {font-size: 16px;}
    .ucenter-index .top-title .fa.fa-gear {font-size: 22px;color: #fff;}
    .u-t-nav .fa {font-size: 20px;color: #fff;margin-right: 10px;vertical-align: middle;}
    .u-t-nav .fa.fa-chevron-left {font-size: 18px;}
    .item-media .fa {color: rgba(0,0,0,0.5);font-size: 14px !important;}
</style>

<div class="ucenter-index">
    <div class="list first-list">
        <ul class="top-title">
            <li>
                <div class="item-content">
                    <div class="item-inner">
                        <div class="item-title u-t-nav">
                            <a class="link goback back"><i class="fa fa-chevron-left"></i></a>
                        </div>
                        <div class="item-after">
                            <div class="roow username"><?= $userinfo['username'] ?>的空间</div>
                        </div>
                        <div class="item-after u-t-nav">
                            <a href="<?=Yii::$app->homeUrl?>" class="link"><i class="fa fa-home"></i></a>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="item-content">
                    <div class="item-inner">
                        <div class="item-media avatar-box">
                            <div class="item-title">
                                <div class="roow"><img src="<?= Ucenter::avatar($uid) ?>"></div>
                            </div>
                        </div>
                        <div class="item-title myuseribox">
                            <div class="roow userititle"><?= $userinfo['username'] ?></div>
                            <div class="roow myuseri">这个人很赖，什么也没有留下！</div>
                        </div>
                        <div class="item-after"></div>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div class="list">
        <ul>
            <li>
                <a class="item-content">
                    <div class="item-media"><i class="fa fa-users" aria-hidden="true"></i></div>
                    <div class="item-inner">
                        <div class="item-text">好友数</div>
                        <div class="item-after">0</div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="list">
        <ul>
            <li>
                <a class="item-content">
                    <div class="item-media"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                    <div class="item-inner">
                        <div class="item-text">邮箱(Email)</div>
                        <div class="item-after"><?=$userinfo['email']?></div>
                    </div>
                </a>
            </li>
            <li>
                <a class="item-content">
                    <div class="item-media"><i class="fa fa-user-plus" aria-hidden="true"></i></div>
                    <div class="item-inner">
                        <div class="item-text">注册时间</div>
                        <div class="item-after"><?=Yii::$app->formatter->asDate($userinfo['addtime'])?></div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="list">
        <ul>
            <li>
                <a class="item-link item-content" href="<?=Yii::$app->request->referrer?>">
                    <div class="item-media"><i class="fa fa-backward" aria-hidden="true"></i></div>
                    <div class="item-inner">
                        <div class="item-text">返回</div>
                        <div class="item-after"></div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>

