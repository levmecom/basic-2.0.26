<?php

namespace app\modules\ucenter;

use app\modules\adminModules\Module as AdminModule;
/**
 * ucenter module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\ucenter\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {

        parent::init();

        AdminModule::checkModuleInstalls($this->uniqueId);

//        $this->modules = [
//            'admin' => [
//                // 此处应考虑使用一个更短的命名空间
//                'class' => 'app\modules\forum\modules\admin\Module',
//            ],
//        ];

        \Yii::configure($this, require __DIR__ . '/config.php');
    }
}
