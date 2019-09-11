<?php



/* @var $this \yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

?>


<div class="install-db setup2">
    <div class="sys-ck" style="height: 380px;">
        <h1><green>恭喜，系统程序安装成功！</green></h1>
    </div>
    <div class="form-group submitBtn">
        <?= Html::a(Yii::t('install', '基础模块安装 &raquo; '), Url::toRoute(['/install/default/install-base-module']), ['class' => 'btn btn-primary']) ?>
    </div>
</div>
