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
/* @var $where string */

use app\modules\navigation\models\Navigation;
use app\modules\navigation\Module;
use yii\data\Pagination;
use yii\helpers\Url;

$srh = Yii::$app->request->get('srh');

$setWhere = 'typeid!=0';

$this->title = '导航管理';

$this->blocks['tips'] = '';

$this->blocks['addhref'] = true;//设置true = Url::current(['add'=>1])

$this->blocks['deleteIcon'] = '';//是否显示删除图标，不需要注释掉

$this->blocks['deleteDayFormAction'] = '';
$this->blocks['deleteDay'] = 'addtime';

$this->blocks['dateSearch'] = 'addtime';

$types = Navigation::types();
$positions = Navigation::positions();
$targets = Navigation::targets();

$wheres = $setWhere.(isset($where) && $where ? ' AND '.$where : '');

$this->blocks['pageSize'] = \levmecom\aalevme\levHelpers::pageSize(200);

$data = Navigation::find()->where($wheres);
$pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => $this->blocks['pageSize']]);
$lists = $data->offset($pages->offset)->limit($pages->limit)->orderBy(['id'=>SORT_DESC])->asArray()->all();
$this->blocks['pages'] = \yii\widgets\LinkPager::widget(['pagination' => $pages, 'firstPageLabel' => true, 'lastPageLabel' => true, 'maxButtonCount' => 8, 'disableCurrentPageButton' => true]).' <absx>共'.$data->count().'条</absx>';

$insql = \levmecom\aalevme\levHelpers::inSqlArray($lists, 'pid');
if ($insql) {
    $pids = Navigation::find()->where(['in', 'id', $insql])->indexBy('id')->asArray()->all();
}
$pids[0] = ['id'=>0, 'name'=>'顶级', 'link'=>'#', 'icon'=>''];

?>
<?php $this->beginBlock('searchForm')?>
<form name="searchbarForm" method="get" class="searchbar tooltip-init" data-tooltip="联合搜索 - 回车执行搜索" style="min-width:340px">
    <div class="searchbar-inner">
        <input type="text" name="srh[moduleidentifier]" class="wd80" value="<?=!isset($srh['moduleidentifier'])?'':$srh['moduleidentifier']?>" placeholder="模块标识符">
        <div class="input input-dropdown input-dropdown-wrap wd150">
            <select name="srh[fid]" placeholder="分类筛选">
                <option value="">分类筛选</option>
                <?php foreach ($types as $v) : ?>
                    <option value="<?=$v['id']?>" <?=isset($srh['typeid']) && $srh['typeid'] ==$v['id']?'selected':''?>><?=$v['name']?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="searchbar-input-wrap">
            <input type="search" name="srh[name]" value="<?=isset($srh['name'])?$srh['name']:''?>" placeholder="名称检索" class="search-input">
            <i class="searchbar-icon"></i>
            <span class="input-clear-button"></span>
        </div>
    </div>
</form>
<?php $this->endBlock()?>

<div class="data-table data-table-init card list">
    <form name="dataTableForm" action="<?=Yii::$app->homeUrl?>admin/default/admin-delete">
        <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>">
        <div class="card-content">
            <table>
                <thead>
                <tr>
                    <th class="checkbox-cell">
                        <label class="checkbox"><input name="ids[]" type="checkbox"><i class="icon-checkbox"></i></label></th>
                    <th class="tab-center wd60">排序</th>
                    <th class="label-cell wd100">所属分类</th>
                    <th class="label-cell wd100">模块标识符</th>
                    <th class="label-cell wd120">上级导航</th>
                    <th class="tab-center wd60">图标</th>
                    <th class="label-cell wd120">名称 <i class="fa fa-external-link-square" aria-hidden="true"></i></th>
                    <th class="label-cell ellipsis">简短描述</th>
                    <th class="label-cell wd60">target</th>
                    <th class="tab-center wd60">位置</th>
                    <th class="tab-center wd60">状态</th>
                    <th class="actions-cell">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($lists as $k => $v) : ?>
                    <tr>
                        <td class="checkbox-cell">
                            <label class="checkbox"><input name="ids[]" value="<?=$v['id']?>" type="checkbox"><i class="icon-checkbox"></i></label>
                        </td>
                        <td class="tab-center wd60"><input class="dorder setField" type="text" name="displayorder" opid="<?=$v['id']?>" value="<?=$v['displayorder']?>"></td>
                        <td class="label-cell item-content">
                            <div class="item-text">
                            <a class="link" href="<?=Url::current(['srh'=>['typeid'=>$v['typeid']]])?>">[<?=$v['typeid']?>] <?=$types[$v['typeid']]['name']?></a>
                            </div>
                            <div class="item-after tooltip-init" data-tooltip="添加此分类下导航">
                                <a class="link" href="<?=Url::current(['add'=>1, 'typeid'=>$v['typeid']])?>"><i class="fa fa-plus"></i></a>
                            </div>
                        </td>
                        <td class="label-cell"><a class="link" href="<?=Url::current(['srh'=>['moduleidentifier'=>$v['moduleidentifier']]])?>"><?=$v['moduleidentifier']?></a></td>
                        <td class="label-cell item-content">
                            <div class="item-text">
                                <a class="link" href="<?=Url::current(['srh'=>['pid'=>$v['pid']]])?>"><?=$pids[$v['pid']]['name']?></a>
                            </div>
                            <div class="item-after tooltip-init" data-tooltip="添加子导航">
                                <a class="link" href="<?=Url::current(['add'=>1, 'pid'=>$pids[$v['pid']]['id']])?>"><i class="fa fa-plus"></i></a>
                            </div>
                        </td>
                        <td class="tab-center"><?=Module::icon($v['icon'])?></td>
                        <td class="label-cell item-content" title="<?=$v['link']?>">
                            <div class="item-text">
                            <a class="link external" target="_blank" href="<?=Module::link($v['link'])?>"><?=$v['name']?></a>
                            </div>
                            <div class="item-after tooltip-init" data-tooltip="添加子导航">
                                <a class="link" href="<?=Url::current(['add'=>1, 'pid'=>$v['id']])?>"><i class="fa fa-plus"></i></a>
                            </div>
                        </td>
                        <td class="label-cell ellipsis"><?=$v['descs']?></td>
                        <td class="label-cell"><?=$targets[$v['target']]['name']?></td>
                        <td class="tab-center"><?=$positions[$v['position']]['name']?></td>
                        <td class="tab-center">
                            <label class="toggle toggle-status color-green setStatus" opid="<?=$v['id']?>">
                                <input type="checkbox" <?=$v['status']?'':'checked'?>>
                                <span class="toggle-icon"></span>
                            </label>
                        </td>
                        <td class="actions-cell">
                            <a class="link" href="<?=Url::current(['add'=>1,'opid'=>$v['id']])?>"><absxb>编辑</absxb></a>
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
