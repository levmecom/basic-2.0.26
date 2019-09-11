<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-08-26 11:33
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */


/* @var $this \yii\web\View */

use app\modules\navigation\models\Navigation;

$this->blocks['optable'] = Navigation::tableName();

$this->title = '导航管理 &raquo; '.(Yii::$app->request->get('opid') <1 ? '添加' : '编辑');

$this->blocks['tips'] = '导航主要依赖【导航分类】在页面各个位置分别调用';

$types = Navigation::types();
$positions = Navigation::positions();
$navs = Navigation::navs();
$targets = Navigation::targets();

$info = Navigation::find()->where(['id'=>intval(Yii::$app->request->get('opid'))])->asArray()->one();

$info['pid'] = intval(Yii::$app->request->get('pid') ?: (isset($info['pid']) ? $info['pid'] : 0));
if ($info['pid'] && !isset($info['id'])) {
    $pinfo = Navigation::find()->where(['id'=>$info['pid']])->asArray()->one();
    $info['typeid'] = $pinfo ? $pinfo['typeid'] : 0;
}

$info['typeid'] = Yii::$app->request->get('typeid') ?: (isset($info['typeid']) ? $info['typeid'] : 0);

?>

<form class="list" id="my-form" action="" method="post">
    <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken ?>">
    <ul>
        <li>
            <div class="item-content item-input">
                <div class="item-inner">
                    <div class="item-title item-label">导航分类：</div>
                    <div class="item-input-wrap input-dropdown-wrap">
                        <select name="dget[typeid]">
                            <?php foreach ($types as $v) : ?>
                                <?php $sld = isset($info['typeid']) && $info['typeid'] ==$v['id'] ? 'selected' : ''?>
                                <option value="<?=$v['id']?>" <?=$sld?>><?=$v['name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="item-content item-input">
                <div class="item-inner">
                    <div class="item-title item-label">上级导航：</div>
                    <div class="item-input-wrap input-dropdown-wrap">
                        <select name="dget[pid]">
                            <option value="0">设为顶级</option>
                            <?php foreach ($navs as $v) : ?>
                                <?php $sld = isset($info['pid']) && $info['pid'] ==$v['id'] ? 'selected' : ''?>
                                <option value="<?=$v['id']?>" <?=$sld?>><?=$v['name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="item-content item-input">
                <div class="item-inner">
                    <div class="item-title item-label">模块标识符：</div>
                    <div class="item-input-wrap">
                        <input type="text" name="dget[moduleidentifier]" value="<?=isset($info['moduleidentifier'])?$info['moduleidentifier']:''?>" placeholder="随模块一同卸载">
                    </div>
                </div>
            </div>
        </li>
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
                    <div class="item-title item-label">图标：</div>
                    <div class="item-input-wrap">
                        <input type="text" name="dget[icon]" value="<?=isset($info['icon'])?$info['icon']:''?>" placeholder="可以是图片地址，也可以是图标（如：fa-home -> 'fa-'开头视为图标）">
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="item-content item-input">
                <div class="item-inner">
                    <div class="item-title item-label">链接地址：</div>
                    <div class="item-input-wrap">
                        <input type="text" name="dget[link]" value="<?=isset($info['link'])?$info['link']:''?>" placeholder="">
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="item-content item-input">
                <div class="item-inner">
                    <div class="item-title item-label">打开方式：</div>
                    <div class="item-input-wrap">
                        <select name="dget[target]">
                            <?php foreach ($targets as $v) : ?>
                                <?php $sld = isset($info['target']) && $info['target'] ==$v['target'] ? 'selected' : ''?>
                                <option value="<?=$v['target']?>" <?=$sld?>><?=$v['name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="item-content item-input">
                <div class="item-inner">
                    <div class="item-title item-label">显示位置：<tips>【右侧】位置只能是子导航</tips></div>
                    <div class="item-input-wrap">
                        <select name="dget[position]">
                            <?php foreach ($positions as $v) : ?>
                                <?php $sld = isset($info['position']) && $info['position'] ==$v['id'] ? 'selected' : ''?>
                                <option value="<?=$v['id']?>" <?=$sld?>><?=$v['name'],(isset($v['descs']) && $v['descs'] ? ' （'.$v['descs'].'）' : '')?></option>
                            <?php endforeach; ?>
                        </select>
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
