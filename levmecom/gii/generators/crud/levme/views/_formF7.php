<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View 12345 */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="list">
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
    <ul>

        <?= "<?php " ?>$form = ActiveForm::begin([
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

        <?php foreach ($generator->getColumnNames() as $attribute) {
            if (in_array($attribute, $safeAttributes)) {
                echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
            }
        } ?>
        <li class="item-content item-input item-input-with-info">
            <?= "<?= " ?>Html::submitButton(<?= $generator->generateString(' 保 存 ') ?>, ['class' => 'button button-active wd100']) ?>
        </li>

        <?= "<?php " ?>ActiveForm::end(); ?>

    </ul>
</div>
</div>