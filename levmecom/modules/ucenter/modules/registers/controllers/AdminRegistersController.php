<?php

namespace app\modules\ucenter\modules\registers\controllers;

use Yii;
use app\modules\ucenter\modules\registers\models\UcenterRegisters;
use app\modules\ucenter\modules\registers\models\UcenterRegistersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\admin\behaviors\IsSuperAdmin;

/**
 * AdminRegistersController implements the CRUD actions for UcenterRegisters model.
 */
class AdminRegistersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            IsSuperAdmin::className(),
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UcenterRegisters models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->post('adminop')) {
            switch (Yii::$app->request->post('adminop')) {
                case 'setStatus' : $tips = IsSuperAdmin::setStatus(UcenterRegisters::tableName()); break;
                case 'setField'  : $tips = IsSuperAdmin::setField(UcenterRegisters::tableName()); break;
                case 'deleteDay' : $tips = IsSuperAdmin::adminDayDelete(UcenterRegisters::tableName()); break;
                case 'deleteIds' : $tips = IsSuperAdmin::adminDelete(UcenterRegisters::tableName()); break;
            }
            if (isset($tips)) {
                return $tips;
            }
        }

        $searchModel = new UcenterRegistersSearch();
        $query = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'query' => $query,
        ]);
    }

    /**
     * Displays a single UcenterRegisters model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UcenterRegisters model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UcenterRegisters();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UcenterRegisters model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UcenterRegisters model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UcenterRegisters model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UcenterRegisters the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UcenterRegisters::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
