<?php
/**
 * This is the template for generating an action view file.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\form\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form ActiveForm */
<?= "?>" ?>

<div class="list">
<div class="<?= str_replace('/', '-', trim($generator->viewName, '_')) ?>">
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

    <?php foreach ($generator->getModelAttributes() as $attribute): ?>
    <?= "<?= " ?>$form->field($model, '<?= $attribute ?>') ?>
    <?php endforeach; ?>

        <li class="item-content item-input item-input-with-info">
            <?= "<?= " ?>Html::submitButton(<?= $generator->generateString(' 保 存 ') ?>, ['class' => 'button button-active wd100']) ?>
        </li>
    <?= "<?php " ?>ActiveForm::end(); ?>
</ul>
</div><!-- <?= str_replace('/', '-', trim($generator->viewName, '-')) ?> -->
</div>