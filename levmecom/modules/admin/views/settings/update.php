<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\SettingsModel */

$this->title = '设置管理 &raquo; 更新 : ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Settings Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="settings-model-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
