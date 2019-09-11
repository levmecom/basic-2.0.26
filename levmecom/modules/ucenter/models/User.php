<?php

namespace app\modules\ucenter\models;

use levmecom\aalevme\levHelpers;
use Yii;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%ucenter_users}}".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property int $status
 * @property int $addtime
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED  = 2;//已删除 (禁止登陆)
    const STATUS_INACTIVE = 1;//未激活 (未验证邮箱)
    const STATUS_ACTIVE   = 0;//正常   (正常登陆 - 默认)

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ucenter_users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'email'], 'required'],
            [['status', 'addtime'], 'integer'],
            [['username', 'email'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password_hash' => '密码',
            'email' => 'Email',
            'status' => '状态',
            'addtime' => '添加时间',
        ];
    }

    public static function userByuids($data = [], $insql = '') {
        $insql = $insql ? $insql : levHelpers::inSql($data, 'uid');
        if ($insql) {
            $users = static::find()->where("id IN($insql)")->select(['id', 'username'])->indexBy('id')->asArray()->all();
        }
        $users[0] = ['id'=>0, 'username'=>'<游客>'];
        return $users;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $obj = static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
        return $obj;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findByVerificationToken($token);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'accessToken' => $token,
            'status' => self::STATUS_ACTIVE
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Generates "remember me" authentication key
     * @throws Exception
     */
    public function generateAuthKey()
    {
        $this->authKey = $this->getGenerateAuthKey(8);

        return $this->authKey;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getGenerateAuthKey($length = 32) {
        return Yii::$app->security->generateRandomString($length);
    }

    /**
     * @throws Exception
     */
    public function generateEmailVerificationToken()
    {
        $this->accessToken = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password_hash === $this->getPasswordHash($password);
        //return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        //$this->password_hash = Yii::$app->security->generatePasswordHash($password);//耗时2.3秒
        $this->password_hash = $this->getPasswordHash($password);

        return $this->password_hash;
    }

    public function getPasswordHash($password) {
        return md5(md5($password).md5(substr(md5($password), 4, -4)).substr($password, -4));
    }

}
