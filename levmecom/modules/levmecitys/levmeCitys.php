<?php

namespace app\modules\levmecitys;

use app\modules\adminModules\Module as AdminModule;

/**
 * levmecitys module definition class
 */
class levmeCitys extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\levmecitys\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        //AdminModule::checkModuleInstalls($this->uniqueId);

        // custom initialization code goes here
    }
}
