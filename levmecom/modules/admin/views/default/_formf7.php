<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-09-14 10:03
 *
 * 项目：basic-2.0.26  -  $  - _formf7.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

use app\modules\admin\models\SettingsModel;
use levmecom\aalevme\levHelpers;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$identifier = levHelpers::stripTags(Yii::$app->request->get('identifier'));

$model = new SettingsModel();

$inputs = SettingsModel::find()->where(['moduleidentifier'=>$identifier])->asArray()->all();
?>

<div class="list"><ul>
<?php foreach ($inputs as $v) :?>
    <?php if (in_array($v['inputtype'], ['textarea'])) : ?>
        <li class="item-content item-input item-input-outline">
            <div class="item-inner">
                <div class="item-title item-label"><?=$v['title']?></div>
                <div class="item-input-wrap wd270">
                    <input type="text" name="<?=$v['inputname']?>" placeholder="请输入<?=$v['title']?>">
                    <span class="input-clear-button"></span>
                </div>
                <div class="item-after"><?=$v['placeholder']?></div>
            </div>
        </li>
    <?php else : ?>
        <li class="item-content item-input item-input-outline">
            <div class="item-inner">
                <div class="item-title item-label"><?=$v['title']?></div>
                <div class="item-input-wrap wd270">
                    <input type="text" name="<?=$v['inputname']?>" placeholder="请输入<?=$v['title']?>">
                    <span class="input-clear-button"></span>
                </div>
                <div class="item-after"><?=$v['placeholder']?></div>
            </div>
        </li>
    <?php endif; ?>
<?php endforeach;?>
        <li class="item-content">
            <div class="item-inner">
                <div class="item-title">
                    <input type="submit" name="dosubmit" class="button button-fill color-blue wd100" value=" 保 存 ">
                </div>
            </div>
        </li>
    </ul>
</div>
