<?php

namespace app\modules\levmecitys\controllers;

use app\modules\admin\behaviors\IsSuperAdmin;
use app\modules\levmecitys\migrations\installModule;
use app\modules\levmecitys\migrations\uninstallModule;
use app\modules\levmecitys\migrations\updateModule;
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