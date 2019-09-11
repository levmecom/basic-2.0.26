<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\uploads\models\Uploads */

$this->title = '上传管理 &raquo; 更新 : ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Uploads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="uploads-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
