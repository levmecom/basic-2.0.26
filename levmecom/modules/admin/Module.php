<?php

namespace app\modules\admin;

use app\modules\adminModules\Module as AdminModule;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        AdminModule::checkModuleInstalls($this->uniqueId);

        // custom initialization code goes here
    }
}
