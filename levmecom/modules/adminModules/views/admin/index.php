<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-08-26 09:44
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */


/* @var $this \yii\web\View */

use app\modules\adminModules\models\AdminModulesModel;
use levmecom\aalevme\levHelpers;
use yii\data\Pagination;
use yii\helpers\Url;

$srh = Yii::$app->request->get('srh');

$this->title = '模块管理';
$this->blocks['optable'] = AdminModulesModel::tableName();

$this->blocks['tips'] = '【提示】基础模块只能更新，禁止其它操作';

//$this->blocks['deleteDayFormAction'] = '';
//$this->blocks['deleteDay'] = 'addtime';

$this->blocks['dateSearch'] = 'addtime';

$typearr = AdminModulesModel::typearr();

$wheres = (isset($where) && $where ? $where : '');

if (!Yii::$app->request->get('notinstall')) {
    $this->blocks['pageSize'] = \levmecom\aalevme\levHelpers::pageSize(200);

    $data = AdminModulesModel::find()->where($wheres);
    $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => $this->blocks['pageSize']]);
    $lists = $data->offset($pages->offset)->limit($pages->limit)->orderBy(['status'=>SORT_ASC,'typeid'=>SORT_ASC,'id'=>SORT_DESC])->asArray()->all();
    $this->blocks['pages'] = \yii\widgets\LinkPager::widget(['pagination' => $pages, 'firstPageLabel' => true, 'lastPageLabel' => true, 'maxButtonCount' => 8, 'disableCurrentPageButton' => true]).' <absx>共'.$data->count().'条</absx>';
}

$identifiereds = array_keys((array)AdminModulesModel::find()->select(['identifier'])->indexBy('identifier')->asArray()->all());
$identifiereds = array_merge($identifiereds, ['install', 'admin']);
$notinstalleds = \app\modules\adminModules\Module::getDirModulesIdentifier();

?>
<?php $this->beginBlock('searchForm')?>
<div class="item-after"><a class="button button-fill color-black" href="<?=Url::toRoute(['', 'notinstall'=>1])?>">未安装</a></div>
<div class="item-after"><a class="button button-fill color-gray" href="<?=Url::toRoute(['', 'srh'=>['status'=>1]])?>">未启用</a></div>
    <div class="item-after"><a class="button button-fill color-red external" target="_blank" href="<?=Url::toRoute(['/gii/module'])?>">创建</a></div>
<form name="searchbarForm" method="get" class="searchbar tooltip-init" data-tooltip="联合搜索 - 回车执行搜索" style="min-width: 330px">
    <div class="searchbar-inner">
        <input type="text" name="srh[identifier]" class="wd60" value="<?=!isset($srh['identifier'])?'':$srh['identifier']?>" placeholder="标识符">
        <div class="input input-dropdown" style="width: 120px;">
            <select name="srh[typeid]">
                <option value="">分类筛选</option>
                <?php foreach ($typearr as $v) : ?>
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

<?php if (isset($lists)) : ?>
<div class="data-table data-table-init card list">
    <div class="card-header">
        <h2 class="button" style="font-size: 18px;color: rgba(0,0,0,0.7);"><i class="fa fa-align-right"></i> 已安装模块</h2>
    </div>
    <form name="dataTableForm" action="<?=Yii::$app->homeUrl?>admin/default/admin-delete">
        <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>">
        <input type="hidden" name="optable" value="<?=$this->blocks['optable']?>">
        <div class="card-content">
            <table>
                <thead>
                <tr>
                    <th class="checkbox-cell">
                        <label class="checkbox"><input name="ids[]" type="checkbox"><i class="icon-checkbox"></i></label></th>
                    <th class="label-cell wd100">标识符</th>
                    <th class="label-cell">名称 <i class="fa fa-external-link-square" aria-hidden="true"></i></th>
                    <th class="label-cell wd100">版权所有</th>
                    <th class="label-cell ellipsis">简短描述</th>
                    <th class="tab-center wd60">状态</th>
                    <th class="numeric-cell wd60">时间</th>
                    <th class="tab-center wd60">设置</th>
                    <th class="actions-cell">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($lists as $k => $v) : ?>
                    <tr>
                        <td class="checkbox-cell">
                            <?php if (!AdminModulesModel::isBaseModule($v['typeid'])) : ?>
                            <label class="checkbox"><input name="ids[]" value="<?=$v['id']?>" type="checkbox"><i class="icon-checkbox"></i></label>
                            <?php else:?>
                                <label class="checkbox tooltip-init" data-tooltip="禁止删除"><i class="disabled"></i></label>
                            <?php endif;?>
                        </td>
                        <td class="label-cell">
                            <a class="link" href="<?=Url::current(['srh'=>['typeid'=>$v['typeid']]])?>"><?=$typearr[$v['typeid']]['name']?></a>
                            <p><?=$v['identifier']?></p>
                        </td>
                        <td class="label-cell">
                            <a class="link external" target="_blank" href="<?=Yii::$app->homeUrl,$v['identifier']?>"><?=$v['name']?></a>
                            <p><small class="date">版本：<tips><?=$v['version']?></tips></small></p>
                        </td>
                        <td class="label-cell"><?=$v['copyright']?></td>
                        <td class="label-cell ellipsis"><?=$v['descs']?></td>
                        <td class="tab-center">
                            <label class="toggle toggle-status color-green <?=AdminModulesModel::isBaseModule($v['typeid'])?'disabled':'setStatus'?>" opid="<?=$v['id']?>">
                                <input type="checkbox" <?=$v['status']?'':'checked'?>>
                                <span class="toggle-icon"></span>
                            </label>
                        </td>
                        <td class="numeric-cell date tooltip-init" data-tooltip="<?=(!$v['uptime'] ?'-': '更新：'.Yii::$app->formatter->asDatetime($v['uptime'])),'<br>安装：'.Yii::$app->formatter->asDatetime($v['addtime'])?></p>">
                            <p><?=!$v['uptime'] ?'-': Yii::$app->formatter->asRelativeTime($v['uptime'])?></p>
                            <p><?=Yii::$app->formatter->asRelativeTime($v['addtime'])?></p>
                        </td>
                        <td class="tab-center wd60">
                            <?php if (levHelpers::stget(null, $v['identifier'])) :?>
                            <a href="<?=Url::toRoute(['/admin/default/settings', 'identifier'=>$v['identifier']])?>"><i class="fa fa-gear" aria-hidden="true"></i></a>
                            <?php endif?>
                        </td>
                        <td class="actions-cell">
                            <p>
                                <a class="link" href="<?=Yii::$app->homeUrl,$v['identifier'],'/admin-install/update'?>"><absxn>更新</absxn></a>
                                <a class="link" href="<?=Yii::$app->homeUrl,$v['identifier'],'/admin-install/reinstall'?>"><absxk>重装</absxk></a>
                            </p>
                            <p>
                                <?php if (isset(Yii::$app->params['developing']) && Yii::$app->params['developing']) :?>
                                    <a class="link" href="<?=Url::toRoute(['/admin/settings', 'srh'=>['moduleidentifier'=>$v['identifier']], '_qy'=>$v['identifier']])?>"><absxy>设计</absxy></a>
                                <?php endif;?>
                                <a class="link" href="<?=Yii::$app->homeUrl,$v['identifier'],'/admin-install'?>"><absx>安装</absx></a>
                                <a class="link" href="<?=Yii::$app->homeUrl,$v['identifier'],'/admin-install/uninstall'?>"><absxg>卸载</absxg></a>
                            </>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </form>
    <div class="card-footer"></div>
</div>
<?php endif; ?>

<?php if (empty($srh)) : ?>

<?php
    $setmodules = Yii::$app->getModules();//Yii::$app->modules;
    unset($setmodules['adminModules'], $setmodules['gii']);//print_r($setmodules);
?>

<div class="data-table data-table-init card list">
    <div class="card-header">
        <a class="button" id="notinstalleds" style="font-size: 18px;color: rgba(0,0,0,0.7);"><i class="fa fa-align-left"></i> 未安装模块</a>
        <tips>
            <p>请将模块生成到modules目录下（例：app\modules\mymodule\Module）</p>
            <p>请将子模块生成到modules/modules目录下（例：app\modules\mymodule\modules\mychild\Module）</p>
        </tips>
    </div>
    <div class="card-content">
        <table>
            <thead>
            <tr>
                <th class="label-cell wd60"><b>名称</b> <i class="fa fa-external-link-square" aria-hidden="true"></i></th>
                <th class="label-cell"><b>标识符</b></th>
                <th class="numeric-cell wd100"><b>时间</b></th>
                <th class="numeric-cell wd100"><b>状态</b></th>
                <th class="actions-cell wd100"><b>操作</b></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($notinstalleds as $v) :
                if (in_array($v['identifier'], $identifiereds)) continue;
                $lastEditTime = filemtime($v['dir']);
                $isNew = $lastEditTime > time() - 3600*24 ? '<sup>new</sup>' : '';
                $_cmd = strpos($v['identifier'], '/') !==false ? '<absxb>子模块</absxb>' : '<absxg>未设置路由</absxg>';
            ?>
                <tr>
                    <td class="label-cell">
                        <a href="<?=Url::toRoute(['/'.$v['identifier']])?>" class="external" target="_blank">
                        <?=isset($setmodules[$v['identifier']]['params']['title']) ? $setmodules[$v['identifier']]['params']['title']:$_cmd?>
                    </td>
                    <td class="label-cell">
                        <?=$v['identifier'],$isNew?>
                    </td>
                    <td class="numeric-cell"><?=Yii::$app->formatter->asRelativeTime($lastEditTime)?></td>
                    <td class="numeric-cell">
                        <?=isset($setmodules[$v['identifier']]) ? '<absxn>已设置路由</absxn>' : $_cmd?>
                    </td>
                    <td class="actions-cell">
                        <a class="link" href="<?=Yii::$app->homeUrl,$v['identifier'],'/admin-install'?>"><absx>安装</absx></a>
                        <a class="link" href="<?=Yii::$app->homeUrl,$v['identifier'],'/admin-install/reinstall'?>"><absxk>重装</absxk></a>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <div class="card-footer"><div class="data-table-header">
            <tips>【提示】以上显示按规则创建模块(modules目录下模块)</tips>
        </div></div>
</div>
<?php endif;?>