<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-08-23 23:01
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

use app\modules\forum\models\ForumForums;

$this->blocks['optable'] = ForumForums::tableName();

$this->title = '论坛版块管理 &raquo; '.(Yii::$app->request->get('opid') <1 ? '添加' : '编辑');

$this->blocks['tips'] = '';

$topForums = ForumForums::find()->where(['rootid'=>0])->indexBy('id')->orderBy(['displayorder'=>SORT_ASC])->asArray()->all();

$forums = ForumForums::find()->indexBy('id')->orderBy(['displayorder'=>SORT_ASC])->asArray()->all();

$info = ForumForums::find()->where(['id'=>intval(Yii::$app->request->get('opid'))])->asArray()->one();

$info['pid'] = Yii::$app->request->get('pid') ?: (isset($info['pid']) ? $info['pid'] : 0);

?>

<form class="list" id="my-form" action="" method="post">
    <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken ?>">
    <ul>
        <li>
            <div class="item-content item-input">
                <div class="item-inner">
                    <div class="item-title item-label">上级版块：</div>
                    <div class="item-input-wrap">
                        <select name="dget[pid]">
                            <option value="0">设为顶级</option>
                            <?php foreach ($forums as $v) : ?>
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
                    <div class="item-title item-label">code：</div>
                    <div class="item-input-wrap">
                        <input type="text" name="dget[code]" value="<?=isset($info['code'])?$info['code']:''?>" placeholder="">
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="item-content item-input">
                <div class="item-inner">
                    <div class="item-title item-label">版块名称：</div>
                    <div class="item-input-wrap">
                        <input type="text" name="dget[name]" value="<?=isset($info['name'])?$info['name']:''?>" placeholder="">
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="item-content item-input">
                <div class="item-inner">
                    <div class="item-title item-label">数据量：</div>
                    <div class="item-input-wrap">
                        <input type="text" name="dget[threads]" value="<?=isset($info['threads'])?$info['threads']:'0'?>" placeholder="">
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


