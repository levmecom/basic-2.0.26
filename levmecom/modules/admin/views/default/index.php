<?php

use yii\helpers\Url;

$this->blocks['pageName'] = 'admin';

$userinfo = \app\modules\ucenter\widgets\Ucenter::userinfo();

?>
<style>
    body .view .page-content {height: 100% !important;}
    .login-screen.als-screen {width: calc(100% - 230px);margin-left: 230px;height: calc(100% - 38px);margin-top: 38px;}
    .login-screen.als-screen .view {width: 100% !important;transform: none !important;}
</style>


<?php $this->beginBlock('navbar') ?>
<div class="navbar admintop">
    <div class="navbar-inner">
        <div class="left">
            <a class="link tooltip-init panel-open" data-tooltip="开启/关闭侧滑栏"><i class="fa fa-bars" aria-hidden="true"></i></a>
            <a class="link tooltip-init" data-tooltip="后台首页" href="<?=Yii::$app->homeUrl?>admin"><i class="fa fa-home" aria-hidden="true"></i></a>
            <a class="link tooltip-init toIframe" target="_iframe" data-tooltip="全局设置" href="<?=Yii::$app->homeUrl?>admin/settings"><i class="fa fa-cog" aria-hidden="true"></i></a>
            <a class="link tooltip-init toIframe" target="_iframe" data-tooltip="导航设置" href="<?=Yii::$app->homeUrl?>navigation/admin"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
            <a class="link tooltip-init toIframe" target="_iframe" data-tooltip="模块安装" href="<?=Yii::$app->homeUrl?>adminModules/admin"><i class="fa fa-th-large" aria-hidden="true"></i></a>
        </div>
        <div class="center iframe-navbar">
            <div class="menu-item menu-item-dropdown adminTopNavPopoverOpen">
                <div class="menu-item-content navnamebox"><i class="fa fa-th-large" aria-hidden="true"></i></div>
            </div>
            <a class="refresh-this"><i class="fa fa-home" aria-hidden="true"></i></a>
        </div>
        <div class="right">
            <a class="link external" target="_blank" href="<?=Yii::$app->homeUrl?>ucenter">您好，<?=$userinfo['username']?></a>
            <a class="link external" target="_blank" href="<?=Yii::$app->homeUrl?>">手机版</a>
            <a class="link external" target="_blank" href="<?=Yii::$app->homeUrl?>">电脑版</a>
        </div>
    </div>
</div>

<div class="popover my-admin-nav-popover panel-x"><div class="popover-inner"><div class="list accordion-list"><ul>

            </ul>
        </div>
    </div>
</div>
<?php $this->endBlock() ?>


<?php $this->beginBlock('layoutsBottom') ?>

<div class="panel panel-left panel-cover panel-x">

    <div class="navbar admintop">
        <div class="navbar-inner">
            <div class="left">
                <a class="link" target="_blank" href="http://levme.com" style="color: #fff;">
                <img src="<?=Yii::getAlias('@web')?>/statics/mobileIcon.png" class="logo">
                <h2>Levme.com</h2>
                </a>
            </div>
            <div class="right">
                <b>v1.0.0</b>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="list accordion-list">
            <ul>
                <?=\app\modules\navigation\widgets\adminLeftTree::widget()?>
            </ul>
        </div>
    </div>

    <div class="toolbar tabbar toolbar-bottom adminbottom">
        <div class="toolbar-inner">
            <a class="link" target="_blank" href="http://levme.com" style="color: #fff;">
                <b><small>&copy; 2016-<?=date('Y')?> Levme.com Inc.</small></b>
            </a>
        </div>
    </div>

</div>
<?php $this->endBlock() ?>

<?php $this->blocks['toolbar'] = '';?>

<div id="iframe_x_box" class="list" style="background:#d5dfef;overflow: hidden;padding:0px;height:100%;margin:0;">

    <iframe src="<?=Yii::$app->homeUrl?>adminModules/admin"></iframe>

</div>















