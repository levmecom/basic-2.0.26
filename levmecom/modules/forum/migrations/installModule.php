<?php

namespace app\modules\forum\migrations;

use app\modules\navigation\models\Navigation;
use yii\db\Migration;

/**
 * 需手动补加表名
 */
class installModule extends Migration
{
    public $LevTableName = '{{%forum_threads}}';
    public $posts = '{{%forum_posts}}';
    public $forums = '{{%forum_forums}}';

    public function getModuleInfo() {
        return [
            'name' => '论坛',
            'descs' => '它不仅仅是一个论坛',
            'copyright' => 'Levme.com',
            'version' => '20190827',
            'settings' => serialize(['dropTables'=>[$this->LevTableName, $this->posts, $this->forums]]),
        ];
    }

    public function doInstallModule() {

        $this->compact = true;
        $this->safeUp();

        $this->insertData();
        $this->insertNavs();

    }
    public function reInstallModule() {

        //$this->safeDown();
        $this->compact = true;
        (new uninstallModule())->doUninstallModule();
        $this->doInstallModule();

    }

    public function insertData()
    {
        $this->insert($this->forums, ['name'=>'默认版块','code'=>'default','addtime'=>time()]);
    }

    public function insertNavs()
    {
        Navigation::setModuleNavs([//前台主导航
        ]);
        Navigation::setModuleAdminNavs([//后台管理左侧 - 【提示】后台管理只能有一个一级导航无数个子导航
            'name'=>'论坛',
           '_editName'=>'论坛', //用于修改导航名称
           'link'=>'',
           'icon'=>'fa-globe',
         //  '_position'=>['name'=>'分类', '_editName'=>'分类', 'link'=>'', 'icon'=>''], //一个
            '_child'=>[
                [
                    'name'=>'版块管理',
                    '_editName'=>'版块管理', //用于修改导航名称
                    'link'=>'forum/admin/forums',
                    'icon'=>'fa-tags',
                    //'_position'=>['name'=>'分类', '_editName'=>'分类', 'link'=>'', 'icon'=>''], //一个
                ],
                [
                    'name'=>'帖子管理',
                    'link'=>'forum/admin/threads',
                    'icon'=>'fa-list',
                    //'_position'=>['name'=>'分类', '_editName'=>'分类', 'link'=>'', 'icon'=>''], //一个
                ],
                //['name'=>'分类22', ...],
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (!$this->LevTableName || $this->LevTableName == '{{%}}') return false;

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            /**
             * ENGINE=MyISAM
             * CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB
             */
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=MyISAM';
        }

        $this->createTable(' IF NOT EXISTS '.$this->forums, [
            'id' => $this->primaryKey()->unsigned(),
            'pid' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'code' => $this->string(32)->notNull()->defaultValue(''),
            'rootid' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'threads' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'name' => $this->string(255)->notNull(),
            'descs' => $this->string(255)->notNull()->defaultValue(''),
            'displayorder' => $this->smallInteger()->notNull()->defaultValue(0)->unsigned(),
            'status' => $this->tinyInteger(2)->notNull()->defaultValue(0)->unsigned(),
            'uptime' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'addtime' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
        ], $tableOptions);

        $this->createTable(' IF NOT EXISTS '.$this->LevTableName, [
            'id' => $this->primaryKey()->unsigned(),
            'pid' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'rootid' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'fid' => $this->smallInteger()->notNull()->defaultValue(0)->unsigned(),
            'uid' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'touid' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'textlen' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'title' => $this->string(255)->notNull()->defaultValue(''),
            'address' => $this->string(255)->notNull()->defaultValue(''),
            'topshow' => $this->smallInteger()->notNull()->defaultValue(0)->unsigned(),
            'attach' => $this->tinyInteger()->notNull()->defaultValue(0)->unsigned(),
            'suports' => $this->integer()->notNull()->defaultValue(0),
            'views' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'replies' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'status' => $this->tinyInteger(2)->notNull()->defaultValue(0)->unsigned(),
            'uptime' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'addtime' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
        ], $tableOptions);

        $this->createTable(' IF NOT EXISTS '.$this->posts, [
            'id' => $this->primaryKey()->unsigned(), // 对应threads表id
            'contents' => $this->text()->notNull(),
        ], $tableOptions);

        $this->createIndex('pid_topshow', $this->LevTableName, ['pid', 'topshow'], false);
        $this->createIndex('pid_fid_uid', $this->LevTableName, ['pid', 'fid', 'uid'], false);
        $this->createIndex('pid_uptime', $this->LevTableName, ['pid', 'uptime'], false);

    }

        /**
         * {@inheritdoc}
         */
        public function safeDown()
    {
        $this->dropIndex('pid_topshow', $this->LevTableName);
        $this->dropIndex('pid_fid_uid', $this->LevTableName);
        $this->dropIndex('pid_uptime', $this->LevTableName);
        $this->dropTable($this->forums);
        $this->dropTable($this->LevTableName);
        $this->dropTable($this->posts);
    }

}
