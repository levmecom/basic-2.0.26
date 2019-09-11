<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-11 18:06
 *
 * 项目：levme  -  $  - forumAssets.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */
namespace app\modules\forum\assets;

class forumAssets extends \yii\web\AssetBundle
{

    public $sourcePath = '@levmecom/modules/forum/assets/statics';
    public $baseUrl = '@web';
    public $css = [
        'css.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];

}