<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\module\Generator */

?>
<div class="module-form">
<?=
     $form->field($generator, 'moduleClass'),
     $form->field($generator, 'moduleID'),
     $form->field($generator, 'moduleName'),
     $form->field($generator, 'moduleDescs'),
     $form->field($generator, 'moduleCopyright'),
     $form->field($generator, 'moduleVersion')
?>
</div>
