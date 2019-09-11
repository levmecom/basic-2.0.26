<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\uploads\models\Uploads */

$this->title = '上传管理 &raquo; 创建';
$this->params['breadcrumbs'][] = ['label' => 'Uploads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="uploads-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
