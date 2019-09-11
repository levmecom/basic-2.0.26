<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\SettingsModel */

$this->title = '设置管理 &raquo; 创建';
$this->params['breadcrumbs'][] = ['label' => 'Settings Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-model-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
