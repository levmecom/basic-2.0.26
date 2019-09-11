<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-23 13:09
 *
 * 项目：levme  -  $  - default_navbar.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

use yii\helpers\Url;

?>

<?php if (Yii::$app->request->get('add')) : ?>
    <?=$this->render('default_navbar_add')?>
<?php else : ?>

<div class="navbar page-admin-navbar adminbar navbar"><div class="navbar-inner"><div class="list"><div class="item-content">
                <div class="item-text">
                    <a class="link tooltip-init" href="<?=Url::toRoute('/'.(in_array(Yii::$app->requestedAction->id, ['create', 'view', 'update']) ? Yii::$app->controller->uniqueId : Yii::$app->requestedAction->uniqueId))?>" data-tooltip="本首页">
                        <i class="fa fa-home" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="item-text">
                    <a class="link tooltip-init" href="javascript:window.history.back();" data-tooltip="后退">
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="item-text">
                    <a class="link tooltip-init" href="javascript:window.location.reload();" data-tooltip="刷新">
                        <i class="fa fa-refresh" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="item-text">
                    <a class="link tooltip-init" href="<?=Url::toRoute(['/'.Url::to('admin/default/settings'), 'identifier'=>Yii::$app->controller->module->uniqueId])?>" data-tooltip="模块设置">
                        <i class="fa fa-gear fa-spin fa-fw" aria-hidden="true"></i>
                    </a>
                </div>

                <div class="item-text"><a class="link tooltip-init external" target="_blank" data-tooltip="访问前台" href="<?=Yii::$app->homeUrl.str_ireplace('/admin', '', \Yii::$app->controller->uniqueId)?>"><i class="fa fa-external-link-square" aria-hidden="true"></i></a></div>

                <?php if (isset($this->blocks['addhref']) && $this->blocks['addhref']) : ?>
                <?php $this->blocks['addhref'] = $this->blocks['addhref'] ===true ? Url::current(['add'=>1]) : $this->blocks['addhref']?>
                <div class="item-text"><a class="link tooltip-init" data-tooltip="添加" href="<?=$this->blocks['addhref']?>"><i class="fa fa-plus-square" aria-hidden="true"></i></a></div>
                <?php endif?>

                <?php if (isset($this->blocks['deleteIcon'])) : ?>
                <div class="item-text"><a class="link tooltip-init checkAll" data-tooltip="全选"><i class="fa fa-check-square" aria-hidden="true"></i></a></div>
                <div class="item-text"><a class="link tooltip-init deleteCheckAll" data-tooltip="删除选中"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
                <?php endif?>

                <div class="item-after"><h3><?=$this->title?></h3></div>
                <div class="item-after"><tips><?=isset($this->blocks['tips']) ? $this->blocks['tips'] : ''?></tips></div>
                <div class="item-after search-form" style="min-width:160px">
                    <?=isset($this->blocks['searchForm']) ? $this->blocks['searchForm'] : ''?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif;?>