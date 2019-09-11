<?php

namespace app\modules\navigation\migrations;

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

        $settings = unserialize($moduleInfo['settings']);
        if ($settings['dropTables']) {
            foreach ($settings['dropTables'] as $tab) {
                $this->dropTable(' IF EXISTS '.trim($tab));
            }
        }
        return true;
    }

}
