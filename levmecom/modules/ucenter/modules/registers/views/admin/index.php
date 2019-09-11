<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-08-18 22:09
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

/* @var $this \yii\web\View */

use app\modules\ucenter\modules\registers\models\UcenterRegisters;
use yii\data\Pagination;
use yii\helpers\Url;

$this->title = '批量注册用户管理';

$this->blocks['tips'] = '';

$this->blocks['addhref'] = true;//设置true = Url::current(['add'=>1])

$this->blocks['deleteIcon'] = '';//是否显示删除图标，不需要注释掉

$this->blocks['deleteDayFormAction'] = '';
$this->blocks['deleteDay'] = 'addtime';

$this->blocks['dateSearch'] = 'addtime';

$this->blocks['pages'] = true;

$types = UcenterRegisters::getType();

$where = 'uid > 0'.(isset($where) && $where ? ' AND '.$where : '');

$this->blocks['pageSize'] = \levmecom\aalevme\levHelpers::pageSize(20);

$data = UcenterRegisters::find()->where($where);
$pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => $this->blocks['pageSize']]);
$lists = $data->offset($pages->offset)->limit($pages->limit)->asArray()->all();
$this->blocks['pages'] = \yii\widgets\LinkPager::widget(['pagination' => $pages, 'firstPageLabel' => true, 'lastPageLabel' => true, 'maxButtonCount' => 8, 'disableCurrentPageButton' => true]).' <absx>共'.$data->count().'条</absx>';

$srh = Yii::$app->request->get('srh');

?>
<?php $this->beginBlock('searchForm')?>
<form name="searchbarForm" method="get" class="searchbar tooltip-init" data-tooltip="联合搜索 - 回车执行搜索" style='min-width:320px'>
    <div class="searchbar-inner">
        <input type="text" name="srh[uid]" value="<?=!isset($srh['uid'])?'':$srh['uid']?>" placeholder="UID" style="width: 40px;">
        <div class="input input-dropdown" style="width: 120px;">
            <select name="srh[typeid]">
                <option value="">分类筛选</option>
                <?php foreach ($types as $v) : ?>
                    <option value="<?=$v['id']?>" <?=isset($srh['typeid']) && is_numeric($srh['typeid']) && $srh['typeid'] ==$v['id']?'selected':''?>><?=$v['name']?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="searchbar-input-wrap">
            <input type="search" name="srh[username]" value="<?=isset($srh['username'])?$srh['username']:''?>" placeholder="搜用户名" class="search-input">
            <i class="searchbar-icon"></i>
            <span class="input-clear-button"></span>
        </div>
    </div>
</form>
<?php $this->endBlock()?>

<div class="data-table data-table-init card">
    <form name="dataTableForm" action="<?=Yii::$app->homeUrl?>admin/default/admin-delete">
        <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>">
        <div class="card-content">
            <table>
                <thead>
                <tr>
                    <th class="checkbox-cell">
                        <label class="checkbox"><input name="ids[]" type="checkbox"><i class="icon-checkbox"></i></label></th>
                    <th class="numeric-cell wd60">
                        <div class="table-head-label numeric-cell sortable-cell">分类ID</div>
                    </th>
                    <th class="input-cell label-cell">
                        <div class="table-head-label sortable-cell">所属分类</div>
                    </th>
                    <th class="input-cell numeric-cell">
                        <div class="table-head-label sortable-cell numeric-cell">UID</div>
                    </th>
                    <th class="input-cell label-cell">
                        <div class="table-head-label sortable-cell">昵称</div>
                    </th>
                    <th class="input-cell tab-center">
                        <div class="table-head-label sortable-cell numeric-cell">状态</div>
                    </th>
                    <th class="input-cell numeric-cell">
                        <div class="table-head-label sortable-cell numeric-cell">创建时间</div>
                    </th>
                    <th class="actions-cell">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($lists as $k => $v) : ?>
                    <tr>
                        <td class="checkbox-cell">
                            <label class="checkbox"><input name="ids[]" value="<?=$v['id']?>" type="checkbox"><i class="icon-checkbox"></i></label>
                        </td>
                        <td class="numeric-cell"><?=$v['typeid']?></td>
                        <td class="label-cell"><a class="link" href="<?=Url::current(['_dy'=>1, 'srh'=>['typeid'=>$v['typeid']]])?>"><?=$types[$v['typeid']]['name']?></a></td>
                        <td class="numeric-cell"><?=$v['uid']?></td>
                        <td class="label-cell"><?=$v['username']?></td>
                        <td class="tab-center">
                            <label class="toggle toggle-status color-green setStatus" opid="<?=$v['id']?>">
                                <input type="checkbox" <?=$v['status']?'':'checked'?>>
                                <span class="toggle-icon"></span>
                            </label>
                        </td>
                        <td class="numeric-cell date">
                            <?=Yii::$app->formatter->asDatetime($v['addtime'], 'short')?>
                        </td>
                        <td class="actions-cell">
                            <a class="link" href="<?=Url::current(['add'=>1,'opid'=>$v['id']])?>" target="_screen"><absxb>编辑</absxb></a>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </form>
    <div class="card-footer">
        <div class="data-table-footer"></div>
    </div>
</div>






