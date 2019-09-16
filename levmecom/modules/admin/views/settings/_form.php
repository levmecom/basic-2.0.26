<?php

use app\modules\admin\models\SettingsModel;
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
        <div class="settings-model-form is-set-val">

            <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->hint('中英文均可，用于显示在插件配置的菜单中') ?>

    <?= $form->field($model, 'placeholder')->textInput(['maxlength' => true])->hint('详细的描述有利于使用者了解这个设置的作用') ?>

    <?= $form->field($model, 'inputname')->textInput(['maxlength' => true])->hint('设置项变量名，用于程序中调用') ?>

    <?= $form->field($model, 'inputtype')->dropDownList(SettingsModel::inputtype(),['onchange'=>'inputtypeChange()'])->hint('设置项数据类型，用于程序中检查和过滤相应配置值') ?>

    <?= $form->field($model, 'inputvalue')->textInput(['maxlength' => true])->hint('设置项默认值') ?>

    <?= $form->field($model, 'settings')->textarea(['rows' => 6])->hint('只在配置类型为“选择(select)”时有效，用于设定选项值。等号前面为选项索引(建议用数字)，后面为内容，例如:
1 = 光电鼠标
2 = 机械鼠标
3 = 没有鼠标
注意: 选项确定后请勿修改索引和内容的对应关系，但仍可以新增选项。如需调换显示顺序，可以通过移动整行的上下位置来实现') ?>

    <?= $form->field($model, 'displayorder')->textInput()->hint('显示顺序') ?>

            <div class="form-group">
                <?= Html::submitButton('保 存', ['class' => 'btn btn-success wd100']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>

<?=$this->registerJs('inputtypeChange()')?>
<script>
    function inputtypeChange() {
        var _val = jQuery('.field-settingsmodel-inputtype select').val();
        if (_val == 'select' || _val == 'selects') {
            jQuery('.field-settingsmodel-settings').show();
        } else {
            jQuery('.field-settingsmodel-settings').hide();
        }
    }
</script>