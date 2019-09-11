<?php

namespace app\controllers;

use levmecom\aalevme\levHelpers;
use app\models\ContactForm;
use app\modules\ucenter\models\UploadAvatarForm;
use yii\console\Exception;
use yii\web\UploadedFile;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{
    public $layout = 'main';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    public function actionInstall()
    {
        $model = new \app\modules\forum\models\ForumForums();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('install', [
            'model' => $model,
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //$curl = new Curl();
        //echo $curl->get('http://755607.com');
        //echo Yii::getAlias('@app');

        //var_dump(is_file(Yii::getAlias('@app').'/../composer.json'));exit();
        //Yii::$app->response->sendFile(Yii::getAlias('@app').'/../composer.json');
        //Yii::$app->response->headers->add('content-disposition', 'attachment; filename="a.jpg"');
        //$session = Yii::$app->session;
        //$session->open();
        //$session['user'] = 'username';
        //echo $session->remove('user');
        //$cookies = Yii::$app->response->cookies;
        //$cookies->add(new Cookie(['name'=>'user2', 'value' => 'username', 'expire' => time() + 10]));
        //$cookies = Yii::$app->request->cookies;
        //echo $cookies->remove('user');

        return levHelpers::render($this, 'index');
    }
    public function actionUpload()
    {
        $model = new UploadAvatarForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            try {
                if ($tips = $model->upload()) {
                    print_r($tips);
                    return;
                }
            } catch (Exception $e) {
            }
        }

        return $this->render('uploadform', ['model' => $model]);
    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {

        $this->getView()->blocks['PageName'] = 'login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        if (Yii::$app->request->post()) {
            //print_r(Yii::$app->request->post());exit;
        }
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            Yii::$app->session->setFlash('error', 'error');
            Yii::$app->session->setFlash('success', 'success');
            Yii::$app->session->setFlash('danger', 'danger');
            Yii::$app->session->setFlash('info', 'info');
            Yii::$app->session->setFlash('warning', 'warning');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
