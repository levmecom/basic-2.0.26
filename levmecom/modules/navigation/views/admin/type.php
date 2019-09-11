<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-08-23 17:35
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

use app\modules\navigation\models\Navigation;
use yii\data\Pagination;
use yii\helpers\Url;

$setWhere = 'typeid=0';//同表不同数据（例：分类）

$this->title = '导航分类管理';

$this->blocks['tips'] = '【提示】1.删除分类不会删除导航；2.通过分类ID在不同位置调用导航';

$this->blocks['addhref'] = true;//设置true = Url::current(['add'=>1])

$this->blocks['deleteIcon'] = '';//是否显示删除图标，不需要注释掉

$this->blocks['deleteDay'] = 'addtime';

$this->blocks['dateSearch'] = 'addtime';

$wheres = $setWhere.(isset($where) && $where ? ' AND '.$where : '');

$this->blocks['pageSize'] = \levmecom\aalevme\levHelpers::pageSize(200);

$data = Navigation::find()->where($wheres);
$pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => $this->blocks['pageSize']]);
$lists = $data->offset($pages->offset)->limit($pages->limit)->orderBy(['displayorder'=>SORT_ASC, 'id'=>SORT_DESC])->asArray()->all();
$this->blocks['pages'] = \yii\widgets\LinkPager::widget(['pagination' => $pages, 'firstPageLabel' => true, 'lastPageLabel' => true, 'maxButtonCount' => 8, 'disableCurrentPageButton' => true]).' <absx>共'.$data->count().'条</absx>';

$srh = Yii::$app->request->get('srh');

?>
<?php $this->beginBlock('searchForm')?>
<form name="searchbarForm" method="get" class="searchbar tooltip-init" data-tooltip="联合搜索 - 回车执行搜索" style="min-width:160px">
    <div class="searchbar-inner">
        <div class="searchbar-input-wrap">
            <input type="search" name="srh[name]" value="<?=isset($srh['name'])?$srh['name']:''?>" placeholder="搜分类名称" class="search-input">
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
                    <th class="numeric-cell wd60">分类ID</th>
                    <th class="label-cell wd220">分类名称</th>
                    <th class="tab-center wd100">导航数</th>
                    <th class="tab-center">状态</th>
                    <th class="numeric-cell">创建时间</th>
                    <th class="actions-cell wd220">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($lists as $k => $v) : ?>
                    <tr>
                        <td class="checkbox-cell">
                            <label class="checkbox"><input name="ids[]" value="<?=$v['id']?>" type="checkbox"><i class="icon-checkbox"></i></label>
                        </td>
                        <td class="tab-center wd60"><input class="dorder setField" type="text" name="displayorder" opid="<?=$v['id']?>" value="<?=$v['displayorder']?>"></td>
                        <td class="numeric-cell"><?=$v['id']?></td>
                        <td class="label-cell item-content">
                            <div class="item-text"><?=$v['name']?></div>
                            <div class="item-after tooltip-init" data-tooltip="添加此分类下导航">
                                <a class="link" href="<?=Url::current([Yii::$app->homeUrl.'navigation/admin', 'add'=>1, 'typeid'=>$v['id']])?>"><i class="fa fa-plus"></i></a>
                            </div></td>
                        <td class="tab-center"><a class="link" href="<?=Yii::$app->homeUrl?>navigation/admin/?srh[typeid]=<?=$v['id']?>">
                                <?=Navigation::find()->where(['typeid'=>$v['id']])->count()?></a></td>
                        <td class="tab-center">
                            <label class="toggle toggle-status color-green setStatus" opid="<?=$v['id']?>">
                                <input type="checkbox" <?=$v['status']?'':'checked'?>>
                                <span class="toggle-icon"></span>
                            </label>
                        </td>
                        <td class="numeric-cell"><?=Yii::$app->formatter->asDatetime($v['addtime'], 'short')?></td>
                        <td class="actions-cell">
                            <a class="link" href="<?=Yii::$app->homeUrl?>navigation/admin/?srh[typeid]=<?=$v['id']?>"><absx>查看导航</absx></a>
                            <a class="link" href="<?=\yii\helpers\Url::current(['add'=>1,'opid'=>$v['id']])?>"><absxb>编辑</absxb></a>
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



