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

use app\modules\ucenter\modules\registers\models\UcenterRegisters;

$this->blocks['optable'] = UcenterRegisters::tableName();

$types = UcenterRegisters::getType();

$this->title = '批量注册分类管理 &raquo; '.(Yii::$app->request->get('opid') <1 ? '添加' : '编辑');

$this->blocks['tips'] = '';

$info = UcenterRegisters::find()->where(['id'=>intval(Yii::$app->request->get('opid'))])->asArray()->one();

?>

<form class="list" id="my-form" action="" method="post">
    <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken ?>">
    <ul>
        <li>
            <div class="item-content item-input">
                <div class="item-inner">
                    <div class="item-title item-label">分类名称：</div>
                    <div class="item-input-wrap">
                        <input type="text" name="dget[name]" value="<?=isset($info['name'])?$info['name']:''?>" placeholder="留空不修改">
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
                                <input type="radio" name="dget[status]" value="0" <?=isset($info['status']) && !$info['status'] || !isset($info['status']) ? 'checked':''?>><i class="icon-radio"></i>开启
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


