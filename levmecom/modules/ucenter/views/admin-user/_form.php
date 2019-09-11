<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;

AppAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\ucenter\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="block">
    <div class="container">
        <div class="user-form">

            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->radioList(['开启', '关闭'], ['value'=>intval($model->status)]) ?>

    <?= $form->field($model, 'addtime')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton('保 存', ['class' => 'btn btn-success wd100']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
