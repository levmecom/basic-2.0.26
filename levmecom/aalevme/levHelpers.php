<?php
/**
 * @link http://levme.com/
 * @copyright Copyright (c) 2008 levme.com Software LLC
 * @license http://levme.com/license/
 */
namespace levmecom\aalevme;

use levmecom\aalevme\ext\LevMobileDetect;

class levHelpers extends baseLevHelpers {

    public static function showMessage($message, $tourl = '', $name = '', $referer = '') {
        return \Yii::$app->view->render('@app/modules/ucenter/views/default/message',
                ['message'=>$message, 'tourl'=>$tourl, 'name'=>$name, 'referer'=>$referer]);
    }

    /**
     * @param int $status 正数：成功，负数：失败
     * @param string $message
     * @param array $ext
     * @return array
     */
    public static function responseMsg($status = 1, $message = '操作成功', $ext = []) {
        if ($status <0) {
            $ext['error'] = ['message'=>$message];
        }else {
            $ext['succeed'] = $status;
        }
        $ext['message'] = $message;
        $ext['status'] = $status;
        return $ext;
    }

    public static function getHomeFull() {
        return \Yii::$app->request->hostInfo.\Yii::getAlias('@web');
    }

    public static function stripTags($value) {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = self::stripTags($v);
            }
        }else {
            return str_replace(['&', ';', '\\'], '', trim(strip_tags($value)));
        }
        return $value;
    }

    public static function mkdirs($dir, $mode = 0777, $makeindex = TRUE){
        if(!is_dir($dir)) {
            self::mkdirs(dirname($dir), $mode, $makeindex);
            @mkdir($dir, $mode);
            if(!empty($makeindex)) {
                @touch($dir.'/index.html');
                @chmod($dir.'/index.html', 0777);
            }
        }
        return true;
    }

    public static function ckmobile() {
        if (!isset(\Yii::$app->params['isMobile'])) {
            $mobile = new LevMobileDetect();
            \Yii::$app->params['isMobile'] = $mobile->isMobile() ? 1 : 0;
            \Yii::$app->params['isTablet'] = $mobile->isTablet() ? 1 : 0;
        }
        return \Yii::$app->params['isMobile'];
    }

    public static function cktpl() {
        $pc = \Yii::$app->request->get('pc');
        if ($pc ==4) return true; //调用手机模板 - 默认
        if ($pc ==1) return false; //调用电脑模板
        return self::ckmobile();
    }

    /**
     *
     * 默认调用手机模板，无手机模板调用电脑模板，
     * 电脑（pc）访问时，电脑模板和布局文件同时存在则调用。
     * pc模板位于views/pc/目录，布局模板位于views/pc/layouts/目录，模块也是如此。
     * 【注意】手机与电脑模板及布局模板文件名必须相同，目录不同。
     *
     * @param $obj
     * @param $tmp
     * @param array $params
     * @return mixed
     */
    public static function render($obj, $tmp, $params = []) {

        //$cname = str_replace(['controller', '\\'], '', strtolower(strrchr(get_class($obj), '\\')));
        $cname = \Yii::$app->controller->id;
        $mtpl = $obj->module->getViewPath() . '/' . $cname . '/' . $tmp . '.php';
        if (!self::cktpl() || !is_file($mtpl)) {//电脑模板和布局文件同时存在则调用
            $ckfile = $ckMfile = false;
            if ($obj->module->layout) {
                $layout = str_ireplace('/layouts', '/pc/layouts', $obj->module->getLayoutPath());
                $ckMfile = is_file($layout . '/' . $obj->module->layout . '.php');
            }
            if (!$ckMfile) {
                $layout = str_ireplace('/layouts', '/pc/layouts', \Yii::$app->getLayoutPath());
                $ckfile = is_file($layout . '/' . \Yii::$app->layout . '.php');
            }

            $pcViewPath = $obj->module->getViewPath() . '/pc';

            if (($ckfile || $ckMfile) && is_file($pcViewPath . '/' . $cname . '/' . $tmp . '.php')) {
                if ($ckMfile) {
                    $obj->module->setLayoutPath($layout);
                } else {
                    \Yii::$app->setLayoutPath($layout);
                }
                $obj->module->setViewPath($pcViewPath);
            }
        }
        return $obj->render($tmp, $params);

    }

}