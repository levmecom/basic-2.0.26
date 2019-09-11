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

use app\modules\forum\models\Threads;
use yii\data\Pagination;
use yii\helpers\Url;

$srh = Yii::$app->request->get('srh');

$this->title = '论坛帖子管理';

$this->blocks['tips'] = '';

$this->blocks['addhref'] = true;//设置true = Url::current(['add'=>1])

$this->blocks['deleteIcon'] = '';//是否显示删除图标，不需要注释掉

$this->blocks['deleteDayFormAction'] = '';
$this->blocks['deleteDay'] = 'addtime';

$this->blocks['dateSearch'] = 'addtime';

$forums = \app\modules\forum\models\ForumForums::forums();

$rootid = isset($srh['rootid']) ? intval($srh['rootid']) : 0;
$where = 'rootid='.$rootid.(isset($where) && $where ? ' AND '.$where : '');

$this->blocks['pageSize'] = \levmecom\aalevme\levHelpers::pageSize(20);

$data = Threads::find()->where($where);
$pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => $this->blocks['pageSize']]);
$lists = $data->offset($pages->offset)->limit($pages->limit)->orderBy(['id'=>SORT_DESC])->asArray()->all();
$this->blocks['pages'] = \yii\widgets\LinkPager::widget(['pagination' => $pages, 'firstPageLabel' => true, 'lastPageLabel' => true, 'maxButtonCount' => 8, 'disableCurrentPageButton' => true]).' <absx>共'.$data->count().'条</absx>';

$users = \app\modules\ucenter\models\User::userByuids($lists);

?>
<?php $this->beginBlock('searchForm')?>
<form name="searchbarForm" method="get" class="searchbar tooltip-init" data-tooltip="联合搜索 - 回车执行搜索" style='min-width:320px'>
    <div class="searchbar-inner">
        <input type="text" name="srh[uid]" value="<?=!isset($srh['uid'])?'':$srh['uid']?>" placeholder="UID" style="width: 40px;">
        <div class="input input-dropdown" style="width: 120px;">
            <select name="srh[fid]">
                <option value="">版块筛选</option>
                <?php foreach ($forums as $v) : ?>
                    <option value="<?=$v['id']?>" <?=isset($srh['fid']) && $srh['fid'] ==$v['id']?'selected':''?>><?=$v['name']?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="searchbar-input-wrap">
            <input type="search" name="srh[title]" value="<?=isset($srh['title'])?$srh['title']:''?>" placeholder="标题检索" class="search-input">
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
                    <th class="label-cell wd100">所属版块</th>
                    <th class="label-cell">标题 <i class="fa fa-external-link-square" aria-hidden="true"></i></th>
                    <th class="label-cell">作者</th>
                    <th class="numeric-cell wd60">回复</th>
                    <th class="numeric-cell wd60">查看</th>
                    <th class="numeric-cell wd100">内容长度</th>
                    <th class="tab-center">状态</th>
                    <th class="numeric-cell">创建时间</th>
                    <th class="actions-cell">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($lists as $k => $v) : ?>
                    <tr>
                        <td class="checkbox-cell">
                            <label class="checkbox"><input name="ids[]" value="<?=$v['id']?>" type="checkbox"><i class="icon-checkbox"></i></label>
                        </td>
                        <td class="label-cell wd100 nowrap"><a class="link" href="<?=Url::current(['srh'=>['fid'=>$v['fid']]])?>"><?=$forums[$v['fid']]['name']?></a></td>
                        <td class="label-cell ellipsis">
                            <a class="link external" target="_blank" href="<?=Yii::$app->homeUrl,'forum/view/',$v['id']?>">
                            <?=$v['title']?:'<无标题><absx>'.$v['textlen'].'</absx>'?></a></td>
                        <td class="label-cell nowrap"><a class="link" href="<?=Url::current(['srh'=>['uid'=>$v['uid']]])?>"><?=$users[$v['uid']]['username']?></a></td>
                        <td class="numeric-cell"><a class="link" href="<?=Url::current(['srh'=>[($rootid ? 'pid' : 'rootid')=>$v['id']]])?>"><?=$v['replies']?></a></td>
                        <td class="numeric-cell"><?=$v['views']?></td>
                        <td class="numeric-cell"><?=$v['textlen']?></td>
                        <td class="tab-center">
                            <label class="toggle toggle-status color-green setStatus" opid="<?=$v['id']?>">
                                <input type="checkbox" <?=$v['status']?'':'checked'?>>
                                <span class="toggle-icon"></span>
                            </label>
                        </td>
                        <td class="numeric-cell date nowrap">
                            <?=Yii::$app->formatter->asDatetime($v['addtime'], 'short')?>
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






