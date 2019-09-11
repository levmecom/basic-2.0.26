<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\ucenter\models\User */

$this->title = '用户管理 &raquo; 更新 : ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
