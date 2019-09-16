<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-09-01 13:06
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

/* @var $this \yii\web\View */

use app\assets\AppAsset;
use app\modules\admin\models\SettingsModel;
use app\modules\adminModules\models\AdminModulesModel;
use levmecom\aalevme\levHelpers;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

AppAsset::register($this);

$identifier = levHelpers::stripTags(Yii::$app->request->get('identifier'));
$mdinfo = AdminModulesModel::find()->where(['identifier'=>$identifier])->asArray()->one();

$model = new SettingsModel();

$inputs = SettingsModel::find()->where(['moduleidentifier'=>$identifier])->asArray()->all();

//$this->blocks['tips'] = '按住Control多选';
$this->title = $mdinfo ? $mdinfo['name'].'设置' : '全局设置';
?>
<style>.color-picker-hex-wrap {position: absolute;top: 0;right: 0;}</style>
<div class="block">
    <div class="container">
        <div class="settings-model-form is-set-val">

            <?php $form = ActiveForm::begin(['id' => 'saveSettings']); ?>

            <?php foreach ($inputs as $v) :?>
                <div class="form-group item-content field-settingsmodel-<?=$v['inputname']?>">
                    <div class="item-title">
                        <label class="control-label" for="settingsmodel-<?=$v['inputname']?>"><?=$v['title']?></label>
                        <?= SettingsModel::inputHtml($v) ?>
                    </div>
                    <div class="item-after"><div class="hint-block"><?=$v['placeholder']?></div></div>
                </div>
            <?php endforeach;?>

            <div class="form-group item-content">
                <?= Html::submitButton('保 存', ['class' => 'btn btn-success wd100', 'id'=>'dosubmit', 'onclick'=>'doSaveSettings()']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>

<script>
    function doSaveSettings() {
        jQuery('form#saveSettings').ajaxSubmit({
            url: '',
            data: {dosubmit:1,_:Math.random()},
            type:'post',
            dataType: 'json',
            success: function(data){
                F7app.preloader.hide();
                if (parseInt(data.status) >0) {
                    levtoast(data.message);
                    window.setTimeout(function () {
                        window.location = window.location;
                    }, 200);
                }else if (data && data.message) {
                    levtoast(data.message, 15000);
                }
                showFormErrors(data.errors);
            },
            error: function(data) {
                F7app.preloader.hide();
                errortips(data);
            }
        });
        return false;
    }
</script>
<script>
    var colorPickerRgba = [];
    function setColor(inputname, val) {
        val = val ? val : '#ffffff99';
        var hex = val.substr(0, 7);
        var alpha = '0.'+val.substr(7, 2);
        if (typeof colorPickerRgba[inputname] != 'undefined') {
            return colorPickerRgba[inputname].open();
        }
        colorPickerRgba[inputname] = F7app.colorPicker.create({
            inputEl: 'input[name='+inputname+'].color-input-rgba',
            targetEl: '#'+inputname+'-color-picker-rgba-value',
            targetElSetBackgroundColor: true,
            modules: ['wheel', 'alpha-slider', 'hex'],
            openIn: 'popover',
            sliderValue: true,
            sliderLabel: true,
            value: {
                hex: hex,
                alpha: alpha,
            },
            formatValue: function (value) {
                console.log(value);
                var alphax = value.alpha;
                alphax = alphax == "1" ? '' : (alphax == "0" ? "00" : alphax);
                return value.hex + alphax.toString().replace('0.', '');
            },
        });
        colorPickerRgba[inputname].open();
    }
</script>

