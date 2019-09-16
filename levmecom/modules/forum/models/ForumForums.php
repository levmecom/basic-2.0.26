<?php

namespace app\modules\forum\models;

use Yii;

/**
 * This is the model class for table "{{%forum_forums}}".
 *
 * @property int $id
 * @property int $pid
 * @property string $code
 * @property int $rootid
 * @property int $threads
 * @property string $name
 * @property string $descs
 * @property int $displayorder
 * @property int $status
 * @property int $uptime
 * @property int $addtime
 */
class ForumForums extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%forum_forums}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'rootid', 'threads', 'displayorder', 'status', 'uptime', 'addtime'], 'integer'],
            [['name'], 'required'],
            [['code'], 'string', 'max' => 32],
            [['name', 'descs'], 'string', 'max' => 255],
        ];
    }

    public static function forums() {
        return static::find()->indexBy('id')->orderBy(['displayorder'=>SORT_ASC, 'id'=>SORT_ASC])->asArray()->all();
    }

    public static function getForumByCode($code) {
        return static::find()->where(['code'=>$code])->asArray()->one();
    }
    public static function getForumById($id) {
        return static::find()->where(['id'=>$id])->asArray()->one();
    }
    public static function getForumByName($name) {
        return static::find()->where(['like', 'name', $name])->asArray()->one();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'code' => 'Code',
            'rootid' => 'Rootid',
            'threads' => 'Threads',
            'name' => 'Name',
            'descs' => 'Descs',
            'displayorder' => 'Displayorder',
            'status' => 'Status',
            'uptime' => 'Uptime',
            'addtime' => 'Addtime',
        ];
    }
}
