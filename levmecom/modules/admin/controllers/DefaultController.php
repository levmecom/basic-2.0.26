<?php

namespace app\modules\admin\controllers;

use app\modules\admin\behaviors\IsSuperAdmin;
use app\modules\admin\models\SettingsModel;
use levmecom\aalevme\levHelpers;
use yii\helpers\Url;
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
        if (\Yii::$app->request->post('dosubmit')) {
            return json_encode(SettingsModel::saveSettings());
        }
        return $this->render('settings');
    }

    public function actionUpdateRedis() {
        if (\Yii::$app->request->get('do')) {
            //\Yii::$app->cache->flush();
            SettingsModel::setCaches();
            return levHelpers::showMessage('更新成功', '', 'success');
        }
        return levHelpers::showMessage('重新将配置写入缓存，您确定要执行吗？', Url::current(['do'=>1]), 'submit');
    }
}
