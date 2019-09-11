<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<style>
    .list.block {max-width:760px;margin: auto;}
    .alert-danger {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
    }
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    .button-box .item-after + .item-after {margin-left:15px;}
</style>
<div class="block list">

    <div class="block"><h1><?= Html::encode($this->title) ?></h1></div>

    <div class="block">
        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>
    </div>

    <div class="list block">
        <div class="item-content button-box">
            <div class="item-after">
                <a href="<?=Yii::$app->homeUrl?>" class="button button-active">首页</a>
            </div>
            <div class="item-after">
                <a href="javascript:window.history.back(-1);" class="button button-fill color-gray">后退</a>
            </div>
            <div class="item-after">
                <a href="<?=Yii::$app->request->referrer?>" class="button button-fill color-gray">返回</a>
            </div>
        </div>
    </div>
</div>
