<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\levmecitys\models\LevmecitysSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="levmecitys-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pid') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'streetCode') ?>

    <?php // echo $form->field($model, 'provinceCode') ?>

    <?php // echo $form->field($model, 'cityCode') ?>

    <?php // echo $form->field($model, 'areaCode') ?>

    <?php // echo $form->field($model, 'displayorder') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'uptime') ?>

    <?php // echo $form->field($model, 'addtime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
