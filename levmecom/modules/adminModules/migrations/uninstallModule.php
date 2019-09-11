<?php

namespace app\modules\adminModules\migrations;

use app\modules\adminModules\models\AdminModulesModel;
use app\modules\adminModules\Module;
use levmecom\aalevme\Exception;
use yii\db\Migration;

/**
 *
 * 基础必备模块，随系统首次安装
 *
 */
class uninstallModule extends Migration
{

    /**
     * @throws Exception
     */
    public function doUninstallModule() {

        throw new Exception('抱歉，基础模块不允许卸载！');

        $this->compact = true;
        //$this->safeDown();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $moduleInfo = Module::getModuleInfo(\Yii::$app->controller->module->uniqueId);
        if ($moduleInfo['identifier'] == 'adminModules') {
            $ck = \Yii::$app->db->createCommand('SELECT id FROM '.AdminModulesModel::tableName()." WHERE identifier!='adminModules'")->queryOne();
            if ($ck) {
                throw new Exception('卸载失败，请先卸载其它所有模块！');
            }
        }
        $settings = unserialize($moduleInfo['settings']);
        if ($settings['dropTables']) {
            foreach ($settings['dropTables'] as $tab) {
                $this->dropTable(' IF EXISTS '.trim($tab));
            }
        }
        return true;
    }

}
