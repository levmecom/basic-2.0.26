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
class F7_v4410Asset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'statics/fontawesome-free-5.10.1-web/css/all.min.css',
        'statics/font-awesome-4.7.0/css/font-awesome.min.css',
        'statics/F7-4.4.10/css/framework7.bundle.min.css',
        'statics/F7-4.4.10/myapp.css',
    ];
    public $js = [
        'statics/common/jquery.min.js',
        'statics/form.4.2.2/jquery.form.min.js',
        'statics/F7-4.4.10/js/framework7.bundle.min.js',
        'statics/F7-4.4.10/init.js',
        'statics/F7-4.4.10/myapp.js',
    ];
    public $depends = [
        //'app\assets\F7_v4410AssetDepends',
    ];
}

class F7_v4410AssetDepends extends AssetBundle
{
    public $sourcePath = '@assets/statics';
    public $css = [
        'font-awesome-4.7.0/css/font-awesome.min.css',
        'F7-4.4.10/css/framework7.bundle.min.css',
        'F7-4.4.10/myapp.css',
    ];
    public $js = [
        'common/jquery.min.js',
        'form.4.2.2/jquery.form.min.js',
        'F7-4.4.10/js/framework7.bundle.min.js',
        'F7-4.4.10/init.js',
        'F7-4.4.10/myapp.js',
    ];
}