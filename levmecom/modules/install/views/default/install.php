<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\install\models\InstallForm */
/* @var $form ActiveForm */
?>
<div class="install-db">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-fields">
        <div class="env-conf">
            <h4>1. 环境配置</h4>
            <?= $form->field($model, 'yiienv')->radioList(['dev'=>'开发环境', 'prod'=>'生产环境'], ['value'=>'dev', 'checked'=>true]) ?>
            <?= $form->field($model, 'yiidebug')->radioList([1=>'开启', 0=>'关闭'], ['value'=>1, 'checked'=>true]) ?>
        </div>
        <h4>2. 填写数据库信息</h4>
        <?= $form->field($model, 'localhost')->textInput(['placeholder'=>Yii::t('install', '数据库服务器地址, 一般为 localhost'), 'value'=>'localhost']) ?>
        <?= $form->field($model, 'dbname')->textInput(['placeholder'=>Yii::t('install', '一般为 Mysql 数据库'), 'value'=>'levmecom']) ?>
        <?= $form->field($model, 'dbusername')->textInput(['placeholder'=>'', 'value'=>'root']) ?>
        <?= $form->field($model, 'dbpassword')->textInput(['placeholder'=>'一般为 Mysql 数据库', 'value'=>'']) ?>
        <?= $form->field($model, 'dbtablepre')->textInput(['placeholder'=>Yii::t('install', '同一数据库运行多个论坛时，请修改前缀'), 'value'=>'pre_']) ?>
        <?= $form->field($model, 'systememail')->textInput(['placeholder'=>Yii::t('install', '用于发送程序错误报告'), 'value'=>'admin@admin.com']) ?>

        <h4>3. 填写管理员信息</h4>
        <?= $form->field($model, 'mgusername')->textInput(['placeholder'=>'', 'value'=>'admin']) ?>
        <?= $form->field($model, 'mgpassword')->textInput(['placeholder'=>'', 'value'=>'admin123']) ?>
        <?= $form->field($model, 'remgpassword')->textInput(['placeholder'=>'', 'value'=>'admin123']) ?>
        <?= $form->field($model, 'mgemail')->textInput(['placeholder'=>'', 'value'=>'admin@admin.com']) ?>
    </div>
        <div class="form-group submitBtn">
            <?= Html::submitButton(Yii::t('install', '下一步'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('install', '返回上一步'), Yii::$app->request->referrer, ['class' => 'btn btn-primary gray']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- install-db -->
