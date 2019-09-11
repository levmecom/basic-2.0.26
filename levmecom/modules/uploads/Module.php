<?php

namespace app\modules\uploads;

use app\modules\adminModules\Module as AdminModule;

/**
 * uploads module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\uploads\controllers';

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
