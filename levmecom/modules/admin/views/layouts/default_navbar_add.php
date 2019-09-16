<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-23 13:48
 *
 * 项目：levme  -  $  - default_navbar_add.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

use yii\helpers\Url;
?>


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

                <div class="item-text"><a class="link tooltip-init external" target="_blank" data-tooltip="访问前台" href="<?=Url::toRoute(['/'.Yii::$app->controller->module->uniqueId])?>"><i class="fa fa-external-link-square" aria-hidden="true"></i></a></div>

                <div class="item-after"><h3><?=$this->title?></h3></div>
                <div class="item-after search-form" style="min-width:0px">
                    <tips><?=isset($this->blocks['tips']) ? $this->blocks['tips'] : ''?></tips>
                </div>
            </div>
        </div>
    </div>
</div>

