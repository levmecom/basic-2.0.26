<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
//use yii\widgets\Breadcrumbs;

\app\assets\F7_v4410Asset::register($this);

$this->title = $this->title ?: Yii::$app->params['SiteName'];

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <!-- Required meta tags-->
    <meta charset="<?= Yii::$app->charset ?>">
    <title><?= Html::encode($this->title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no, email=no"/>

    <meta name="HandheldFriendly" content="true" />
    <?php $this->blocks['mobileIcon'] = isset($this->blocks['mobileIcon']) ? $this->blocks['mobileIcon'] : Yii::$app->homeUrl.'statics/mobileIcon.png'?>
    <?php $this->blocks['mobileIconTitle'] = isset($this->blocks['mobileIconTitle']) ? $this->blocks['mobileIconTitle'] : $this->title?>
    <link rel="shortcut icon" href="<?=$this->blocks['mobileIcon']?>" type="image/x-icon" />
    <link rel="apple-touch-icon" href="<?=$this->blocks['mobileIcon']?>"/>
    <meta name="apple-mobile-web-app-title" content="<?=$this->blocks['mobileIconTitle']?>">

    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <?php $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?>
    <script>
        (function () {//document.ready(function(){ ... });
            var ie =!!(window.attachEvent&&!window.opera),wk=/webkit\/(\d+)/i.test(navigator.userAgent)&&(RegExp.$1<525);
            var fn =[],run=function(){for(var i=0;i<fn.length;i++)fn[i]();},d=document;d.ready=function(f){
                if(!ie&&!wk&&d.addEventListener){return d.addEventListener('DOMContentLoaded',f,false);}if(fn.push(f)>1)return;
                if(ie)(function(){try{d.documentElement.doScroll('left');run();}catch(err){setTimeout(arguments.callee,0);}})();
                else if(wk)var t=setInterval(function(){if(/^(loaded|complete)$/.test(d.readyState))clearInterval(t),run();},0);};
        })();
    </script>
    <script>var isGuest = <?=Yii::$app->user->isGuest?'true':'false',
        ', homeUrl = "',Yii::$app->homeUrl,
        '", siteUri = "',\Yii::$app->request->hostInfo,
        '", _csrf = "',Yii::$app->request->getCsrfToken()?>";
    </script>
</head>
<body>
<?php $this->beginBody() ?>
<div id="f7app">
    <div class="statusbar"></div>

    <?=\app\modules\ucenter\widgets\LoginForm::widget()?>

    <?=\levmecom\widgets\framework7\loginScreen::widget()?>

    <?= isset($this->blocks['layoutsTop']) ? $this->blocks['layoutsTop'] : ''?>

    <?php $this->blocks['pageName'] = isset($this->blocks['pageName']) ? $this->blocks['pageName'] : str_replace('/', '-', Yii::$app->requestedAction->uniqueId)?>

    <div class="view view-main">
        <div data-name="<?=$this->blocks['pageName']?>" class="page pgname_<?=$this->blocks['pageName']?>">

            <?= isset($this->blocks['navbar']) ? $this->blocks['navbar'] : ''?>

            <div class="page-content ptr-content"  data-ptr-distance="95">
                <div class="ptr-preloader" style="display:none">
                    <div class="preloader"></div>
                    <div class="ptr-arrow"></div>
                </div>

                <?= $content ?>
            </div>

            <?= isset($this->blocks['toolbar']) ? $this->blocks['toolbar'] : ''?>

        </div>
    </div>

    <?= isset($this->blocks['layoutsBottom']) ? $this->blocks['layoutsBottom'] : ''?>

    <?= \levmecom\widgets\alert\alert::widget() ?>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
