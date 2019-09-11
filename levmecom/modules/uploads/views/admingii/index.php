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

use levmecom\aalevme\levHelpers;
use yii\data\Pagination;
use yii\helpers\Url;

$model = new app\modules\uploads\models\Uploads();
$labels = $model->attributeLabels();

$sorts = ['asc'=>'desc', 'desc'=>'asc'];

$srh = Yii::$app->request->get('srh');
$sort = strtolower(Yii::$app->request->get('sort'));
$sortfield = levHelpers::stripTags(Yii::$app->request->get('sortfield'));

$asort = 'asc'; //排序
if ($sortfield && isset($sorts[$sort])) {
    $asort = $sorts[$sort];
    $orderBy[$sortfield] = $sort == 'asc' ? SORT_ASC : SORT_DESC;
}else {
    $orderBy['id'] = SORT_DESC;
}

$this->title = '上传管理';//页面标题

$this->blocks['addhref'] = Url::toRoute(['/'.Yii::$app->controller->uniqueId.'/create', 'add'=>1]);//设置true = Url::current(['add'=>1])

$this->blocks['deleteIcon'] = '';//是否显示删除图标，不需要注释掉

$this->blocks['tips'] = ''; //顶部红字提示

$this->blocks['deleteDay'] = 'addtime';//删除多少天前数据 时间字段 int

$this->blocks['dateSearch'] = 'addtime';//按日期搜索字段 int

$this->blocks['pageSize'] = levHelpers::pageSize(20); //分页设置

$pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => $this->blocks['pageSize']]);
$lists = $query->orderBy($orderBy)->offset($pages->offset)->limit($pages->limit)->asArray()->all();

$this->blocks['pages'] = \yii\widgets\LinkPager::widget(['pagination' => $pages, 'firstPageLabel' => true, 'lastPageLabel' => true, 'maxButtonCount' => 8, 'disableCurrentPageButton' => true]).' <absx>共'.$query->count().'条</absx>';

?>
<?php $this->beginBlock('searchForm')?>
<!--<div class="item-after"><a class="button button-fill mgt0" href="<?=Url::toRoute(['', 'param'=>1])?>">按钮</a></div>-->
<?php $this->endBlock()?>

<div class="data-table data-table-init card">
    <form name="dataTableForm" action="">
        <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>">
        <input type="hidden" name="field" value="id">
        <div class="card-content">
            <table>
                <thead>
                <tr>
                    <th class="checkbox-cell">
                        <label class="checkbox"><input name="ids[]" type="checkbox"><i class="icon-checkbox"></i></label>
                    </th>
<!-- id => ID -->
                    <th class="input-cell numeric-cell wd60">
                        <a class="table-head-label sortable-cell numeric-cell <?=$sortfield=='id'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'id'])?>"><?=isset($labels['id']) && $labels['id'] ? $labels['id'] : 'ID'?></a>
                        <div class="input"><input type="text" class="srh" name="srh[id]" value="<?=isset($srh['id'])?$srh['id']:''?>" placeholder="搜索"></div>
                    </th>
<!-- uid => UID -->
                    <th class="input-cell numeric-cell wd60">
                        <a class="table-head-label sortable-cell numeric-cell <?=$sortfield=='uid'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'uid'])?>"><?=isset($labels['uid']) && $labels['uid'] ? $labels['uid'] : 'UID'?></a>
                        <div class="input"><input type="text" class="srh" name="srh[uid]" value="<?=isset($srh['uid'])?$srh['uid']:''?>" placeholder="搜索"></div>
                    </th>
<!-- sourceid => 源ID -->
                    <th class="input-cell numeric-cell wd60">
                        <a class="table-head-label sortable-cell numeric-cell <?=$sortfield=='sourceid'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'sourceid'])?>"><?=isset($labels['sourceid']) && $labels['sourceid'] ? $labels['sourceid'] : '源ID'?></a>
                        <div class="input"><input type="text" class="srh" name="srh[sourceid]" value="<?=isset($srh['sourceid'])?$srh['sourceid']:''?>" placeholder="搜索"></div>
                    </th>
<!-- idtype => 附件源 -->
                    <th class="input-cell numeric-cell wd60">
                        <a class="table-head-label sortable-cell numeric-cell <?=$sortfield=='idtype'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'idtype'])?>"><?=isset($labels['idtype']) && $labels['idtype'] ? $labels['idtype'] : '附件源'?></a>
                        <div class="input"><input type="text" class="srh" name="srh[idtype]" value="<?=isset($srh['idtype'])?$srh['idtype']:''?>" placeholder="搜索"></div>
                    </th>
<!-- filetype => 文件类型 -->
                    <th class="input-cell numeric-cell wd60">
                        <a class="table-head-label sortable-cell numeric-cell <?=$sortfield=='filetype'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'filetype'])?>"><?=isset($labels['filetype']) && $labels['filetype'] ? $labels['filetype'] : '文件类型'?></a>
                        <div class="input"><input type="text" class="srh" name="srh[filetype]" value="<?=isset($srh['filetype'])?$srh['filetype']:''?>" placeholder="搜索"></div>
                    </th>
<!-- filename => 文件名 -->
                    <th class="input-cell label-cell">
                        <a class="table-head-label sortable-cell <?=$sortfield=='filename'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'filename'])?>"><?=isset($labels['filename']) && $labels['filename'] ? $labels['filename'] : '文件名'?></a>
                        <div class="input"><input type="text" class="srh" name="srh[filename]" value="<?=isset($srh['filename'])?$srh['filename']:''?>" placeholder="搜索"></div>
                    </th>
<!-- src => 文件路径 -->
                    <th class="input-cell label-cell">
                        <a class="table-head-label sortable-cell <?=$sortfield=='src'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'src'])?>"><?=isset($labels['src']) && $labels['src'] ? $labels['src'] : '文件路径'?></a>
                        <div class="input"><input type="text" class="srh" name="srh[src]" value="<?=isset($srh['src'])?$srh['src']:''?>" placeholder="搜索"></div>
                    </th>
<!-- addtime => 上传时间 -->
                    <th class="input-cell numeric-cell wd60">
                        <a class="table-head-label sortable-cell numeric-cell <?=$sortfield=='addtime'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'addtime'])?>"><?=isset($labels['addtime']) && $labels['addtime'] ? $labels['addtime'] : '上传时间'?></a>
                        <div class="input button-abox">
                            <?php if (isset($srh['_daydate']) && $srh['_daydate'] == '1.addtime') :?>
                            <a class="button button-active link" href="<?=Url::current(['srh'=>['_daydate'=>'']])?>">今天</a>
                            <?php else :?>
                            <a class="button link" href="<?=Url::current(['srh'=>['_daydate'=>'1.addtime']])?>">今天</a>
                            <?php endif;?>
                            <?php if (isset($srh['_daydate']) && $srh['_daydate'] == '2.addtime') :?>
                            <a class="button button-active link" href="<?=Url::current(['srh'=>['_daydate'=>'']])?>">昨天</a>
                            <?php else :?>
                            <a class="button link" href="<?=Url::current(['srh'=>['_daydate'=>'2.addtime']])?>">昨天</a>
                            <?php endif;?>
                        </div>
                    </th>
                    <th class="actions-cell">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($lists as $k => $v) : ?>
                    <tr>
                        <td class="checkbox-cell">
                            <label class="checkbox">
                                <input name="ids[]" value="<?= $v['id']?>" type="checkbox">
                                <i class="icon-checkbox"></i>
                            </label>
                        </td>
                        <td class="numeric-cell"><?=$v['id']?></td>
                        <td class="numeric-cell"><?=$v['uid']?></td>
                        <td class="numeric-cell"><?=$v['sourceid']?></td>
                        <td class="numeric-cell"><?=$v['idtype']?></td>
                        <td class="numeric-cell"><?=$v['filetype']?></td>
                        <td class="label-cell"><?=$v['filename']?></td>
                        <td class="label-cell"><?=$v['src']?></td>
                        <td class="numeric-cell date">
                            <?=Yii::$app->formatter->asDatetime($v['addtime'], 'short')?>
                        </td>
                        <td class="actions-cell">
                            <a href="<?=Url::toRoute(['/'.Yii::$app->controller->uniqueId.'/view','id'=>$v['id']])?>"><absxn>查看</absxn></a>
                            <a href="<?=Url::toRoute(['/'.Yii::$app->controller->uniqueId.'/update','id'=>$v['id']])?>"><absxb>编辑</absxb></a>
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
