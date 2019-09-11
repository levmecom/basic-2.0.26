<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-09-11 17:40
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */


/* @var $this \yii\web\View */
?>



<div class="install-db setup2">
    <div class="sys-ck" style="height: 80px;">
        <?php Yii::$app->cache->set('baseModuleInstalling', Yii::$app->cache->get('baseModuleInstalling').$this->title.' => 安装完成！<br>', 120)?>
        <div style="color: green;text-align: center;">
            <?=Yii::$app->cache->get('baseModuleInstalling')?>
            <small><font color="red">正在安装，请耐心等候... ...</font></small><br>
        </div>
    </div>
</div>

<script>
    window.setTimeout(function () {
        window.location = '<?=\yii\helpers\Url::toRoute(['/install/default/base-modules'])?>';
    }, 800);
</script>
