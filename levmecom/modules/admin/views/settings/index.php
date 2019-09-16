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

use app\modules\admin\models\SettingsModel;
use app\modules\adminModules\models\AdminModulesModel;
use levmecom\aalevme\levHelpers;
use yii\data\Pagination;
use yii\helpers\Url;

$model = new app\modules\admin\models\SettingsModel();
$labels = $model->attributeLabels();

$modules = AdminModulesModel::find()->indexBy('identifier')->asArray()->all();
$modules['_public']['name'] = '#全局#';
$identifier = levHelpers::stripTags(Yii::$app->request->get('_qy'));
$mdinfo = levHelpers::arrv($identifier, $modules) ?: [];
if ($mdinfo) {
    $this->blocks['settingshref'] = Url::toRoute(['/admin/default/settings', 'identifier'=>$identifier]);
}

$inputtype = SettingsModel::inputtype();

$sorts = ['asc'=>'desc', 'desc'=>'asc'];

$srh = Yii::$app->request->get('srh');
$sort = strtolower(Yii::$app->request->get('sort'));
$sortfield = levHelpers::stripTags(Yii::$app->request->get('sortfield'));

$asort = 'asc'; //排序
if ($sortfield && isset($sorts[$sort])) {
    $asort = $sorts[$sort];
    $orderBy[$sortfield] = $sort == 'asc' ? SORT_ASC : SORT_DESC;
}else {
    $orderBy['displayorder'] = SORT_ASC;
    $orderBy['id'] = SORT_ASC;
}

$this->title = levHelpers::arrv($identifier ? 'name' : '', $mdinfo).'设置管理';//页面标题

$this->blocks['addhref'] = Url::current(['/'.Yii::$app->controller->uniqueId.'/create', 'add'=>1]);//设置true = Url::current(['add'=>1])

$this->blocks['deleteIcon'] = '';//是否显示删除图标，不需要注释掉

$this->blocks['tips'] = ''; //顶部红字提示

//$this->blocks['deleteDay'] = 'addtime';//删除多少天前数据 时间字段 int

$this->blocks['dateSearch'] = 'addtime';//按日期搜索字段 int

$this->blocks['pageSize'] = levHelpers::pageSize(20); //分页设置

$pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => $this->blocks['pageSize']]);
$lists = $query->orderBy($orderBy)->offset($pages->offset)->limit($pages->limit)->asArray()->all();

$this->blocks['pages'] = \yii\widgets\LinkPager::widget(['pagination' => $pages, 'firstPageLabel' => true, 'lastPageLabel' => true, 'maxButtonCount' => 8, 'disableCurrentPageButton' => true]).' <absx>共'.$query->count().'条</absx>';

?>
<?php $this->beginBlock('searchForm')?>
<div class="item-after"><a class="button-active button button-fill mgt0" href="<?=$this->blocks['addhref']?>">增加</a></div>
<div class="item-after"><a class="color-black button button-fill mgt0" href="<?=Url::toRoute('/admin/default/update-redis')?>">更新缓存</a></div>
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
<!-- displayorder => 排序 -->
                    <th class="tab-center sortable-cell wd60 openziframescreen <?=$sortfield=='displayorder'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'displayorder'])?>">排序</th>
<!-- moduleidentifier => 模块标识符 -->
                    <th class="input-cell label-cell">
                        <a class="table-head-label sortable-cell <?=$sortfield=='moduleidentifier'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'moduleidentifier'])?>">模块(标识符)</a>
                        <div class="input"><input type="text" class="srh" name="srh[moduleidentifier]" value="<?=isset($srh['moduleidentifier'])?$srh['moduleidentifier']:''?>" placeholder="搜索" <?=!Yii::$app->request->get('_qy') ?: 'disabled'?>></div>
                    </th>
<!-- title => 标题 -->
                    <th class="input-cell label-cell">
                        <a class="table-head-label sortable-cell <?=$sortfield=='title'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'title'])?>"><?=isset($labels['title']) && $labels['title'] ? $labels['title'] : '标题'?></a>
                        <div class="input"><input type="text" class="srh" name="srh[title]" value="<?=isset($srh['title'])?$srh['title']:''?>" placeholder="搜索"></div>
                    </th>
<!-- inputname => 输入框名 -->
                    <th class="input-cell label-cell">
                        <a class="table-head-label sortable-cell <?=$sortfield=='inputname'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'inputname'])?>"><?=isset($labels['inputname']) && $labels['inputname'] ? $labels['inputname'] : '输入框名'?></a>
                        <div class="input"><input type="text" class="srh" name="srh[inputname]" value="<?=isset($srh['inputname'])?$srh['inputname']:''?>" placeholder="搜索"></div>
                    </th>
<!-- inputtype => 输入框类型 -->
                    <th class="input-cell label-cell">
                        <a class="table-head-label sortable-cell <?=$sortfield=='inputtype'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'inputtype'])?>"><?=isset($labels['inputtype']) && $labels['inputtype'] ? $labels['inputtype'] : '输入框类型'?></a>
                        <div class="input input-dropdown">
                            <select class="srh" name="srh[inputtype]">
                                <option value="">全部</option>
                                <?php foreach ($inputtype as $k => $v) :?>
                                    <option value="<?=$k?>" <?=isset($srh['inputtype'])&&$srh['inputtype']==$k?'selected':''?>><?=$v?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </th>
<!-- placeholder => 提示语 -->
                    <th class="input-cell label-cell">
                        <a class="table-head-label sortable-cell <?=$sortfield=='placeholder'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'placeholder'])?>"><?=isset($labels['placeholder']) && $labels['placeholder'] ? $labels['placeholder'] : '提示语'?></a>
                        <div class="input"><input type="text" class="srh" name="srh[placeholder]" value="<?=isset($srh['placeholder'])?$srh['placeholder']:''?>" placeholder="搜索"></div>
                    </th>
                    <th class="actions-cell">操作</th>
                </tr>
                </thead>
                <tbody class="add-tr-var-box">
                <?php foreach ($lists as $k => $v) : ?>
                    <tr>
                        <td class="checkbox-cell tooltip-init" data-tooltip="<?=$v['id']?>">
                            <label class="checkbox">
                                <input name="ids[]" value="<?= $v['id']?>" type="checkbox">
                                <i class="icon-checkbox"></i>
                            </label>
                        </td>
                        <td class="tab-center wd60"><input class="dorder setField" type="text" name="displayorder" opid="<?=$v['id']?>" value="<?=$v['displayorder']?>"></td>
                        <td class="label-cell"><a href="<?=Url::current(['srh'=>['moduleidentifier'=>$v['moduleidentifier']]])?>"><?=levHelpers::arrv('name', levHelpers::arrv($v['moduleidentifier'], $modules)),'(',$v['moduleidentifier'],')'?></a></td>
                        <td class="label-cell"><input class="setField" type="text" name="title" opid="<?=$v['id']?>" value="<?=$v['title']?>"></td>
                        <td class="label-cell"><input class="setField" type="text" name="inputname" opid="<?=$v['id']?>" value="<?=$v['inputname']?>"></td>
                        <td class="label-cell"><?=levHelpers::arrv($v['inputtype'], $inputtype)?></td>
                        <td class="label-cell"><input class="setField" type="text" name="placeholder" opid="<?=$v['id']?>" value="<?=$v['placeholder']?>"></td>
                        <td class="actions-cell">
                            <a href="<?=Url::current(['/'.Yii::$app->controller->uniqueId.'/view','id'=>$v['id']])?>"><absxn>查看</absxn></a>
                            <a href="<?=Url::current(['/'.Yii::$app->controller->uniqueId.'/update','id'=>$v['id']])?>"><absxb>编辑</absxb></a>
                        </td>
                    </tr>
                <?php endforeach;?>
                <tr class="add-tr-var-input">
                    <td class="checkbox-cell"><label class="checkbox disabled"><i class="icon-checkbox"></i></label></td>
                    <td class="tab-center wd60"><input class="dorder" type="text" name="displayorder" value="<?=levHelpers::arrv('displayorder', $v, 0)?>"></td>
                    <td class="label-cell"><?=$identifier?:'_public'?></td>
                    <td class="label-cell"><input type="text" name="title"></td>
                    <td class="label-cell"><input type="text" name="inputname"></td>
                    <td class="label-cell">

                        <div class="input input-dropdown">
                            <select name="inputtype">
                                <?php foreach ($inputtype as $k => $v) :?>
                                    <option value="<?=$k?>" <?=isset($srh['inputtype'])&&$srh['inputtype']==$k?'selected':''?>><?=$v?></option>
                                <?php endforeach;?>
                            </select>
                        </div>

                    </td>
                    <td class="label-cell"><input type="text" name="placeholder"></td>
                    <td class="actions-cell"><a class="button-active button button-fill" onclick="doAddTrVar()">新增</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </form>
    <div class="card-footer">
        <form class="hidden addTrVar">
            <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>">
        </form>
    </div>
</div>

<script>
    function doAddTrVar() {
        F7app.preloader.show();
        jQuery('form.addTrVar').ajaxSubmit({
            url: '',
            data: {
                addvar:1,
                _qy:'<?=$identifier?>',
                displayorder:jQuery('.add-tr-var-input input[name="displayorder"]').val(),
                title:jQuery('.add-tr-var-input input[name="title"]').val(),
                placeholder:jQuery('.add-tr-var-input input[name="placeholder"]').val(),
                inputname:jQuery('.add-tr-var-input input[name="inputname"]').val(),
                inputtype:jQuery('.add-tr-var-input select[name="inputtype"]').val()
            },
            type:'post',
            dataType: 'json',
            success: function(data){
                F7app.preloader.hide();
                if (parseInt(data.status) >0) {
                    levtoast(data.message);
                    window.setTimeout(function () {
                        window.location.reload();
                    }, 100);
                }else if (data && data.message) {
                    levtoast(data.message, 15000);
                }
                showFormErrors(data.errors, '.add-tr-var-input ');
            },
            error: function(data) {
                F7app.preloader.hide();
                errortips(data);
            }
        });
        return false;
    }
</script>
