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

$this->title = '批量注册用户 &raquo; 编辑';

$this->blocks['tips'] = '【注意】批量注册用户不能通过密码登陆，仅供系统程序调用';

$info = UcenterRegisters::find()->where(['id'=>intval(Yii::$app->request->get('opid'))])->asArray()->one();

?>

<form class="list" id="my-form" action="" method="post">
    <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken ?>">
    <ul>
        <li>
            <div class="item-content item-input">
                <div class="item-inner">
                    <div class="item-title item-label">UID：</div>
                    <div class="item-input-wrap">
                        <input type="text" name="dget[uid]" value="<?=isset($info['uid'])?$info['uid']:''?>" placeholder="用户UID">
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="item-content item-input">
                <div class="item-inner">
                    <div class="item-title item-label">所属分类：</div>
                    <div class="item-input-wrap">
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
                    <div class="item-title item-label">昵称：</div>
                    <div class="item-input-wrap">
                        <input type="text" name="dget[username]" value="<?=isset($info['username'])?$info['username']:''?>" placeholder="">
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


