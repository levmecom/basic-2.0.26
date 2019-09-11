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

use app\modules\ucenter\modules\registers\models\UcenterRegisters;
use yii\data\Pagination;

$this->title = '批量注册分类管理';

$this->blocks['tips'] = '【提示】删除分类不会删除用户';

$this->blocks['addhref'] = true;//设置true = Url::current(['add'=>1])

$this->blocks['deleteIcon'] = '';//是否显示删除图标，不需要注释掉

//$this->blocks['deleteDay'] = 'addtime';

$this->blocks['dateSearch'] = 'addtime';

$where = 'uid = 0'.(isset($where) && $where ? ' AND '.$where : '');

$this->blocks['pageSize'] = \levmecom\aalevme\levHelpers::pageSize(20);

$data = UcenterRegisters::find()->where($where);
$pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => $this->blocks['pageSize']]);
$lists = $data->offset($pages->offset)->limit($pages->limit)->asArray()->all();

$this->blocks['pages'] = \yii\widgets\LinkPager::widget(['pagination' => $pages, 'firstPageLabel' => true, 'lastPageLabel' => true, 'maxButtonCount' => 8, 'disableCurrentPageButton' => true]).' <absx>共'.$data->count().'条</absx>';

$srh = Yii::$app->request->get('srh');

?>
<?php $this->beginBlock('searchForm')?>
<form name="searchbarForm" method="get" class="searchbar tooltip-init" data-tooltip="联合搜索 - 回车执行搜索">
    <div class="searchbar-inner">
        <div class="searchbar-input-wrap">
            <input type="search" name="srh[name]" value="<?=isset($srh['name'])?$srh['name']:''?>" placeholder="搜用分类名称" class="search-input">
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
                    <th class="numeric-cell wd60">分类ID</th>
                    <th class="label-cell">分类名称</th>
                    <th class="label-cell">用户数</th>
                    <th class="tab-center">状态</th>
                    <th class="actions-cell">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($lists as $k => $v) : ?>
                    <tr>
                        <td class="checkbox-cell">
                            <label class="checkbox"><input name="ids[]" value="<?=$v['id']?>" type="checkbox"><i class="icon-checkbox"></i></label>
                        </td>
                        <td class="numeric-cell"><?=$v['id']?></td>
                        <td class="label-cell"><?=$v['name']?></td>
                        <td class="label-cell"><?=UcenterRegisters::find()->where(['typeid'=>$v['id']])->count()?></td>
                        <td class="tab-center">
                            <label class="toggle toggle-status color-green setStatus" opid="<?=$v['id']?>">
                                <input type="checkbox" <?=$v['status']?'':'checked'?>>
                                <span class="toggle-icon"></span>
                            </label>
                        </td>
                        <td class="actions-cell">
                            <a class="link" href="<?=Yii::$app->homeUrl?>ucenter/registers/admin/?srh[typeid]=<?=$v['id']?>" target="_screen"><absx>查看用户</absx></a>
                            <a class="link" href="<?=\yii\helpers\Url::current(['add'=>1,'opid'=>$v['id']])?>" target="_screen"><absxb>编辑</absxb></a>
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



