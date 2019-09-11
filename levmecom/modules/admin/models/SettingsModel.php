<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "{{%settings}}".
 *
 * @property int $id
 * @property string $moduleidentifier
 * @property string $title
 * @property string $placeholder
 * @property string $inputname
 * @property string $inputtype
 * @property string $inputvalue
 * @property string $settings
 * @property int $displayorder
 * @property int $status
 * @property int $uptime
 * @property int $addtime
 */
class SettingsModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['settings'], 'required'],
            [['settings'], 'string'],
            [['displayorder', 'status', 'uptime', 'addtime'], 'integer'],
            [['moduleidentifier'], 'string', 'max' => 220],
            [['title', 'placeholder', 'inputname', 'inputtype', 'inputvalue'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'moduleidentifier' => '模块标识符',
            'title' => '字段标题',
            'placeholder' => '输入框提示',
            'inputname' => '输入框名称',
            'inputtype' => '输入框类型',
            'inputvalue' => '输入框值',
            'settings' => '设置',
            'displayorder' => '排序',
            'status' => '状态',
            'uptime' => '更新时间',
            'addtime' => '添加时间',
        ];
    }
}
