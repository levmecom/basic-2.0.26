<?php

namespace app\modules\amap;

use app\modules\adminModules\Module as AdminModule;

/**
 * amap module definition class
 */
class Amap extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\amap\controllers';

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
