<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\ucenter\modules\registers\models\UcenterRegisters */

$this->title = '批量注册 &raquo; 创建';
$this->params['breadcrumbs'][] = ['label' => 'Ucenter Registers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ucenter-registers-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
