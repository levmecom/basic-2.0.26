<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-17 10:39
 *
 * 项目：levme  -  $  - appAssets.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

namespace levmecom\widgets\nativeShare\assets;

use yii\web\AssetBundle;

class appAssets extends AssetBundle
{

    public $sourcePath = '@levmecom/widgets/nativeShare/assets/statics';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'NativeShare.js',
    ];
    public $depends = [
        //'app\assets\F7_v4410AssetDepends',
    ];

}