<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\levmecitys\models\Levmecitys */

$this->title = '省市管理 &raquo; 更新 : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Levmecitys', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="levmecitys-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
