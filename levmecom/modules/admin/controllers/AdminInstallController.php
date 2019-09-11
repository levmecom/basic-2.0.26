<?php

namespace app\modules\admin\controllers;

use app\modules\admin\behaviors\IsSuperAdmin;
use app\modules\admin\migrations\installModule;
use app\modules\admin\migrations\uninstallModule;
use app\modules\admin\migrations\updateModule;
use yii\web\Controller;


class AdminInstallController extends Controller
{

    public function behaviors()
    {
        return [
            IsSuperAdmin::className(),
        ];
    }

    /**
     * @throws \yii\base\Exception
     */
    public function actionIndex()
    {
        $this->view->title = '安装';

        return IsSuperAdmin::installModule(new installModule());
    }

    /**
     * @throws \yii\base\Exception
     */
    public function actionReinstall()
    {

        $this->view->title = '重装';

        return IsSuperAdmin::reinstallModule(new installModule());
    }

    public function actionUpdate()
    {

        $this->view->title = '更新';

        return IsSuperAdmin::updateModule(new updateModule());
    }

    public function actionUninstall()
    {

        $this->view->title = '卸载';

        return IsSuperAdmin::uninstallModule(new uninstallModule());
    }
}