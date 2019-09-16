<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-08-21 13:17
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

use app\modules\forum\models\ForumForums;

use yii\data\Pagination;

$this->title = '论坛版块管理';

$this->blocks['tips'] = '';

$this->blocks['addhref'] = true;//设置true = Url::current(['add'=>1])

$this->blocks['deleteIcon'] = '';//是否显示删除图标，不需要注释掉

$this->blocks['deleteDayFormAction'] = '';
$this->blocks['deleteDay'] = 'addtime';

$this->blocks['dateSearch'] = 'addtime';

$where = isset($where) && $where ? $where : '';

$topForums = ForumForums::find()->where(['rootid'=>0])->indexBy('id')->orderBy(['displayorder'=>SORT_ASC, 'id'=>SORT_ASC])->asArray()->all();

$forums = ForumForums::find()->where($where)->indexBy('id')->orderBy(['displayorder'=>SORT_ASC, 'id'=>SORT_ASC])->asArray()->all();

$lists = ForumForums::find()->indexBy('id')->orderBy(['displayorder'=>SORT_ASC])->asArray()->all();

$this->blocks['pages'] = ' <absx>共'.count($lists).'条</absx>';

$srh = Yii::$app->request->get('srh');

?>
<?php $this->beginBlock('searchForm')?>
<form name="searchbarForm" method="get" class="searchbar tooltip-init searchbar-init" data-search-in=".tree-name" data-search-container=".search-list" data-search-group=".accordion-item" data-tooltip="联合搜索 - 回车执行搜索" style='min-width:320px'>
    <div class="searchbar-inner">
        <div class="item-after">
            <input type="text" name="srh[code]" value="<?=!isset($srh['code'])?'':$srh['code']?>" placeholder="code" style="width:80px;">
        </div>
        <div class="item-after"><div class="searchbar-input-wrap">
            <input type="search" name="srh[name]" value="<?=isset($srh['name'])?$srh['name']:''?>" placeholder="搜版块名称" class="search-input">
            <i class="searchbar-icon"></i>
            <span class="input-clear-button"></span>
        </div>
        </div>
    </div>
</form>
<?php $this->endBlock()?>


<div class="data-table data-table-init card">

    <form name="dataTableForm" action="">
        <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>">
    <div class="card-content">
        <div class="list accordion-list">
            <ul><li class="searchbar-ignore">
        <div class="item-link item-content">
            <div class="item-media"></div>
            <div class="item-inner">
        <table>
            <thead>
            <tr>
                <th class="label-cell tree-name">名称</th>
                <th class="checkbox-cell"><label class="checkbox"><input name="ids[]" type="checkbox"><i class="icon-checkbox"></i></label></th>
                <th class="tab-center wd60"><input class="dorder" type="text" value="排序" disabled></th>
                <th class="tab-center wd100">版块ID</th>
                <th class="tab-center wd60">子版块</th>
                <th class="tab-center wd100">Code</th>
                <th class="numeric-cell wd100">数据量</th>
                <th class="tab-center wd60">状态</th>
                <th class="actions-cell" style="width: 200px">操作</th>
            </tr>
            </thead>
        </table>
            </div>
        </div></li>
            </ul>
            <ul class="search-list searchbar-found">
            <?= \levmecom\widgets\tree\tree::widget(['data'=>$forums, 'template' => '@app/modules/forum/views/admin/forumsTree'])?>
            </ul>
        </div>
    </div>
    </form>
    <div class="card-footer">
        <div class="data-table-header" style="width: 100%;text-align: center;">
            <div class="list searchbar-not-found" style="width: 100%;font-size: 24px;color: rgba(0,0,0,0.2);">
                    没有搜索到结果
            </div>
        </div>
    </div>

</div>
