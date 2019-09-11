<?php
namespace app\modules\ucenter\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $repassword;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 12],
            //['username', 'match', 'pattern' => '/^[\u4E00-\u9FA5A-Za-z0-9]+$/', 'message' => '只能是汉字、数字、字母'],//有误
            ['username', 'unique', 'targetClass' => '\app\modules\ucenter\models\User', 'message' => '该用户已被注册'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 32],
            ['email', 'unique', 'targetClass' => '\app\modules\ucenter\models\User', 'message' => '该邮箱已被注册'],

            ['password', 'required'],
            ['password', 'compare', 'compareAttribute' => 'repassword', 'message' => '两次密码不一致'],
            ['password', 'string', 'min' => 6],
            ['repassword', 'required'],
            ['repassword', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'repassword' => '密码',
            'email' => 'Email',
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        if (!$this->validate()) {
            return false;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email    = $this->email;
        $user->status   = User::STATUS_ACTIVE;
        $user->addtime  = time();
        $user->setPassword($this->password);
        $user->generateAuthKey();
        //$user->generateEmailVerificationToken();
        //$this->sendEmail($user);
        $res = $user->save();//var_dump($user->errors);
        if ($res) {
            return true;
        }else {
            return false;
        }
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
