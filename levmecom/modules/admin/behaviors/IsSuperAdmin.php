<?php /** @noinspection PhpComposerExtensionStubsInspection */


namespace app\modules\admin\behaviors;


use app\modules\adminModules\Module as AdminModule;
use levmecom\aalevme\levHelpers;
use yii\base\Behavior;
use levmecom\aalevme\Exception;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\Controller;

class IsSuperAdmin extends Behavior
{
    public $checkAll = true;

    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }


    /**
     * 通过检查【模块、控制器、action中是否带有admin】后确定访问
     *
     * @throws Exception
     */
    public function beforeAction()
    {

        \Yii::$app->controller->layout = '@app/modules/admin/views/layouts/F7_v4410_admin';//管理后台布局文件

        if ($this->checkAll || stripos(\Yii::$app->controller->uniqueId, 'admin') !==false) {
            IsSuperAdmin::checkSuperAdmin();
        }
    }

    public static function checkSuperAdmin() {
        if (\Yii::$app->user->isGuest) {
            throw new Exception('抱歉，您需要登陆管理员身份才能访问');
        }
        if (!defined('SUPER_ADMIN') || SUPER_ADMIN == '') {
            throw new Exception('未设置超级管理员，请先设置超级管理员');
        }
        if (\Yii::$app->user->identity->username != SUPER_ADMIN) {
            throw new Exception('您没有超级管理权限：'. \Yii::$app->controller->uniqueId);
        }
    }

    public static function adminSearchForm() {
        if (is_array(\Yii::$app->request->get('srh'))) {
            $where = [];
            foreach (\Yii::$app->request->get('srh') as $k => $v) {
                $v = levHelpers::stripTags($v);
                $k = levHelpers::stripTags($k);
                if (substr($k, 0, 1) =='_') continue;
                if (is_numeric($v) || ($v && isset($bodyParams['_dy']))) {
                    $where[] = " `$k`='$v' ";
                }else if ($v) {
                    $where[] = " `$k` LIKE '%$v%' ";
                }
            }

            if ($where) {
                $where = implode(' AND ', $where);
                return $where;
            }
        }
        return '';
    }

    /**
     * 返回日期查询where
     *
     * @return string
     */
    public static function adminDateSearch() {
        $srh = \Yii::$app->request->get('srh');
        if (isset($srh['_daydate'])) {
            $_daydate = explode('.', $srh['_daydate']);
            $field = levHelpers::stripTags($_daydate[1]);
            if ($_daydate[0] == 1) {
                $today = date('Y-m-d', time());
                $stime = strtotime($today);
                $etime = time();
            } else if ($_daydate[0] == 2) {
                $yestoday = date('Y-m-d', time() - 3600 * 24);
                $today = date('Y-m-d', time());
                $stime = strtotime($yestoday);
                $etime = strtotime($today);
            } else {
                $field = isset($_daydate[2]) ? levHelpers::stripTags($_daydate[2]) : '';
                $stime = strtotime($_daydate[0]) ?: 0;
                $etime = strtotime($_daydate[1]) ?: time();
            }

            $field = $field ? $field : 'addtime';

            return " $field BETWEEN $stime AND $etime ";

        }
        return '';
    }

    public static function adminDelete($table = '') {
        if (\Yii::$app->request->post()) {
            $insql = levHelpers::inSql(\Yii::$app->request->post('ids'), '', '', [], true, true);//echo $insql;

            //$table = levHelpers::stripTags(\Yii::$app->request->post('optable'));

            $field = levHelpers::stripTags(\Yii::$app->request->post('field'));
            $field = $field ? $field : 'id';

            if ($table && $insql) {
                $count = \Yii::$app->db->createCommand()->delete($table, "$field IN($insql)")->execute();
                return json_encode(levHelpers::responseMsg(1, '成功删除 '.$count.' 条数据', ['delCount'=>$count]));
            }
            return json_encode(levHelpers::responseMsg(-4001, '没有可删除数据或未提交数据表'));
        }
        return json_encode(levHelpers::responseMsg(-4002, '请提交数据'));
    }

    public static function adminDayDelete($table = '', $extWhere = '') {
        if (\Yii::$app->request->post()) {
            $day = floatval(\Yii::$app->request->post('day'));

            //$table = levHelpers::stripTags(\Yii::$app->request->post('optable'));

            $field = levHelpers::stripTags(\Yii::$app->request->post('field'));
            $field = $field ? $field : 'addtime';

            //$extWhere = levHelpers::stripTags(\Yii::$app->request->post('extWhere')) ?: '';

            if ($table && $day) {
                $addtime = time() - $day *3600 *24;
                $count = \Yii::$app->db->createCommand()->delete($table, "$extWhere $field < $addtime")->execute();
                return json_encode(levHelpers::responseMsg(1, '成功删除 '.$count.' 条数据', ['delCount'=>$count]));
            }
            return json_encode(levHelpers::responseMsg(-4001, '没有可删除数据或未提交数据表'));
        }
        return json_encode(levHelpers::responseMsg(-4002, '请提交数据'));
    }

    /**
     * @return false|string
     * @throws \yii\db\Exception
     */
    public static function setStatus($optab = '') {
        $opid = intval(\Yii::$app->request->post('opid'));
        if ($opid <1) {
            return json_encode(levHelpers::responseMsg(-1023, 'opid不能为空'));
        }
        //$optab = levHelpers::stripTags(\Yii::$app->request->post('optab'));
        if (!$optab) {
            return json_encode(levHelpers::responseMsg(-1024, '数据表不能为空'));
        }
        $status = intval(\Yii::$app->request->post('status')) ? 1 : 0;

        $count = \Yii::$app->db->createCommand()->update($optab, ['status'=>$status], ['id'=>$opid])->execute();
        return json_encode(levHelpers::responseMsg(1, '操作成功', ['count'=>$count]));
    }

    public static function setField($optab = '') {
        $opid = intval(\Yii::$app->request->post('opid'));
        if ($opid <1) {
            return json_encode(levHelpers::responseMsg(-1023, 'opid不能为空'));
        }
        //$optab = levHelpers::stripTags(\Yii::$app->request->post('optab'));
        if (!$optab) {
            return json_encode(levHelpers::responseMsg(-1024, '数据表不能为空'));
        }
        $idkey = levHelpers::stripTags(\Yii::$app->request->post('idkey'));
        $field = levHelpers::stripTags(\Yii::$app->request->post('field'));
        $val = levHelpers::stripTags(\Yii::$app->request->post('val'));

        $count = \Yii::$app->db->createCommand()->update($optab, [$field=>$val], [$idkey?:'id'=>$opid])->execute();
        return json_encode(levHelpers::responseMsg(1, '操作成功', ['count'=>$count]));
    }

    /**
     * @param $model
     * @return string
     * @throws \yii\base\Exception
     */
    public static function installModule($model) {

        $moduleUniqueId = \Yii::$app->controller->module->uniqueId;

        $moduleInfo = $model->getModuleInfo();
        \Yii::$app->view->title = '安装：'.$moduleInfo['name'];

        if ($moduleUniqueId != 'adminModules' && AdminModule::getModuleInfo($moduleUniqueId)) {
            return levHelpers::showMessage('模块已经存在！');
        }

        $dir = AdminModule::getInstallFileDir();
        FileHelper::createDirectory($dir);

        $installLockFile = $dir.AdminModule::getInstallLockFile($moduleUniqueId);

        if (is_file($installLockFile)) {
            return levHelpers::showMessage('已安装！');
        }

        if (!\Yii::$app->request->get('do')) {
            $tourl = Url::current(['do'=>1]);

            return levHelpers::showMessage('您确定要安装【'.$moduleInfo['name'].'】模块吗？', $tourl, 'submit');
        }

        $model->doInstallModule();

        self::setInstallInfo($moduleUniqueId, $installLockFile, $model);

        if (\Yii::$app->cache->get('baseModulesInstalling')) {
            return \Yii::$app->controller->redirect(Url::toRoute(['/install/default/base-modules']));
        }else {
            return levHelpers::showMessage('恭喜，安装完成！', \Yii::$app->homeUrl . $moduleUniqueId, 'success');
        }
    }

    /**
     * @param $model
     * @return string
     * @throws \yii\base\Exception
     */
    public static function reinstallModule($model) {

        $moduleUniqueId = \Yii::$app->controller->module->uniqueId;

        $moduleInfo = AdminModule::getModuleInfo($moduleUniqueId);
        $moduleInfo = $moduleInfo ? $moduleInfo : $model->getModuleInfo();
        \Yii::$app->view->title = '重装：'.$moduleInfo['name'];

        if (isset($moduleInfo['typeid']) && AdminModule::isBaseModule($moduleInfo['typeid'])) {
            return levHelpers::showMessage('抱歉，基础模块禁止重装！');
        }

        $dir = AdminModule::getInstallFileDir();
        FileHelper::createDirectory($dir);

        $installLockFile = $dir.AdminModule::getInstallLockFile($moduleUniqueId);

        if (!\Yii::$app->request->get('do')) {
            $tourl = Url::current(['do'=>1]);

            return levHelpers::showMessage('重装后数据、配置等将完全初始化！！！您确定要重装【'.$moduleInfo['name'].'】模块吗？', $tourl, 'submit');
        }

        $model->reInstallModule();

        self::setInstallInfo($moduleUniqueId, $installLockFile, $model);

        return levHelpers::showMessage('恭喜，重装完成！', \Yii::$app->homeUrl . $moduleUniqueId, 'success');
    }

    /**
     * @param $moduleUniqueId
     * @param $installLockFile
     * @param $model
     * @return bool
     */
    private static function setInstallInfo($moduleUniqueId, $installLockFile, $model) {

        $moduleInfo = $model->getModuleInfo();
        AdminModule::setModuleInfo($moduleInfo);

        $moduleInfo['addtime'] = date('Y-m-d H:i:s', time());
        file_put_contents($installLockFile, '版本详情：'.var_export($moduleInfo, true)."\n");

        if (defined(YII_ENV_DEV) && YII_ENV_DEV) {
            $moduleFile = \Yii::$app->controller->module->getBasePath() . '/' . AdminModule::getModuleClass() . '.php';
            if (is_file($moduleFile)) {
                $data = file_get_contents($moduleFile);
                if ($data && strpos($data, '//AdminModule::checkModuleInstall') === false) {
                    $data = str_replace('AdminModule::checkModuleInstall', '//AdminModule::checkModuleInstall', $data);
                    file_put_contents($moduleFile, $data);
                }
            }
        }
        return true;
    }

    public static function updateModule($model) {

        $moduleUniqueId = \Yii::$app->controller->module->uniqueId;
        $moduleInfo = AdminModule::getModuleInfo($moduleUniqueId);
        \Yii::$app->view->title = '更新：'.$moduleInfo['name'];

        $newm = $model->getModuleInfo();
        if ($moduleInfo['version'] == $newm['version']) {
            return levHelpers::showMessage('没有发现新版本！');
        }

        $dir = AdminModule::getInstallFileDir();
        FileHelper::createDirectory($dir);

        $installLockFile = $dir.AdminModule::getInstallLockFile($moduleUniqueId);

        if (!\Yii::$app->request->get('do')) {
            $tourl = Url::current(['do'=>1]);

            return levHelpers::showMessage($model->updateReadme().'发现新版本：'.$newm['version'].'，此次更新不可逆！！！您确定要更新【'.$moduleInfo['name'].'】模块吗？', $tourl, 'submit');
        }

        $model->doUpdateModule();

        AdminModule::setModuleInfo($newm);

        $newm['addtime'] = date('Y-m-d H:i:s', time());
        file_put_contents($installLockFile, file_get_contents($installLockFile)."\n".'版本详情：'.var_export($newm, true)."\n");

        return levHelpers::showMessage('恭喜，更新完成！', \Yii::$app->homeUrl . $moduleUniqueId, 'success');
    }

    /**
     * @param $model
     * @return string
     */
    public static function uninstallModule($model) {

        $moduleUniqueId = \Yii::$app->controller->module->uniqueId;

        $moduleInfo = AdminModule::getModuleInfo($moduleUniqueId);
        \Yii::$app->view->title = '卸载：'.$moduleInfo['name'];

        if (AdminModule::isBaseModule($moduleInfo['typeid'])) {
            return levHelpers::showMessage('抱歉，基础模块禁止卸载！');
        }

        if (!\Yii::$app->request->get('do')) {
            $tourl = \Yii::$app->homeUrl . $moduleUniqueId . '/admin-install/uninstall?do=1';

            return levHelpers::showMessage('卸载后数据、配置等将完全永久消失！！！您确定要卸载【'.$moduleInfo['name'].'】模块吗？', $tourl, 'submit');
        }

        $model->doUninstallModule();

        $moduleFile = \Yii::$app->controller->module->getBasePath().'/'.AdminModule::getModuleClass().'.php';
        if (is_file($moduleFile)) {
            $data = file_get_contents($moduleFile);
            if ($data) {
                $data = str_replace('//AdminModule::checkModuleInstall', 'AdminModule::checkModuleInstall', $data);
                file_put_contents($moduleFile, $data);
            }
        }

        $file = AdminModule::getInstallFileDir().AdminModule::getInstallLockFile($moduleUniqueId);
        if (is_file($file)) {
            FileHelper::unlink($file);
        }

        AdminModule::delModuleInfo($moduleUniqueId);

        return levHelpers::showMessage('成功，卸载完成！', \Yii::$app->homeUrl . $moduleUniqueId, 'success', \Yii::$app->homeUrl . 'adminModules');
    }










}