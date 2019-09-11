<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <style>
        red {color:red;}
        .navbar-header .navbar-brand {
            color: #fff;
            font-size: 28px;
        }
        .navbar-nav.navbar-center a {
            font-size: 18px;
            color: #fff !important;
        }
        .navbar-nav.navbar-center {
            margin-left: 100px;
        }
        .form-group.submitBtn {
            text-align: center;
        }
        .install-db .form-group.submitBtn {
            margin-top: 15px;
        }
        .sys-ck {
            height: 480px;
            overflow: auto;
        }
        .install-db.setup2 h4 {text-align:left;font-size:16px;}
        .install-db {
            width: 760px;
            margin: -20px auto 0;
        }
        .form-group.submitBtn .btn.btn-primary {
            padding: 2px 0;
            height: 36px;
            width: 202px;
            text-align: center;
            line-height: 32px;
        }
        .form-group.submitBtn .btn.btn-primary.gray {
            background: #999;
            border: none;
        }
        .install-db .tab-x {width:100%;text-align:center;
            background: #f9f9f9;
            border-color: #eee;
        }
        .install-db table td {
            border-color: #eee;
            padding: 5px 2px;
            color: green;
        }
        .install-db label {
            color: #666;
            margin-bottom: 1px;
            font-size: 13px;
        }
        .install-db input {
            padding: 2px 10px;
            height: 32px;
            color: #444;
            vertical-align: middle;
        }
        .install-db .form-fields .form-group, .install-db .help-block {
            margin: 0 0 12px;
        }
        .install-db h4 {
            font-size: 20px;
            width: 100%;
            margin: 15px 0 0;
        }
        green {
            color: green;
            width: 100%;
            margin: 55px auto;
            text-align: center;
            display: block;
        }
        .form-fields {
            position: relative;
        }
        .install-db .form-fields h4 {
            padding-left: 200px;
            font-size: 16px;
        }
        .form-fields .form-group {
            display: flex;
            flex-wrap: wrap;
        }
        .form-fields .form-group label {
            white-space: nowrap;
            width: 200px;
            padding-right: 15px;
            vertical-align: middle;
            line-height: 31px;
        }
        .form-fields .form-group label.control-label {
            text-align: right;
        }
        .form-fields .form-group .help-block {
            text-align: right;
            position: absolute;
            right: 0;
            line-height: 31px;
        }
        .form-fields .form-group input[type=text] {
            width: calc(100% - 200px);
        }
        .install-db input[type="radio"] {
            padding: 0;
            margin: auto;
        }
        .env-conf .form-group {
            margin-bottom: 0 !important;
        }
        .env-conf .form-group label {
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name.' 安装向导！',
        'brandUrl' => '#',
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-center'],
        'items' => [
            ['label' => $this->title.'', 'url' => ['#']],
        ],
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget()?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><a class="link" href="http://levme.com" target="_blank"><?= Yii::t('common', '技术支持网站')?>： Levme.com</a></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
