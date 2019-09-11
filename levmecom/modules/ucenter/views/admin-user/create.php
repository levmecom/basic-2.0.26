<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\ucenter\models\User */

$this->title = '用户管理 &raquo; 创建';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
