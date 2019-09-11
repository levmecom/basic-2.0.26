<?php

namespace app\modules\adminModules\migrations;

use levmecom\aalevme\Exception;
use yii\db\Migration;

/**
 *
 * 基础必备模块，随系统首次安装
 *
 */
class installModule extends Migration
{
    public $LevTableName = '{{%admin_modules}}';

    public function getModuleInfo() {
        return [
            'id' => 1,
            'typeid' => 9,
            'name' => '模块管理',
            'descs' => '对模块进行安装、更新、卸载',
            'copyright' => 'Levme.com',
            'version' => '20190827',
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

        $this->compact = true;
        //$this->safeDown();
        //(new uninstallModule())->safeDown();
        //$this->doInstallModule();

    }

    public function insertData()
    {
    }

    public function insertNavs()
    {
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
            $tableOptions = 'ENGINE=InnoDB';
        }

        $this->createTable(' IF NOT EXISTS '.$this->LevTableName, [
            'id' => $this->primaryKey()->unsigned(),
            'typeid' => $this->smallInteger()->notNull()->defaultValue(0)->unsigned(),
            'name' => $this->string(64)->notNull()->defaultValue(''),
            'identifier' => $this->string(220)->notNull()->defaultValue(''),
            'classdir' => $this->string(255)->notNull()->defaultValue(''),
            'descs' => $this->string(255)->notNull()->defaultValue(''),
            'copyright' => $this->string(255)->notNull()->defaultValue(''),
            'version' => $this->string(255)->notNull()->defaultValue(''),
            'settings' => $this->text()->notNull(),
            'status' => $this->tinyInteger(2)->notNull()->defaultValue(0)->unsigned(),
            'uptime' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'addtime' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
        ], $tableOptions);

        //$this->createIndex('addtime', $this->LevTableName, ['addtime'], false);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(' IF EXISTS '.$this->LevTableName);
    }

}
