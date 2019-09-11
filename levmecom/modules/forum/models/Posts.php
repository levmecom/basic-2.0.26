<?php

namespace app\modules\forum\models;

use Yii;

/**
 * This is the model class for table "{{%forum_posts}}".
 *
 * @property int $id
 * @property string $contents
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%forum_posts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['contents'], 'required'],
            [['contents'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contents' => '内容',
        ];
    }


}
