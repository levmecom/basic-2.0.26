<?php

namespace app\modules\levmecitys\controllers;

use app\modules\admin\behaviors\EnterGateway;
use yii\web\Controller;

/**
 * Default controller for the `levmecitys` module
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

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
