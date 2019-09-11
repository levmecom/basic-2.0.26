<?php

namespace app\modules\amap\controllers;

use yii\web\Controller;

use app\modules\admin\behaviors\EnterGateway;

/**
 * Default controller for the `amap` module
 */
class DefaultController extends Controller
{

    /**
    * {@inheritdoc}
    */
    public function behaviors()
    {
        return [
            EnterGateway::className(),
        ];
    }

    public function actionNearLotteryStation() {
        return $this->render('nearLotteryStatiion');
    }

    public function actionShowPoint() {
        return $this->render('showPoint');
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        //$this->layout = false;
        return $this->render('index');
    }
}
