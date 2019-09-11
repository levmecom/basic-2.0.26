<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\SettingsModel */

$this->title = '设置管理 &raquo; 查看：'.$model->title;
$this->params['breadcrumbs'][] = ['label' => '设置管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
\app\assets\AppAsset::register($this);
?>
<style>h1,h3 {font-size: 18px;}</style>
<div class="settings-model-view" style="margin:15px">

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
            'moduleidentifier',
            'title',
            'placeholder',
            'inputname',
            'inputtype',
            'inputvalue',
            'settings:ntext',
            'displayorder:integer',
            'status:integer',
            'uptime:datetime',
            'addtime:datetime',
        ],
    ]) ?>

</div>
