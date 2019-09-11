<?php

namespace app\modules\admin\controllers;

use app\modules\admin\behaviors\IsSuperAdmin;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 * @method adminDelete()
 * @method adminDayDelete()
 */
class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            IsSuperAdmin::className(),
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSettings()
    {
        return $this->render('settings');
    }


}
