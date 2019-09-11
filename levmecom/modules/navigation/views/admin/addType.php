<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-08-26 16:34
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */


/* @var $this \yii\web\View */

use app\modules\navigation\models\Navigation;

$this->blocks['optable'] = Navigation::tableName();

$this->title = '导航分类管理 &raquo; '.(Yii::$app->request->get('opid') <1 ? '添加' : '编辑');

$this->blocks['tips'] = '导航主要依赖【导航分类】在页面各个位置分别调用';

$types = Navigation::types();
$positions = Navigation::positions();
$navs = Navigation::navs();
$targets = Navigation::targets();

$info = Navigation::find()->where(['id'=>intval(Yii::$app->request->get('opid'))])->asArray()->one();

?>

<form class="list" id="my-form" action="" method="post">
    <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken ?>">
    <ul>
        <li>
            <div class="item-content item-input">
                <div class="item-inner">
                    <div class="item-title item-label">名称：</div>
                    <div class="item-input-wrap">
                        <input type="text" name="dget[name]" value="<?=isset($info['name'])?$info['name']:''?>" placeholder="">
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="item-content item-input">
                <div class="item-inner">
                    <div class="item-title item-label">描述：</div>
                    <div class="item-input-wrap">
                        <textarea name="dget[descs]" value="<?=isset($info['descs'])?$info['descs']:''?>" placeholder=""></textarea>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="item-content item-input">
                <div class="item-inner">
                    <div class="item-title item-label">排序：</div>
                    <div class="item-input-wrap">
                        <input type="text" name="dget[displayorder]" value="<?=isset($info['displayorder'])?$info['displayorder']:'0'?>">
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="item-content item-input">
                <div class="item-inner">
                    <div class="item-title item-label">状态：</div>
                    <div class="item-input-wrap">
                        <label class="radio"><div class="item-after">
                                <input type="radio" name="dget[status]" value="0" <?=isset($info['status']) && !$info['status'] || !isset($info['status']) ?'checked':''?>><i class="icon-radio"></i>开启
                            </div>
                        </label>
                        <label class="radio"><div class="item-after">
                                <input type="radio" name="dget[status]" value="1" <?=isset($info['status']) && $info['status']?'checked':''?>><i class="icon-radio"></i>关闭
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="item-content item-input">
                <div class="item-inner">
                    <div class="item-input">
                        <input type="submit" class="button button-active" id="dosubmit" name="dosubmit" value=" 提 交 ">
                    </div>
                </div>
            </div>
        </li>
    </ul>
</form>
