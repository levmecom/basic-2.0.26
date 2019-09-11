<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\ForumForums */
/* @var $form ActiveForm */
?>
<div class="list">
<div class="install">
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

        <?= $form->field($model, 'pid') ?>
        <?= $form->field($model, 'rootid') ?>
        <?= $form->field($model, 'threads') ?>
        <?= $form->field($model, 'displayorder') ?>
        <?= $form->field($model, 'status') ?>
        <?= $form->field($model, 'uptime') ?>
        <?= $form->field($model, 'addtime') ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'code') ?>
        <?= $form->field($model, 'descs') ?>
    
        <li class="item-content item-input item-input-with-info">
            <?= Html::submitButton(' 保 存 ', ['class' => 'button button-active wd100']) ?>
        </li>
    <?php ActiveForm::end(); ?>
</ul>
</div>
</div><!-- install -->
