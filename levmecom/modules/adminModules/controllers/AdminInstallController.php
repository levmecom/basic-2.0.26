<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-18 12:02
 *
 * 项目：levme  -  $  - AdminController.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */


namespace app\modules\adminModules\controllers;

use app\modules\admin\behaviors\IsSuperAdmin;
use app\modules\adminModules\migrations\installModule;
use app\modules\adminModules\migrations\uninstallModule;
use app\modules\adminModules\migrations\updateModule;
use yii\web\Controller;

class AdminInstallController extends Controller
{

    public function behaviors()
    {
        return [
            IsSuperAdmin::className(),
        ];
    }

    public function actionIndex()
    {

        $this->view->title = '安装';

        return IsSuperAdmin::installModule(new installModule());
    }

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

    public function actionUninstall() {
        $this->view->title = '卸载';

        return IsSuperAdmin::uninstallModule(new uninstallModule());
    }
}