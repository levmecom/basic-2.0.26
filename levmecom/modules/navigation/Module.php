<?php

namespace app\modules\navigation;

use app\modules\adminModules\Module as AdminModule;
/**
 * navigation module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\navigation\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        AdminModule::checkModuleInstalls($this->uniqueId);
    }

    public static function link($link) {
        $link = trim($link);
        if (substr($link, 0, 4) =='http') {
            return $link;
        }elseif ($link) {
            return \Yii::$app->homeUrl.$link;
        }else {
            return '#';
        }
    }

    public static function icon($icon) {
        $icon = trim($icon);
        if (substr($icon, 0, 3) =='fa-') {
            return '<i class="fa '.$icon.' icon-fa" aria-hidden="true"></i>';
        }elseif (substr($icon, 0, 4) =='http') {
            return '<img src="'.$icon.'" class=icon-img>';
        }elseif ($icon) {
            return '<img src="'.\Yii::$app->homeUrl.$icon.'" class=icon-img>';
        }else {
            return '';
        }
    }

}
