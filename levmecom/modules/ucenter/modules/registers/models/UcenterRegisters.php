<?php

namespace app\modules\ucenter\modules\registers\models;

use app\modules\ucenter\models\User;
use levmecom\aalevme\levHelpers;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%ucenter_registers}}".
 *
 * @property int $id
 * @property int $typeid
 * @property string $name
 * @property string $username
 * @property int $uid
 * @property string $password
 * @property int $status
 * @property int $addtime
 */
class UcenterRegisters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ucenter_registers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['typeid', 'uid', 'status', 'addtime'], 'integer'],
            [['name', 'username', 'password'], 'string', 'max' => 255],
        ];
    }

    public static function getType() {
        $types = static::find()->where(['uid'=>0])->select(['id', 'name'])->indexBy('id')->asArray()->all();
        //$types[0] = ['id'=>0, 'name'=>'未分类'];
        return $types;
    }

    public function registers() {
        $count = $rcount = 0;
        if ($this->load(Yii::$app->request->post(), 'dget') && $this->validate()) {
            $this->addtime = time();
            $this->name = levHelpers::stripTags($this->name);
            if ($this->name) {
                $checkName = $this->find()->where(['name'=>$this->name])->asArray()->one();
                if (empty($checkName)) {
                    $this->save();
                    $this->typeid = $this->id;
                }else{
                    $this->typeid = $checkName['id'];
                }
            }
            $types = $this->find()->where(['id'=>$this->typeid])->asArray()->one();
            $user = new User();
            $password_hash = md5($this->password ?: 'a123123');
            $usernames = explode("\n", Yii::$app->request->post('usernames'));
            $insql = levHelpers::inSql($usernames, '', '', [], true);
            if (!$insql) {
                return levHelpers::responseMsg(-10001, '请输入用户名');
            }
            $usered = $user->find()->where(" username IN($insql)")->indexBy('username')->select(['username'])->asArray()->all();
            $rows = [];
            foreach ($usernames as $k => $username) {
                $this->username = levHelpers::stripTags($username);
                if ($this->username && !isset($usered[$this->username])) {
                    $email = (substr(time(), -mt_rand(8, 10)) + $k).'@qq.com';
                    $rows[] = [$this->username, $password_hash, $user->getGenerateAuthKey(4), $email, $this->typeid];
                }
            }
            if ($rows) {
                $count = Yii::$app->db->createCommand()->batchInsert($user::tableName(), ['username', 'password_hash', 'authKey', 'email', 'addtime'], $rows)->execute();
                if ($count) {
                    $newuser = $user->find()->where(['addtime' => $this->typeid])->select(['id', 'username'])->asArray()->all();
                    $user->updateAll(['addtime' => time()], ['addtime' => $this->typeid]);
                    $rrows = [];
                    foreach ($newuser as $v) {
                        $rrows[] = [$this->typeid, $v['username'], $v['id'], time()];
                    }
                    if ($rrows) {
                        $rcount = Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['typeid', 'username', 'uid', 'addtime'], $rrows)->execute();
                    }
                }
            }
        }
        return levHelpers::responseMsg(1, '【'.$types['name'].'】成功注册：'.$count.'/'.$rcount);
    }

    public static function getUsersByTypeName($typeName) {
        $typeinfo = static::find()->where(['=', 'uid', 0])->andWhere(['like', 'name', $typeName])->select(['id'])->asArray()->one();
        if (isset($typeinfo['id'])) {
            return self::getUsersByTypeid($typeinfo['id']);
        }
        return [];
    }
    public static function getUsersByTypeid($typeid) {
        return static::find()->where(['typeid'=>$typeid])->select(['uid'])->asArray()->all();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'typeid' => '分类ID',
            'name' => '分类名称',
            'username' => '用户名',
            'uid' => 'UID',
            'password' => '密码',
            'status' => '状态',
            'addtime' => '添加时间',
        ];
    }
}
