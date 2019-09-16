<?php

namespace app\modules\ucenter\migrations;

use app\modules\navigation\models\Navigation;
use levmecom\aalevme\Exception;
use yii\db\Migration;

/**
 * 需手动补加表名
 * Class M190803103258Create_ucenter_users
 */
class installModule extends Migration
{
    public $LevTableName = '{{%ucenter_users}}';

    public function getModuleInfo() {
        return [
            'typeid' => 9,
            'name' => '用户中心',
            'descs' => '基础用户中心，其它模块可在此用户基础上扩展更多功能',
            'copyright' => 'Levme.com',
            'version' => '20190827.3',
            'settings' => serialize(['dropTables'=>[$this->LevTableName]]),
        ];
    }

    public function doInstallModule() {

        $this->compact = true;
        $this->safeUp();

        $this->insertData();
        $this->insertNavs();

    }
    public function reInstallModule() {

        throw new Exception('抱歉，基础模块不允许重装！');

        //$this->safeDown();
        //$this->compact = true;
        //(new uninstallModule())->safeDown();
        //$this->doInstallModule();

    }

    public function insertData()
    {
    }

    public function insertNavs()
    {
        Navigation::setModuleNavs([//前台主导航
        ]);
        Navigation::setModuleAdminNavs([//后台管理左侧 - 【提示】后台管理只能有一个一级导航无数个子导航
            'name'=>'用户中心', '_editName'=>'用户中心', 'link'=>'', 'icon'=>'fa-users', //一个
            '_child'=>[ //无数个
                ['name'=>'用户管理', 'link'=>'ucenter/admin', 'icon'=>'fa-vcard',
                    '_position'=>['name'=>'分类', 'link'=>'ucenter/admin/type', 'icon'=>''],
                    '_child'=>[]
                ]],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            /**
             * ENGINE=MyISAM
             * CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB
             */
            $tableOptions = 'CHARACTER SET '.\Yii::$app->db->charset.' ENGINE=InnoDB';
        }

        $this->createTable(' IF NOT EXISTS '.$this->LevTableName, [
            'id' => $this->primaryKey()->unsigned(),
            'username' => $this->string(32)->notNull()->unique(),
            'password_hash' => $this->string(255)->notNull()->defaultValue(''),
            'authKey' => $this->char(32)->notNull()->defaultValue(''),
            'email' => $this->string(32)->notNull()->unique()->defaultValue(''),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(0)->unsigned(),
            'addtime' => $this->integer(11)->notNull()->defaultValue(0)->unsigned()
        ], $tableOptions);

        //$this->createIndex('addtime', $this->LevTableName, ['addtime'], false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->LevTableName);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M190803103258Create_ucenter_users cannot be reverted.\n";

        return false;
    }
    */
}
