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

$model = new app\modules\ucenter\models\User();
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

$this->title = '用户管理';//页面标题

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
<!-- username => 用户名 -->
                    <th class="input-cell label-cell">
                        <a class="table-head-label sortable-cell <?=$sortfield=='username'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'username'])?>"><?=isset($labels['username']) && $labels['username'] ? $labels['username'] : '用户名'?></a>
                        <div class="input"><input type="text" class="srh" name="srh[username]" value="<?=isset($srh['username'])?$srh['username']:''?>" placeholder="搜索"></div>
                    </th>
<!-- password_hash => 密码 -->
                    <th class="input-cell label-cell">
                        <a class="table-head-label sortable-cell <?=$sortfield=='password_hash'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'password_hash'])?>"><?=isset($labels['password_hash']) && $labels['password_hash'] ? $labels['password_hash'] : '密码'?></a>
                        <div class="input"><input type="text" class="srh" name="srh[password_hash]" value="<?=isset($srh['password_hash'])?$srh['password_hash']:''?>" placeholder="搜索"></div>
                    </th>
<!-- email => Email -->
                    <th class="input-cell label-cell">
                        <a class="table-head-label sortable-cell <?=$sortfield=='email'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'email'])?>"><?=isset($labels['email']) && $labels['email'] ? $labels['email'] : 'Email'?></a>
                        <div class="input"><input type="text" class="srh" name="srh[email]" value="<?=isset($srh['email'])?$srh['email']:''?>" placeholder="搜索"></div>
                    </th>
<!-- status => 状态 -->
                    <th class="input-cell tab-center wd60">
                        <a class="table-head-label sortable-cell numeric-cell <?=$sortfield=='status'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'status'])?>">状态</a>
                        <div class="input button-abox">
                            <?php if (isset($srh['status']) && is_numeric($srh['status']) && $srh['status'] == 0) :?>
                            <a class="button button-active link" href="<?=Url::current(['srh'=>['status'=>'']])?>">开启</a>
                            <?php else :?>
                            <a class="button link" href="<?=Url::current(['srh'=>['status'=>0]])?>">开启</a>
                            <?php endif;?>
                            <?php if (isset($srh['status']) && $srh['status'] == 1) :?>
                            <a class="button button-active link" href="<?=Url::current(['srh'=>['status'=>'']])?>">关闭</a>
                            <?php else :?>
                            <a class="button link" href="<?=Url::current(['srh'=>['status'=>1]])?>">关闭</a>
                            <?php endif;?>
                        </div>
                    </th>
<!-- addtime => 添加时间 -->
                    <th class="input-cell numeric-cell wd60">
                        <a class="table-head-label sortable-cell numeric-cell <?=$sortfield=='addtime'?'sortable-cell-active sortable-'.$sort:''?>" href="<?=Url::current(['sort'=>$asort, 'sortfield'=>'addtime'])?>"><?=isset($labels['addtime']) && $labels['addtime'] ? $labels['addtime'] : '添加时间'?></a>
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
                        <td class="label-cell"><?=$v['username']?></td>
                        <td class="label-cell"><?=$v['password_hash']?></td>
                        <td class="label-cell"><?=$v['email']?></td>
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
