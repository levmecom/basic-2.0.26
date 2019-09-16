<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\levmecitys\models\Levmecitys */

$this->title = '省市管理 &raquo; 创建';
$this->params['breadcrumbs'][] = ['label' => 'Levmecitys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="levmecitys-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
