<?php

use yii\helpers\Html;

$func_items = array('mysqli_connect', 'gethostbyname', 'file_get_contents', 'xml_parser_create','curl_init');

$lang = ['os'=>'操作系统', 'php'=>'PHP版本', 'attachmentupload'=>'附件上传', 'gdversion'=>'GD库', 'opcache'=>'Opcache', 'diskspace'=>'磁盘空间', 'curl'=>'CURL库'];

$env_items = array
(
    'os' => array('c' => 'PHP_OS', 'r' => '不限制', 'b' => 'unix'),//5.5.3
    'php' => array('c' => 'PHP_VERSION', 'r' => '7.0', 'b' => '7.0'),
    'attachmentupload' => array('r' => '不限制', 'b' => '2M'),
    'gdversion' => array('r' => '1.0', 'b' => '2.0'),
    'curl' => array('r' => 'enable', 'b' => 'enable'),
    'opcache' => array('r' => '不限制', 'b' => 'enable'),
    'diskspace' => array('r' => 300 * 1048576, 'b' => '不限制'),
);

$dirfile_items = array
(

    'const' => array('type' => 'file', 'path' => Yii::getAlias('@app').'/config/const.php'),
    'bootstrap' => array('type' => 'file', 'path' => Yii::getAlias('@app').'/config/bootstrap.php'),
    'db' => array('type' => 'file', 'path' => Yii::getAlias('@app').'/config/db.php'),
    'config_dir' => array('type' => 'dir', 'path' => Yii::getAlias('@app').'/config'),
    'runtime' => array('type' => 'dir', 'path' => Yii::getAlias('@runtime')),

);

function dir_writeable($dir) {
    $writeable = 0;
    if(!is_dir($dir)) {
        @mkdir($dir, 0777);
    }
    if(is_dir($dir)) {
        if($fp = @fopen("$dir/test.txt", 'w')) {
            @fclose($fp);
            @unlink("$dir/test.txt");
            $writeable = 1;
        } else {
            $writeable = 0;
        }
    }
    return $writeable;
}

function dirfile_check(&$dirfile_items) {
    foreach($dirfile_items as $key => $item) {
        $item_path = $item['path'];
        if($item['type'] == 'dir') {
            if(!dir_writeable($item_path)) {
                if(is_dir($item_path)) {
                    $dirfile_items[$key]['status'] = 0;
                    $dirfile_items[$key]['current'] = '+r';
                } else {
                    $dirfile_items[$key]['status'] = -1;
                    $dirfile_items[$key]['current'] = 'nodir';
                }
            } else {
                $dirfile_items[$key]['status'] = 1;
                $dirfile_items[$key]['current'] = '+r+w';
            }
        } else {
            if(file_exists($item_path)) {
                if(is_writable($item_path)) {
                    $dirfile_items[$key]['status'] = 1;
                    $dirfile_items[$key]['current'] = '+r+w';
                } else {
                    $dirfile_items[$key]['status'] = 0;
                    $dirfile_items[$key]['current'] = '+r';
                }
            } else {
                if(dir_writeable(dirname($item_path))) {
                    $dirfile_items[$key]['status'] = 1;
                    $dirfile_items[$key]['current'] = '+r+w';
                } else {
                    $dirfile_items[$key]['status'] = -1;
                    $dirfile_items[$key]['current'] = 'nofile';
                }
            }
        }
    }
}

function env_check(&$env_items) {
    $lang = ['enable'=>'开启', 'disable'=>'关闭'];
    foreach($env_items as $key => $item) {
        if($key == 'php') {
            $env_items[$key]['current'] = PHP_VERSION;
        } elseif($key == 'attachmentupload') {
            $env_items[$key]['current'] = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknow';
        } elseif($key == 'gdversion') {
            $tmp = function_exists('gd_info') ? gd_info() : array();
            $env_items[$key]['current'] = empty($tmp['GD Version']) ? 'noext' : $tmp['GD Version'];
            unset($tmp);
        } elseif($key == 'diskspace') {
            if(function_exists('disk_free_space')) {
                $env_items[$key]['current'] = disk_free_space(Yii::getAlias('@app'));
            } else {
                $env_items[$key]['current'] = 'unknow';
            }
        } elseif(isset($item['c'])) {
            $env_items[$key]['current'] = constant($item['c']);
        } elseif($key == 'opcache') {
            $opcache_data = function_exists('opcache_get_configuration') ? opcache_get_configuration() : array();
            $env_items[$key]['current'] = !empty($opcache_data['directives']['opcache.enable']) ? $lang['enable'] : $lang['disable'];
        } elseif($key == 'curl') {
            if(function_exists('curl_init') && function_exists('curl_version')){
                $v = curl_version();
                $env_items[$key]['current'] = $lang['enable'].' '.$v['version'];
            }else{
                $env_items[$key]['current'] = $lang['disable'];
            }
        }

        $env_items[$key]['status'] = 1;
        if($item['r'] != '不限制' && $env_items[$key]['current'] <$item['r']) {
            $env_items[$key]['status'] = 0;
        }
    }
}

/* @var $this \yii\web\View */
?>

<div class="install-db setup2">
<div class="sys-ck">
    <?php $succeed = 1; dirfile_check($dirfile_items); env_check($env_items); ?>

    <h4>1. 环境检查</h4>
    <table class="tab-x" border="1">
        <tr><td>项目</td><td>所需配置</td><td>最佳</td><td>当前环境</td><td style="width: 55px;">结果</td></tr>
        <?php foreach ($env_items as $k => $v) {?>
            <tr><td><?= $lang[$k] ?></td><td><?= $v['r'] ?></td><td><?= $v['b'] ?></td><td><?= $v['current'] ?></td>
                <td><b><?= $v['status'] ? '开启' : '<red>关闭</red>';?></b></td></tr>
        <?php $succeed = ($succeed && $v['status']) ? 1 : 0; } ?>
    </table>

    <h4>2. 目录、文件权限检查</h4>
    <table class="tab-x" border="1">
        <tr><td>项录或文件</td><td style="width: 55px;">结果</td></tr>
        <?php foreach ($dirfile_items as $v) {?>
            <tr><td style="text-align:left"><?= $v['path'] ?></td><td><b><?= $v['status'] ==1 ? '开启' : '<red>关闭</red>';?></b></td></tr>
            <?php $succeed = ($succeed && $v['status']) ? 1 : 0; } ?>
    </table>

    <h4>3. 函数依赖性检查</h4>
    <table class="tab-x" border="1">
        <tr><td>函数名</td><td style="width: 55px;">结果</td></tr>
        <?php foreach ($func_items as $v) {?>
            <?php $_ck = function_exists($v) ? 1 : 0; ?>
            <tr><td style="text-align:left"><?= $v ?></td><td><b><?= $_ck ==1 ? '开启' : '<red>关闭</red>';?></b></td></tr>
            <?php $succeed = ($succeed && $_ck) ? 1 : 0; } ?>
    </table>
</div>
    <div class="form-group submitBtn">
        <?php
        if ($succeed) {
            echo Html::a(Yii::t('install', '下一步'), [\yii\helpers\Url::to('/install/default/install')], ['class' => 'btn btn-primary']);
        }else {
            echo Html::a(Yii::t('install', '系统不达标'), false, ['class' => 'btn btn-primary gray']);
        }
        ?>
        <?= Html::a(Yii::t('install', '返回上一步'), Yii::$app->request->referrer, ['class' => 'btn btn-primary gray']) ?>
    </div>
</div><!-- install-db -->



















