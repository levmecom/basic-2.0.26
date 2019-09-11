<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-26 09:43
 *
 * 项目：levme  -  $  - adminController.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */


namespace app\modules\adminModules\controllers;

use app\modules\admin\behaviors\IsSuperAdmin;
use app\modules\adminModules\models\AdminModulesModel;
use app\modules\navigation\models\Navigation;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            IsSuperAdmin::className(),
        ];
    }


    public function optableName() {
        return AdminModulesModel::tableName();
    }

    public function actionIndex() {

        if (($tips = self::adminop()) !==true) return $tips;

        if (\Yii::$app->request->get('add')) {
            if (\Yii::$app->request->post()) {
                $opid = intval(\Yii::$app->request->get('opid'));
                $model = $opid <1 ? new AdminModulesModel() : AdminModulesModel::findOne(['id'=>$opid]);
                if ($model->load(\Yii::$app->request->post(), 'dget') && $model->save()) {
                    \Yii::$app->session->setFlash('info', $opid <1 ? '添加成功！' : '修改成功！');
                }else {
                    \Yii::$app->session->setFlash('info', '操作失败：'.Json::encode($model->errors));
                }
                return $this->redirect(['index', 'srh'=>['id'=>$model->id]]);
            }
            return $this->render('add');
        }

        $where2 = IsSuperAdmin::adminSearchForm();
        $where = IsSuperAdmin::adminDateSearch();//print_r($lists);exit;

        $where.= $where2 ? ($where ? ' AND '.$where2 : $where2) : '';

        return $this->render('index', ['where'=>$where]);

    }


    /**
     * @return false|string
     * @throws \yii\db\Exception
     */
    public function adminop($extWhere = '') {

        if (Yii::$app->request->post('adminop')) {
            switch (Yii::$app->request->post('adminop')) {
                case 'setStatus' : $tips = IsSuperAdmin::setStatus($this->optableName()); break;
                case 'setField'  : $tips = IsSuperAdmin::setField($this->optableName()); break;
                case 'deleteDay' : $tips = IsSuperAdmin::adminDayDelete($this->optableName(), $extWhere); break;
                case 'deleteIds' : $tips = IsSuperAdmin::adminDelete($this->optableName()); break;
            }
            if (isset($tips)) {
                return $tips;
            }
        }

        return true;
    }

}