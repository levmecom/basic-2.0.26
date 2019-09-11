<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-20 01:03
 *
 * 项目：levme  -  $  - adminAsset.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

namespace app\modules\admin\assets;

class adminAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@app/modules/admin/assets/statics';
    //public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'admin.css',
    ];
    public $js = [
        'admin.js',
    ];
    public $depends = [
        'app\assets\F7_v4410Asset',
    ];

}