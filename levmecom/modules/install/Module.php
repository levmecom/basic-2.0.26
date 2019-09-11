<?php

namespace app\modules\install;

use app\modules\adminModules\Module as AdminModule;

/**
 * Install module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\install\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        //AdminModule::checkModuleInstall($this->uniqueId);//请不要改变本行代码

        //\Yii::configure($this, require __DIR__ . '/config.php');
        $this->ModuleConfig();

    }

    public function ModuleConfig()
    {
        $this->layout = 'install_layout';
        \Yii::$app->i18n->translations['install'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@modules/install/messages',
        ];
//        $this->modules = [
//            'admin' => [
//                'class' => 'app\modules\install\modules\admin\Module',
//            ],
//        ];
    }

}









