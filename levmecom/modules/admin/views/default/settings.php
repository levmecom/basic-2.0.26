<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-09-01 13:06
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

/* @var $this \yii\web\View */

?>

<?=$this->render('_form')?>


<?php $this->beginBlock('navbar')?>

<div class="navbar page-admin-navbar adminbar navbar"><div class="navbar-inner"><div class="list"><div class="item-content">
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

                <div class="item-after"><h3><?=$this->title?></h3></div>
                <div class="item-after search-form" style="min-width:0px">
                    <tips><?=isset($this->blocks['tips']) ? $this->blocks['tips'] : ''?></tips>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endBlock()?>


<?php $this->beginBlock('toolbar')?>
<div class="toolbar toolbar-bottom adminbottom adminbar page-admin-toolbar"><div class="toolbar-inner"><div class="list">
            <div class="item-content">
                <div class="item-text">
                    <label for="dosubmit" class="button button-active"> 保 存 </label>
                </div>
                <div class="item-after">
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBlock()?>



