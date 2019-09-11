<?php

namespace app\modules\uploads\controllers;

use Yii;
use app\modules\uploads\models\Uploads;
use app\modules\uploads\models\giiUploadsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\admin\behaviors\IsSuperAdmin;

/**
 * AdmingiiController implements the CRUD actions for Uploads model.
 */
class AdmingiiController extends Controller
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
     * Lists all Uploads models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->post('adminop')) {
            switch (Yii::$app->request->post('adminop')) {
                case 'setStatus' : $tips = IsSuperAdmin::setStatus(Uploads::tableName()); break;
                case 'setField'  : $tips = IsSuperAdmin::setField(Uploads::tableName()); break;
                case 'deleteDay' : $tips = IsSuperAdmin::adminDayDelete(Uploads::tableName()); break;
                case 'deleteIds' : $tips = IsSuperAdmin::adminDelete(Uploads::tableName()); break;
            }
            if (isset($tips)) {
                return $tips;
            }
        }

        $searchModel = new giiUploadsSearch();
        $query = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'query' => $query,
        ]);
    }

    /**
     * Displays a single Uploads model.
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
     * Creates a new Uploads model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Uploads();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Uploads model.
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
     * Deletes an existing Uploads model.
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
     * Finds the Uploads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Uploads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Uploads::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
