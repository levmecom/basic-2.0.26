<?php

namespace app\modules\ucenter\modules\registers;

use app\modules\adminModules\Module as AdminModule;

/**
 * registers module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\ucenter\modules\registers\controllers';

    /**
     * {@inheritdoc}
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        AdminModule::checkModuleInstalls($this->uniqueId);
    }
}
