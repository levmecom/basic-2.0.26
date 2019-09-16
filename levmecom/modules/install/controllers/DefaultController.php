<?php

namespace app\modules\install\controllers;

use app\modules\admin\behaviors\IsSuperAdmin;
use app\modules\adminModules\Module as adminModule;
use app\modules\ucenter\widgets\Ucenter;
use levmecom\aalevme\levHelpers;
use app\modules\ucenter\migrations\installModule;
use app\modules\ucenter\models\User;
use mysqli;
use levmecom\aalevme\Exception;
use yii\web\Controller;

/**
 * Default controller for the `Install` module
 */
class DefaultController extends Controller
{

    public function actionIndex()
    {
        \Yii::$app->getView()->title = '1. 用户协议';
        return levHelpers::render($this, 'index');
    }

    public function actionSetup2()
    {
        \Yii::$app->getView()->title = '2. 系统检查';
        return $this->render('Setup2');
    }

    public function actionInstall()
    {
        \Yii::$app->getView()->title = '3. 程序安装';

        $model = new \app\modules\install\models\InstallForm();

        $gpms = \Yii::$app->request->post();
        if ($model->load($gpms)) {
            if ($model->validate()) {
                $res = $this->check_db($gpms['InstallForm']['localhost'], $gpms['InstallForm']['dbusername'], $gpms['InstallForm']['dbpassword'], $gpms['InstallForm']['dbname'], $gpms['InstallForm']['dbtablepre'], $gpms['InstallForm']);
                if ($res === true) {
                    \Yii::$app->getView()->title = '4. 系统程序安装完成';
                    return $this->render('succeed');
                }else {
                    \Yii::$app->getView()->title = '系统程序安装失败';
                    return levHelpers::showMessage($res);
                }
            }
        }

        return $this->render('install', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function actionInstallBaseModule()
    {
        \Yii::$app->getView()->title = '5. 基础模块安装';

        return $this->render('installBaseModule');
    }
    public function actionBaseModules() {
        IsSuperAdmin::checkSuperAdmin();

        $this->layout = '/yiimain';

        $baseModules = ['adminModules', 'navigation', 'ucenter', 'admin', 'uploads', 'forum'];
        foreach ($baseModules as $baseModule) {
            adminModule::checkModuleInstalls($baseModule, 'baseModuleInstall');
        }

        \Yii::$app->cache->delete('baseModuleInstalling');

        return $this->render('BaseModuleFinish');
    }


    public function check_db($dbhost, $dbuser, $dbpw, $dbname, $tablepre, $gpms = array()) {
        if (is_file(\Yii::getAlias('@app').'/runtime/.install.lock')) {
            return (\Yii::t('install', '程序已经安装，不能重复安装！'));
        }

        if(!function_exists('mysqli_connect')) {
            return (\Yii::t('install', '数据库函数未定义（mysqli_connect）'));
        }
        $mysqlmode = 'mysqli';
        $link = ($mysqlmode == 'mysql') ? @mysql_connect($dbhost, $dbuser, $dbpw) : new mysqli($dbhost, $dbuser, $dbpw);
        if(!$link) {
            $errno = ($mysqlmode == 'mysql') ? mysql_errno() : mysqli_errno();
            $error = ($mysqlmode == 'mysql') ? mysql_error() : mysqli_error();
            if($errno == 1045) {
                return (\Yii::t('install', '数据库连接错误（1045）'));
            } elseif($errno == 2003) {
                return (\Yii::t('install', '数据库连接失败（2003）'));
            } else {
                return (\Yii::t('install', '数据库错误').$error);
            }
        } else {
            if($query = (($mysqlmode == 'mysql') ? @mysql_query("SHOW TABLES FROM $dbname") : $link->query("SHOW TABLES FROM $dbname"))) {
                if(!$query) {
                    return ($dbname.\Yii::t('install', '数据库安装失败'));
                }
                while($row = (($mysqlmode == 'mysql') ? mysql_fetch_row($query) : $query->fetch_row())) {
                    if(preg_match("/^$tablepre/", $row[0])) {
                        return ($dbname.\Yii::t('install', '数据库存在相同前缀的表，请修改表前缀或删除表'));
                    }
                }
            }
        }
        if (\Yii::$app->db->charset =='utf8mb4') {
            $dbsql = "CREATE DATABASE `$dbname` DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci";
        }else {
            $dbsql = "CREATE DATABASE `$dbname`";
        }
        $query = ($mysqlmode == 'mysql') ? @mysql_query($dbsql) : $link->query($dbsql);
        try {

            copy(\Yii::getAlias('@app').'/config/bootstrap.default.php', \Yii::getAlias('@app').'/config/bootstrap.php');
            //copy(\Yii::getAlias('@app').'/config/user.default.php', \Yii::getAlias('@app').'/config/user.php');

            $data = file_get_contents(\Yii::getAlias('@app').'/config/const.default.php');
            $data = str_ireplace(['{yii_env}', '{yii_debug}', '{super_admin}'], [$gpms['yiienv'], $gpms['yiidebug'], $gpms['mgusername']], $data);
            file_put_contents(\Yii::getAlias('@app').'/config/const.php', $data);
            $data = file_get_contents(\Yii::getAlias('@app').'/config/db.default.php');
            $data = str_ireplace(['{localhost}', '{dbname}', '{username}', '{password}', '{tableprefix}'], [$dbhost, $dbname, $dbuser, $dbpw, $tablepre], $data);
            file_put_contents(\Yii::getAlias('@app').'/config/db.php', $data);
            file_put_contents(\Yii::getAlias('@app').'/runtime/.install.lock', date('Y-m-d H:i:s', time()));

            \Yii::$app->set('db', require \Yii::getAlias('@app') . '/config/db.php');

            $userTab = (new installModule());
            $userTab->compact = true;
            $userTab->safeUp();

            $model = new User();

            $password_hash = $model->setPassword($gpms['mgpassword']);
            $authKey = $model->generateAuthKey();
            $userTab->insert($userTab->LevTableName, ['username'=>$gpms['mgusername'], 'password_hash'=>$password_hash, 'email'=>$gpms['mgemail'], 'authKey'=>$authKey, 'status'=>User::STATUS_ACTIVE, 'addtime'=>time()]);

            Ucenter::doLogin($gpms['mgusername'], $gpms['mgpassword']);

        } catch (Exception $e) {
            return ('创建数据库失败！'.$e->getMessage());
        }
        return true;
    }

}
