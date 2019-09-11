<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\uploads\models\Uploads */

$this->title = '上传管理 &raquo; 查看：'.$model->id;
$this->params['breadcrumbs'][] = ['label' => '上传管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
\app\assets\AppAsset::register($this);
?>
<style>h1,h3 {font-size: 18px;}</style>
<div class="uploads-view" style="margin:15px">

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
            'uid:integer',
            'sourceid:integer',
            'idtype:integer',
            'filetype:integer',
            'filename',
            'src',
            'addtime:datetime',
        ],
    ]) ?>

</div>
