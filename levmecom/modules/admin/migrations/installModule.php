<?php

namespace app\modules\admin\migrations;

use app\modules\navigation\models\Navigation;
use yii\db\Migration;

/**
 * 需手动补加表名
 */
class installModule extends Migration
{
    public $LevTableName = '{{%settings}}';

    public function getModuleInfo() {
        return [
            'name' => '管理后台',
            'descs' => '后台管理，设置',
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

        //$this->safeDown();
        //$this->compact = true;
        //(new uninstallModule())->doUninstallModule();
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
//            'name'=>'批量注册',
//           '_editName'=>'批量注册', //用于修改导航名称
//           'link'=>'ucenter/registers/admin',
//           'icon'=>'fa-user-plus',
//           '_position'=>['name'=>'分类', '_editName'=>'分类', 'link'=>'ucenter/registers/admin/type', 'icon'=>''], //一个
//            '_child'=>[
//                ['name'=>'分类22', '_editName'=>'', 'link'=>'ucenter/registers/admin/type', 'icon'=>'fa-user-plus',
//                    '_position'=>['name'=>'分类2233', '_editName'=>'', 'link'=>'ucenter/registers/admin/type', 'icon'=>'fa-user-plus'],
//                    '_child'=>[]
//                ],
//                //['name'=>'分类22', ...],
//            ],
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
            $tableOptions = 'CHARACTER SET '.\Yii::$app->db->charset.' ENGINE=MyISAM';
        }

        $this->createTable($this->LevTableName, [
            'id' => $this->primaryKey()->unsigned(),
            'moduleidentifier' => $this->string(220)->notNull()->defaultValue('')->comment('模块标识符'),
            'title' => $this->string(255)->notNull()->defaultValue('')->comment('标题'),
            'placeholder' => $this->string(255)->notNull()->defaultValue('')->comment('提示语'),
            'inputname' => $this->string(255)->notNull()->defaultValue('')->comment('输入框名'),
            'inputtype' => $this->string(255)->notNull()->defaultValue('')->comment('输入框类型'),
            'inputvalue' => $this->text()->notNull()->comment('输入框值'),
            'settings' => $this->text()->notNull()->comment('通用设置'),
            'displayorder' => $this->smallInteger()->notNull()->defaultValue(0)->unsigned()->comment('排序'),
            'status' => $this->tinyInteger(2)->notNull()->defaultValue(0)->unsigned()->comment('状态'),
            'uptime' => $this->integer()->notNull()->defaultValue(0)->unsigned()->comment('更新时间'),
            'addtime' => $this->integer()->notNull()->defaultValue(0)->unsigned()->comment('添加时间'),
        ], $tableOptions);

        $this->createIndex('moduleidentifier', $this->LevTableName, ['moduleidentifier'], false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(' IF EXISTS '.$this->LevTableName);
    }

}
