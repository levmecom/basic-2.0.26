<?php

use yii\gii\components\ActiveField;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;

AppAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\SettingsModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="block">
    <div class="container">
        <div class="settings-model-form">

            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'moduleidentifier')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])
        ->hint('Please select which set of the templates should be used to generated the code.') ?>

    <?= $form->field($model, 'placeholder')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inputname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inputtype')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inputvalue')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'settings')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'displayorder')->textInput() ?>

    <?= $form->field($model, 'status')->radioList(['开启', '关闭'], ['value'=>intval($model->status)]) ?>

    <?= $form->field($model, 'uptime')->textInput() ?>

    <?= $form->field($model, 'addtime')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton('保 存', ['class' => 'btn btn-success wd100']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
