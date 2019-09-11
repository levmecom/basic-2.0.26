<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\crud\Generator */

echo $form->field($generator, 'modelPageTitle');
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
echo $form->field($generator, 'viewPath');
echo $form->field($generator, 'baseControllerClass');
echo $form->field($generator, 'indexWidgetType')->dropDownList([
    'grid' => 'GridView',
    'list' => 'ListView',
]);
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'enablePjax')->checkbox();
echo $form->field($generator, 'messageCategory');

?>

<?=
$this->registerJs(<<<JS
    jQuery(function () {
        jQuery(document).on('change', '#generator-modelclass', function () {
            var searchModelClass = this.value + 'Search';
            jQuery('#generator-searchmodelclass').val(searchModelClass);
            var controllerClass = this.value.replace('models\\\', 'controllers\\\Admin') + 'Controller';
            jQuery('#generator-controllerclass').val(controllerClass);
        })
    });
JS
);
?>