<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-18 22:08
 *
 * 项目：levme  -  $  - AdminController.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */


namespace app\modules\ucenter\modules\registers\controllers;

use app\modules\admin\behaviors\IsSuperAdmin;
use app\modules\ucenter\modules\registers\models\UcenterRegisters;
use Yii;
use yii\web\Controller;

class AdminController extends Controller
{

    public function behaviors()
    {
        return [
            IsSuperAdmin::className(),
        ];
    }

    public function actionIndex() {

        if (Yii::$app->request->post('adminop')) {
            switch (Yii::$app->request->post('adminop')) {
                case 'setStatus' : $tips = IsSuperAdmin::setStatus(UcenterRegisters::tableName()); break;
                case 'setField'  : $tips = IsSuperAdmin::setField(UcenterRegisters::tableName()); break;
                case 'deleteDay' : $tips = IsSuperAdmin::adminDayDelete(UcenterRegisters::tableName(), ' uid!=0 AND '); break;
                case 'deleteIds' : $tips = IsSuperAdmin::adminDelete(UcenterRegisters::tableName()); break;
            }
            if (isset($tips)) {
                return $tips;
            }
        }

        if (\Yii::$app->request->get('add')) {
            if (\Yii::$app->request->get('opid')) {
                if (\Yii::$app->request->post()) {
                    $opid = intval(\Yii::$app->request->get('opid'));
                    $model = UcenterRegisters::findOne(['id'=>$opid]);
                    if ($model->load(\Yii::$app->request->post(), 'dget') && $model->save()) {
                        \Yii::$app->session->setFlash('info', $opid <1 ? '添加成功！' : '修改成功！');
                    }else {
                        \Yii::$app->session->setFlash('info', '操作失败：'.json_encode($model->errors));
                    }
                    return $this->redirect(['index', 'srh'=>['id'=>$opid]]);
                }
                return $this->render('edit');
            }else {
                if (\Yii::$app->request->post()) {
                    $tips = (new UcenterRegisters())->registers();
                    \Yii::$app->session->setFlash('info', $tips['message']);
                    //return $this->redirect('index');
                }
                return $this->render('add');
            }
        }

        //return $this->redirect('../admin-registers/index');

        $where2 = IsSuperAdmin::adminSearchForm();
        $where = IsSuperAdmin::adminDateSearch();//print_r($lists);exit;

        $where.= $where2 ? ($where ? ' AND '.$where2 : $where2) : '';

        return $this->render('index', ['where'=>$where]);

    }

    public function actionType() {

        if (Yii::$app->request->post('adminop')) {
            switch (Yii::$app->request->post('adminop')) {
                case 'setStatus' : $tips = IsSuperAdmin::setStatus(UcenterRegisters::tableName()); break;
                case 'setField'  : $tips = IsSuperAdmin::setField(UcenterRegisters::tableName()); break;
                case 'deleteDay' : $tips = IsSuperAdmin::adminDayDelete(UcenterRegisters::tableName(), ' uid=0 AND '); break;
                case 'deleteIds' : $tips = IsSuperAdmin::adminDelete(UcenterRegisters::tableName()); break;
            }
            if (isset($tips)) {
                return $tips;
            }
        }

        if (\Yii::$app->request->get('add')) {
            if (\Yii::$app->request->post()) {
                $opid = intval(\Yii::$app->request->get('opid'));
                $model = $opid <1 ? new UcenterRegisters() : UcenterRegisters::findOne(['id'=>$opid]);
                if ($model->load(\Yii::$app->request->post(), 'dget') && $model->save()) {
                    \Yii::$app->session->setFlash('info', $opid <1 ? '添加成功！' : '修改成功！');
                }else {
                    \Yii::$app->session->setFlash('info', '操作失败：'.json_encode($model->errors));
                }
                return $this->redirect(['type', 'srh'=>['id'=>$model->id]]);
            }
            return $this->render('edit_type');
        }

        $where2 = IsSuperAdmin::adminSearchForm();
        $where = IsSuperAdmin::adminDateSearch();//print_r($lists);exit;

        $where.= $where2 ? ($where ? ' AND '.$where2 : $where2) : '';

        return $this->render('type', ['where'=>$where]);
    }

}