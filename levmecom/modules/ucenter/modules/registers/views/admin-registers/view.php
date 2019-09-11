<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\ucenter\modules\registers\models\UcenterRegisters */

$this->title = '批量注册 &raquo; 查看：'.$model->name;
$this->params['breadcrumbs'][] = ['label' => '批量注册', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
\app\assets\AppAsset::register($this);
?>
<style>h1,h3 {font-size: 18px;}</style>
<div class="ucenter-registers-view" style="margin:15px">

    <h1><?= $this->title ?></h1>

    <p style="margin: 15px;">
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger exit',
            'data' => [
                'confirm' => '您确定要删除此项吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id:integer',
            'typeid:integer',
            'name',
            'username',
            'uid:integer',
            'password',
            'status:integer',
            'addtime:datetime',
        ],
    ]) ?>

</div>
