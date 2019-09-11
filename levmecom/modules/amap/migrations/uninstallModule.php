<?php

namespace app\modules\amap\migrations;

use app\modules\adminModules\Module;
use app\modules\navigation\models\Navigation;
use yii\db\Migration;

/**
 *
 *
 */
class uninstallModule extends Migration
{

    public function doUninstallModule() {

        Navigation::delModuleNavs();

        $this->compact = true;
        $this->safeDown();

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
                if ($tab && $tab !='{{%}}') {
                    $this->dropTable(' IF EXISTS '.trim($tab));
                }
            }
        }
        return true;
    }

}
