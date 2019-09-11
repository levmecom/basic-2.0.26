<?php

namespace app\modules\adminModules\models;

use Yii;

/**
 * This is the model class for table "{{%admin_modules}}".
 *
 * @property int $id
 * @property int $typeid
 * @property string $name
 * @property string $identifier
 * @property string $classdir
 * @property string $descs
 * @property string $copyright
 * @property string $version
 * @property string $settings
 * @property int $status
 * @property int $uptime
 * @property int $addtime
 */
class AdminModulesModel extends \yii\db\ActiveRecord
{
    CONST IS_BASE_MODULE = 9;
    CONST IS_LEVMECOM_MODULE = 8;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_modules}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['typeid', 'status', 'uptime', 'addtime'], 'integer'],
            [['settings'], 'required'],
            [['settings'], 'string'],
            [['name', 'identifier', 'copyright'], 'string', 'max' => 64],
            [['classdir', 'descs', 'version'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'typeid' => 'Typeid',
            'name' => 'Name',
            'identifier' => 'Identifier',
            'classdir' => 'Classdir',
            'descs' => 'Descs',
            'copyright' => 'Copyright',
            'version' => 'Version',
            'settings' => 'Settings',
            'status' => 'Status',
            'uptime' => 'Uptime',
            'addtime' => 'Addtime',
        ];
    }

    public static function isBaseModule($type) {
        if ($type == self::IS_BASE_MODULE) return true; return false;
    }
    public static function typearr() {
        return [
            self::IS_BASE_MODULE => ['id'=>self::IS_BASE_MODULE, 'name'=>'基础模块'],//系统必备模块
            self::IS_LEVMECOM_MODULE => ['id'=>self::IS_LEVMECOM_MODULE, 'name'=>'官方模块'],
            0 => ['id'=>0, 'name'=>'三方模块'],
        ];
    }

}
