<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

$count = 0; $timeField = ''; $showColnums = $hideColnums = [];
$modelClass = $generator->modelClass;
$model = new $modelClass();
$pks = $model::primaryKey();
$primaryKey = in_array('id', $pks) ? 'id' : $pks[0];
$attributeLabels = $model->attributeLabels();
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (isset($attributeLabels[$name]) && $attributeLabels[$name]) {
            $showColnums[$name] = [$attributeLabels[$name], ''];
        }else {
            $hideColnums[$name] = [$name, ''];
        }
        $timeField = $timeField ? ($name == 'addtime' ? $name : $timeField) : (in_array($name, ['uptime', 'addtime']) ? $name : '');
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        $name = $column->name;
        if (isset($attributeLabels[$name]) && $attributeLabels[$name]) {
            $showColnums[$name] = [$attributeLabels[$name], $format];
        }else {
            $hideColnums[$name] = [$name, $format];
        }
        $timeField = $timeField ? ($name == 'addtime' ? $name : $timeField) : (in_array($name, ['uptime', 'addtime']) ? $name : '');
    }
}
$showColnums = $showColnums ? $showColnums : $hideColnums;

echo "<?php\n";
?>
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

$model = new <?=$modelClass?>();
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
    $orderBy['<?=$primaryKey?>'] = SORT_DESC;
}

$this->title = <?= $generator->generateString($generator->modelPageTitle ? $generator->modelPageTitle : Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;//页面标题

$this->blocks['addhref'] = Url::toRoute(['/'.Yii::$app->controller->uniqueId.'/create', 'add'=>1]);//设置true = Url::current(['add'=>1])

$this->blocks['deleteIcon'] = '';//是否显示删除图标，不需要注释掉

$this->blocks['tips'] = ''; //顶部红字提示

$this->blocks['deleteDay'] = '<?=$timeField?>';//删除多少天前数据 时间字段 int

$this->blocks['dateSearch'] = '<?=$timeField?>';//按日期搜索字段 int

$this->blocks['pageSize'] = levHelpers::pageSize(20); //分页设置

$pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => $this->blocks['pageSize']]);
$lists = $query->orderBy($orderBy)->offset($pages->offset)->limit($pages->limit)->asArray()->all();

$this->blocks['pages'] = \yii\widgets\LinkPager::widget(['pagination' => $pages, 'firstPageLabel' => true, 'lastPageLabel' => true, 'maxButtonCount' => 8, 'disableCurrentPageButton' => true]).' <absx>共'.$query->count().'条</absx>';

?>
<?="<?php"?> $this->beginBlock('searchForm')?>
<!--<div class="item-after"><a class="button button-fill mgt0" href="<?="<?="?>Url::toRoute(['', 'param'=>1])?>">按钮</a></div>-->
<?="<?php"?> $this->endBlock()?>

<div class="data-table data-table-init card">
    <form name="dataTableForm" action="">
        <input type="hidden" name="<?="<?="?>Yii::$app->request->csrfParam?>" value="<?="<?="?>Yii::$app->request->csrfToken?>">
        <input type="hidden" name="field" value="<?=$primaryKey?>">
        <div class="card-content">
            <table>
                <thead>
                <tr>
<?php if ($primaryKey) : ?>
                    <th class="checkbox-cell">
                        <label class="checkbox"><input name="ids[]" type="checkbox"><i class="icon-checkbox"></i></label>
                    </th>
<?php endif; ?>
<?php foreach ($showColnums as $field => $v) : ?><!-- <?=$field?> => <?=$v[0]?> -->
<?php if ($field == 'status') : ?>
                    <th class="input-cell tab-center wd60">
                        <a class="table-head-label sortable-cell numeric-cell <?="<?="?>$sortfield=='<?=$field?>'?'sortable-cell-active sortable-'.$sort:''?>" href="<?="<?="?>Url::current(['sort'=>$asort, 'sortfield'=>'<?=$field?>'])?>">状态</a>
                        <div class="input button-abox">
                            <?="<?php"?> if (isset($srh['status']) && is_numeric($srh['status']) && $srh['status'] == 0) :?>
                            <a class="button button-active link" href="<?="<?="?>Url::current(['srh'=>['status'=>'']])?>">开启</a>
                            <?="<?php"?> else :?>
                            <a class="button link" href="<?="<?="?>Url::current(['srh'=>['status'=>0]])?>">开启</a>
                            <?="<?php"?> endif;?>
                            <?="<?php"?> if (isset($srh['status']) && $srh['status'] == 1) :?>
                            <a class="button button-active link" href="<?="<?="?>Url::current(['srh'=>['status'=>'']])?>">关闭</a>
                            <?="<?php"?> else :?>
                            <a class="button link" href="<?="<?="?>Url::current(['srh'=>['status'=>1]])?>">关闭</a>
                            <?="<?php"?> endif;?>
                        </div>
                    </th>
<?php elseif (in_array($field, ['uptime', 'addtime']) || $v[1] =='datetime') :?>
                    <th class="input-cell numeric-cell wd60">
                        <a class="table-head-label sortable-cell numeric-cell <?="<?="?>$sortfield=='<?=$field?>'?'sortable-cell-active sortable-'.$sort:''?>" href="<?="<?="?>Url::current(['sort'=>$asort, 'sortfield'=>'<?=$field?>'])?>"><?="<?="?>isset($labels['<?=$field?>']) && $labels['<?=$field?>'] ? $labels['<?=$field?>'] : '<?=$v[0]?>'?></a>
                        <div class="input button-abox">
                            <?="<?php"?> if (isset($srh['_daydate']) && $srh['_daydate'] == '1.<?=$field?>') :?>
                            <a class="button button-active link" href="<?="<?="?>Url::current(['srh'=>['_daydate'=>'']])?>">今天</a>
                            <?="<?php"?> else :?>
                            <a class="button link" href="<?="<?="?>Url::current(['srh'=>['_daydate'=>'1.<?=$field?>']])?>">今天</a>
                            <?="<?php"?> endif;?>
                            <?="<?php"?> if (isset($srh['_daydate']) && $srh['_daydate'] == '2.<?=$field?>') :?>
                            <a class="button button-active link" href="<?="<?="?>Url::current(['srh'=>['_daydate'=>'']])?>">昨天</a>
                            <?="<?php"?> else :?>
                            <a class="button link" href="<?="<?="?>Url::current(['srh'=>['_daydate'=>'2.<?=$field?>']])?>">昨天</a>
                            <?="<?php"?> endif;?>
                        </div>
                    </th>
<?php elseif (in_array($field, ['displayorder'])) :?>
                    <th class="tab-center sortable-cell wd60 openziframescreen <?="<?="?>$sortfield=='<?=$field?>'?'sortable-cell-active sortable-'.$sort:''?>" href="<?="<?="?>Url::current(['sort'=>$asort, 'sortfield'=>'<?=$field?>'])?>">排序</th>
<?php elseif ($v[1] =='integer') :?>
                    <th class="input-cell numeric-cell wd60">
                        <a class="table-head-label sortable-cell numeric-cell <?="<?="?>$sortfield=='<?=$field?>'?'sortable-cell-active sortable-'.$sort:''?>" href="<?="<?="?>Url::current(['sort'=>$asort, 'sortfield'=>'<?=$field?>'])?>"><?="<?="?>isset($labels['<?=$field?>']) && $labels['<?=$field?>'] ? $labels['<?=$field?>'] : '<?=$v[0]?>'?></a>
                        <div class="input"><input type="text" class="srh" name="srh[<?=$field?>]" value="<?="<?="?>isset($srh['<?=$field?>'])?$srh['<?=$field?>']:''?>" placeholder="搜索"></div>
                    </th>
<?php else :?>
                    <th class="input-cell label-cell">
                        <a class="table-head-label sortable-cell <?="<?="?>$sortfield=='<?=$field?>'?'sortable-cell-active sortable-'.$sort:''?>" href="<?="<?="?>Url::current(['sort'=>$asort, 'sortfield'=>'<?=$field?>'])?>"><?="<?="?>isset($labels['<?=$field?>']) && $labels['<?=$field?>'] ? $labels['<?=$field?>'] : '<?=$v[0]?>'?></a>
                        <div class="input"><input type="text" class="srh" name="srh[<?=$field?>]" value="<?="<?="?>isset($srh['<?=$field?>'])?$srh['<?=$field?>']:''?>" placeholder="搜索"></div>
                    </th>
<?php endif; ?>
<?php endforeach; ?>
                    <th class="actions-cell">操作</th>
                </tr>
                </thead>
                <tbody>
                <?="<?php"?> foreach ($lists as $k => $v) : ?>
                    <tr>
<?php if ($primaryKey) : ?>
                        <td class="checkbox-cell tooltip-init" data-tooltip="<?="<?="?>$v['<?=$primaryKey?>']?>">
                            <label class="checkbox">
                                <input name="ids[]" value="<?="<?="?> $v['<?=$primaryKey?>']?>" type="checkbox">
                                <i class="icon-checkbox"></i>
                            </label>
                        </td>
<?php endif; ?>
<?php foreach ($showColnums as $field => $v) : ?>
<?php if ($field == 'status') : ?>
                        <td class="tab-center">
                            <label class="toggle toggle-status color-green setStatus" opid="<?="<?="?>$v['<?=$primaryKey?>']?>">
                                <input type="checkbox" <?="<?="?>$v['status']?'':'checked'?>>
                                <span class="toggle-icon"></span>
                            </label>
                        </td>
<?php elseif (in_array($field, ['uptime', 'addtime']) || $v[1] =='datetime') :?>
                        <td class="numeric-cell date">
                            <?="<?="?>Yii::$app->formatter->asDatetime($v['<?=$field?>'], 'short')?>
                        </td>
<?php elseif (in_array($field, ['displayorder'])) :?>
                        <td class="tab-center wd60"><input class="dorder setField" type="text" name="displayorder" opid="<?="<?="?>$v['<?=$primaryKey?>']?>" value="<?="<?="?>$v['displayorder']?>"></td>
<?php elseif ($v[1] =='integer') :?>
                        <td class="numeric-cell"><?="<?="?>$v['<?=$field?>']?></td>
<?php else :?>
                        <td class="label-cell"><?="<?="?>$v['<?=$field?>']?></td>
<?php endif; ?>
<?php endforeach; ?>
                        <td class="actions-cell">
                            <a href="<?="<?="?>Url::toRoute(['/'.Yii::$app->controller->uniqueId.'/view','<?=$primaryKey?>'=>$v['<?=$primaryKey?>']])?>"><absxn>查看</absxn></a>
                            <a href="<?="<?="?>Url::toRoute(['/'.Yii::$app->controller->uniqueId.'/update','<?=$primaryKey?>'=>$v['<?=$primaryKey?>']])?>"><absxb>编辑</absxb></a>
                        </td>
                    </tr>
                <?="<?php"?> endforeach;?>
                </tbody>
            </table>
        </div>
    </form>
    <div class="card-footer">
        <div class="data-table-footer"></div>
    </div>
</div>
