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

$className = $generator->moduleClass;
$pos = strrpos($className, '\\');
$ns = ltrim(substr($className, 0, $pos), '\\');
$className = substr($className, $pos + 1);

echo "<?php\n";
?>

namespace <?= $generator->getControllerNamespace() ?>;

use app\modules\admin\behaviors\IsSuperAdmin;
use <?= $ns ?>\migrations\installModule;
use <?= $ns ?>\migrations\uninstallModule;
use <?= $ns ?>\migrations\updateModule;
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