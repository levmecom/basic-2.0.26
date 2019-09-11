<?php

namespace app\modules\forum\migrations;

use yii\db\Migration;

/**
 * 需手动补加表名
 * Class M190808023103Create_threads
 */
class M190808023103Create_forum extends Migration
{
    public $LevTableName = '{{%forum_threads}}';
    public $posts = '{{%forum_posts}}';
    public $forums = '{{%forum_forums}}';
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

        $this->insert($this->forums, ['name'=>'默认版块','code'=>'default','addtime'=>time()]);
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

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M190808023103Create_threads cannot be reverted.\n";

        return false;
    }
    */
}
