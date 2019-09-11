<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class F7Asset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
    ];
    public $depends = [
        'app\assets\F7AssetDepends',
    ];
}

class F7AssetDepends extends AssetBundle
{
    public $sourcePath = '@assets/statics';
    public $css = [
        'font-awesome-4.7.0/css/font-awesome.min.css',
        'Framework7/1.6.7/dist/css/framework7.ios.css',
        'Framework7/1.6.7/upscroller/framework7.upscroller.css',
    ];
    public $js = [
        'common/jquery.min.js',
        'Framework7/1.6.7/dist/js/framework7.min.js',
        'Framework7/1.6.7/upscroller/framework7.upscroller.js',
        'Framework7/1.6.7/F7-init.js',
    ];
}