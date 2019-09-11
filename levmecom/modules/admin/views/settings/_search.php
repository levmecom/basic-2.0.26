<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\SettingsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="settings-model-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'moduleidentifier') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'placeholder') ?>

    <?= $form->field($model, 'inputname') ?>

    <?php // echo $form->field($model, 'inputtype') ?>

    <?php // echo $form->field($model, 'inputvalue') ?>

    <?php // echo $form->field($model, 'settings') ?>

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
