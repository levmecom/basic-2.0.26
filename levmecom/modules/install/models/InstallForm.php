<?php

namespace app\modules\install\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for not table.
 *
 */
class InstallForm extends \yii\db\ActiveRecord
{
    //环境配置
    public $yiidebug, $yiienv;

    //数据库信息
    public $localhost, $dbname, $dbusername, $dbpassword, $dbtablepre, $systememail;

    //管理信息
    public $mgusername, $mgpassword, $remgpassword, $mgemail;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tableName}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['localhost', 'dbname', 'dbusername', 'dbpassword', 'mgusername', 'mgpassword', 'remgpassword'], 'required'],
            ['mgpassword', 'compare', 'compareAttribute' => 'remgpassword'],
            ['yiidebug', 'in', 'range' => [0, 1]],
            ['yiienv', 'in', 'range' => ['dev', 'prod']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'yiidebug' => Yii::t('install', '调试(Debug)：'),
            'yiienv' => Yii::t('install', '环境：'),

            'localhost' => Yii::t('install', '数据库服务器：'),
            'dbname' => Yii::t('install', '数据库名称：'),
            'dbusername' => Yii::t('install', '数据库用户名：'),
            'dbpassword' => Yii::t('install', '数据库密码：'),
            'dbtablepre' => Yii::t('install', '数据表前缀：'),
            'systememail' => Yii::t('install', '系统邮箱(Email)：'),

            'mgusername' => Yii::t('install', '管理员账号：'),
            'mgpassword' => Yii::t('install', '管理员密码：'),
            'remgpassword' => Yii::t('install', '重复密码：'),
            'mgemail' => Yii::t('install', '管理员邮箱(Email)：'),
        ];
    }

}







