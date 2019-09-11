<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-08-18 12:41
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

use yii\helpers\Html;

?>
<title><?=$this->title?></title>
<style>
    body {background: #fff !important;}
    .list.block {max-width: 760px;margin: auto;}
    .alert {padding: 15px;margin-bottom: 20px;border: 1px solid transparent;border-radius: 4px;}
    .button-box .item-after + .item-after {margin-left: 15px;}
    .button-box .item-after + .item-after {margin-left: 15px;}
    .button {text-decoration: none;text-align: center;display: block;color: #fff;padding: 2px 10px;border-radius: 5px;font-size: 14px;background: gray;}
    .item-content.button-box {display: flex;}
    .item-after {margin-left: auto;}
    .button.button-active {background: #007aff;}
    .alert-success {color: #3c763d;background-color: #dff0d8;border-color: #d6e9c6;}
    .alert-error, .alert-danger {color: #a94442;background-color: #f2dede;border-color: #ebccd1;}
    .alert-info {color: #31708f;background-color: #d9edf7;border-color: #bce8f1;}
    .alert-warning, .alert-submit {color: #8a6d3b;background-color: #fcf8e3;border-color: #faebcc;}
</style>
<div class="block list">

    <div class="block"><h1><?= $this->title ?></h1></div>

    <div class="block">
        <div class="alert alert-<?=$name = (isset($name) && $name) ? $name : 'danger'?>">
            <?= isset($message) && $message ? $message : '操作成功！' ?>
        </div>
    </div>

    <div class="list block">
        <div class="item-content button-box">
            <?php if ($name == 'submit') :?>
                <div class="item-after">
                    <a href="<?= $tourl ?>" class="button button-active">确定</a>
                </div>
                <div class="item-after">
                    <a href="<?= Yii::$app->request->referrer ?>" class="button button-fill color-gray">取消</a>
                </div>
            <?php else : ?>
                <div class="item-after">
                    <a href="<?= Yii::$app->homeUrl ?>" class="button button-active">首页</a>
                </div>
                <div class="item-after">
                    <a href="javascript:window.history.back(-1);" class="button button-fill color-gray">后退</a>
                </div>
                <div class="item-after">
                    <a href="<?= $referer ?: Yii::$app->request->referrer ?>" class="button button-fill color-gray">返回</a>
                </div>
                <?php if (isset($tourl) && $tourl) : ?>
                    <div class="item-after">
                        <a href="<?= $tourl ?>" class="button button-active">前往</a>
                    </div>
                <?php endif;?>
            <?php endif;?>
        </div>
    </div>
</div>
