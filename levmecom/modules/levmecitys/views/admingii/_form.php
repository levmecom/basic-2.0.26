<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;

AppAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\levmecitys\models\Levmecitys */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="block">
    <div class="container">
        <div class="levmecitys-form">

            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'pid')->textInput() ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'streetCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'provinceCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cityCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'areaCode')->textInput(['maxlength' => true]) ?>

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
