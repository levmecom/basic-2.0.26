<?php

namespace app\modules\navigation\controllers;

use yii\web\Controller;

/**
 * Default controller for the `navigation` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect('admin/index');
        //return $this->render('index');
    }
}
