<?php

namespace app\modules\navigation\migrations;

use app\modules\navigation\models\Navigation;
use levmecom\aalevme\Exception;
use yii\db\Migration;

/**
 * 需手动补加表名
 * Class M190826024239Create_navigation
 */
class installModule extends Migration
{
    public $LevTableName = '{{%navigation}}';

    public function getModuleInfo() {
        return [
            'name' => '导航管理',
            'descs' => '可设置前台、后台等站内所有导航',
            'copyright' => 'Levme.com',
            'version' => '20190827',
            'settings' => serialize(['dropTables'=>[$this->LevTableName]]),
            'addtime'=> time(),
        ];
    }

    public function doInstallModule() {

        $this->compact = true;
        $this->safeDown();
        $this->safeUp();

        $this->insertData();
        $this->insertNavs();

    }
    public function reInstallModule() {

        throw new Exception('抱歉，基础模块不允许重装！');

        //$this->safeDown();
        //(new uninstallModule())->doUninstallModule();
        //$this->doInstallModule();

    }

    public function insertData()
    {
        //插入分类
        $this->batchInsert($this->LevTableName, ['id', 'displayorder', 'typeid', 'name', 'descs', 'addtime'], [
            [1,  0,  0, '默认分类', '', time()],
            [10, 1,  0, '后台管理左侧', '', time()],
            [11, 2,  0, '后台管理顶部', '', time()],
            [12, 3,  0, '前台主导航', '', time()],
            [13, 4,  0, '前台-顶部-左', '', time()],
            [14, 5,  0, '前台-顶部-右', '', time()],
            [15, 6,  0, '前台-侧滑-左', '', time()],
            [16, 7,  0, '前台-侧滑-右', '', time()],
            [17, 8,  0, '前台-页脚', '', time()],
            [18, 9,  0, '前台-底部浮动', '', time()],
            [19, 10, 0, '用户中心', '', time()],
            [20, 11, 0, '发现页面', '', time()],
        ]);

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
            $tableOptions = 'ENGINE=MyISAM';
        }

        $this->createTable(' IF NOT EXISTS '.$this->LevTableName, [
            'id' => $this->primaryKey()->unsigned(),
            'pid' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'typeid' => $this->smallInteger()->notNull()->defaultValue(1)->unsigned(),
            'moduleidentifier' => $this->string(220)->notNull()->defaultValue(''),
            'name' => $this->string(64)->notNull()->defaultValue(''),
            'icon' => $this->string(255)->notNull()->defaultValue(''),
            'link' => $this->string(255)->notNull()->defaultValue(''),
            'target' => $this->string(32)->notNull()->defaultValue(''),
            'descs' => $this->string(255)->notNull()->defaultValue(''),
            'position' => $this->tinyInteger()->notNull()->defaultValue(0)->unsigned(),
            'displayorder' => $this->smallInteger()->notNull()->defaultValue(0)->unsigned(),
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
