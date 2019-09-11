<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\ucenter\modules\registers\models\UcenterRegisters */

$this->title = '批量注册 &raquo; 更新 : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ucenter Registers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="ucenter-registers-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
