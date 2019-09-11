<?php


namespace app\modules\ucenter\controllers;

use levmecom\aalevme\levHelpers;
use Yii;
use yii\rest\Controller;
use yii\web\UploadedFile;

use app\modules\ucenter\models\LoginForm;
use app\modules\ucenter\models\SignupForm;
use app\modules\ucenter\models\UploadAvatarForm;
use app\modules\ucenter\widgets\Ucenter;

class AjaxController extends Controller
{

    public $enableCsrfValidation = true;
    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return levHelpers::responseMsg();
    }

    /**
     * @return array
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        $post = Yii::$app->request->post();
        if (!isset($post['username'])) {
            return levHelpers::responseMsg(-1021, '用户名不能为空', ['errors'=>['username'=>'用户名不能为空']]);
        }
        $username = str_replace(" ", '', levHelpers::stripTags($post['username']));
        if ($username != $post['username']) {
            return levHelpers::responseMsg(-1020, '用户名含有非法字符', ['errors'=>['username'=>'不能含有空格、<等特殊字符']]);
        }
        if ($model->load($post, '') && $model->signup()) {
            //Yii::$app->session->setFlash('success', '感谢您的加入，请主意查验证邮件！');
            $dologin = Ucenter::doLogin($post['username'], $post['password']);
            return levHelpers::responseMsg(1, '感谢您的加入', ['login'=>$dologin]);
        }

        return levHelpers::responseMsg(-101, '注册失败', ['errors'=>$model->errors]);
    }

    public function actionUploadAvatar()
    {
        if (Yii::$app->user->isGuest) {
            return levHelpers::responseMsg(-302, '抱歉，需要登陆后才可以上传头像');
        }
        $model = new UploadAvatarForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            return $model->upload();
        }

        return levHelpers::responseMsg(-301, '请上传头像');
    }
}