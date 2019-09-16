<?php

namespace app\modules\adminModules;

use app\modules\adminModules\models\AdminModulesModel;
use app\modules\adminModules\Module as AdminModule;
use yii\helpers\FileHelper;

/**
 * adminModules module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\adminModules\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        AdminModule::checkModuleInstall($this->uniqueId);//请不要改变本行代码

    }

    public static function getModuleClass() {
        return get_class(\Yii::$app->controller->module) ? substr(strrchr(get_class(\Yii::$app->controller->module), '\\'), 1) : '';
    }

    public static function getDirModulesIdentifier() {
        $dirs = FileHelper::findDirectories(dirname(__DIR__));
        $res = [];
        foreach ($dirs as $dir) {
            $dir = str_ireplace('\\', '/', $dir);
            $mdir = stristr($dir, 'modules/');
            $drcount = substr_count($mdir, '/');
            $dmcount = substr_count($mdir, 'modules/');
            if ($drcount == $dmcount*2 - 1) {
                $res[] = ['identifier'=>str_replace('modules/', '', $mdir), 'dir'=>$dir, 'mdir'=>$mdir];
            }
        }
        return $res;
    }

    public static function isBaseModule($moduleType) {
        return AdminModulesModel::isBaseModule($moduleType);
    }

    public static function getModuleInfo($identifier) {
        return AdminModulesModel::find()->where(['identifier'=>$identifier])->asArray()->one();
    }

    public static function setModuleInfo($data = []) {
        unset($data['id'], $data['typeid'], $data['identifier'], $data['addtime']);
        $data['identifier'] = \Yii::$app->controller->module->uniqueId;
        $data['uptime'] = time();
        if (in_array($data['identifier'], ['adminModules', 'navigation', 'ucenter', 'admin', 'uploads']) || stripos($data['copyright'], 'levme.com.') !==false) {
            $data['typeid'] = AdminModulesModel::IS_BASE_MODULE;
        }elseif (stripos($data['copyright'], 'levme.com') !==false) {
            $data['typeid'] = AdminModulesModel::IS_LEVMECOM_MODULE;
        }

        $model = new AdminModulesModel();
        $ck = $model::findOne(['identifier'=>$data['identifier']]);
        $model = $ck ? $ck : $model;

        if (!$ck) $data['addtime'] = time();

        $attributes = $model->attributeLabels();
        foreach ($data as $key => $val) {
            if (!isset($attributes[$key])) unset($data[$key]);
        }
        if (empty($data)) return false;

        return $model->load($data, '') && $model->save();
    }

    public static function delModuleInfo($moduleUniqueId) {
        return AdminModulesModel::deleteAll(['identifier'=>$moduleUniqueId]);
    }

    public static function checkModuleInstalls($moduleUniqueId, $do = '') {
        self::checkModuleInstall('adminModules', $do);
        self::checkModuleInstall('navigation', $do);
        self::checkModuleInstall($moduleUniqueId, $do);
    }
    public static function checkModuleInstall($moduleUniqueId, $do = '') {

        if (!self::checkInstallFile($moduleUniqueId) && stripos(\Yii::$app->request->getUrl(), 'admin-install') ===false) {
            header('Location:'.\Yii::$app->homeUrl. $moduleUniqueId . '/admin-install?do='.$do);
            exit();
        }

    }

    public static function checkInstallFile($moduleUniqueId) {
        return is_file(self::getInstallFileDir().self::getInstallLockFile($moduleUniqueId));
    }

    public static function getInstallFileDir() {
        return \Yii::getAlias('@app').'/runtime/.install.locks/';
    }

    public static function getInstallLockFile($moduleUniqueId) {
        return md5($moduleUniqueId).'.install.lock';
    }

}
