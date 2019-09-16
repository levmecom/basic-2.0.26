<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\SettingsModel;
use app\modules\admin\models\SettingsSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\admin\behaviors\IsSuperAdmin;

/**
 * SettingsController implements the CRUD actions for SettingsModel model.
 */
class SettingsController extends Controller
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
     * Lists all SettingsModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->post('adminop')) {
            switch (Yii::$app->request->post('adminop')) {
                case 'setStatus' : $tips = IsSuperAdmin::setStatus(SettingsModel::tableName()); break;
                case 'setField'  : $tips = SettingsModel::setField(); break;
                case 'deleteDay' : $tips = IsSuperAdmin::adminDayDelete(SettingsModel::tableName()); SettingsModel::setCaches(); break;
                case 'deleteIds' : $tips = IsSuperAdmin::adminDelete(SettingsModel::tableName()); SettingsModel::setCaches(); break;
            }
            if (isset($tips)) {
                return $tips;
            }
        }elseif (Yii::$app->request->post('addvar')) {
            return json_encode(SettingsModel::addvar());
        }

        $searchModel = new SettingsSearch();
        $query = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'query' => $query,
        ]);
    }

    /**
     * Displays a single SettingsModel model.
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
     * Creates a new SettingsModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SettingsModel();

        if ($model->load(Yii::$app->request->post())) {
            $model->addtime = time();
            if ($model->save()) {
                return $this->redirect(Url::current(['index', 'add'=>'']));
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SettingsModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Url::current(['index', 'id'=>'']));
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SettingsModel model.
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
     * Finds the SettingsModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SettingsModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SettingsModel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
