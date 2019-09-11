<?php

namespace app\modules\adminModules\controllers;

use app\modules\admin\behaviors\IsSuperAdmin;
use app\modules\adminModules\migrations\uninstallModule;
use yii\web\Controller;

/**
 * Default controller for the `adminModules` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     * @throws \levmecom\aalevme\Exception
     */
    public function actionIndex()
    {
        return $this->redirect('admin/index');
        //return $this->render('index');
    }
}
