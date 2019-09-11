<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View 12345 */
/* @var $model app\modules\ucenter\modules\registers\models\UcenterRegisters */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="list">
<div class="ucenter-registers-form">
    <ul>

        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'options' => ['tag'=>'li', 'class'=>'item-content item-input item-input-with-info'],
                'template' => '<div class="item-inner">
                    <div class="item-title item-label">{label}</div>
                    <div class="item-input-wrap">
                        {input}
                        <span class="input-clear-button"></span>
                        <div class="item-input-info">{error}</div>
                    </div>
                </div>',
            ]
        ]); ?>

            <?= $form->field($model, 'typeid')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uid')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->radioList(['开启', '关闭'], ['value'=>intval($model->status)]) ?>

    <?= $form->field($model, 'addtime')->textInput() ?>

        <li class="item-content item-input item-input-with-info">
            <?= Html::submitButton(' 保 存 ', ['class' => 'button button-active wd100']) ?>
        </li>

        <?php ActiveForm::end(); ?>

    </ul>
</div>
</div>