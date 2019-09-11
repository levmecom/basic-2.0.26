<?php

namespace app\modules\ucenter\modules\registers\migrations;

use app\modules\navigation\models\Navigation;
use yii\db\Migration;

/**
 * 需手动补加表名
 * Class M190818141323Create_ucenter_registers
 */
class installModule extends Migration
{
    public $LevTableName = '{{%ucenter_registers}}';

    public function getModuleInfo() {
        return [
            'name' => '批量注册',
            'descs' => '批量注册用户，供程序内部调用或占坑',
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
        $this->compact = true;
        (new uninstallModule())->safeDown();
        $this->doInstallModule();

    }

    public function insertData()
    {
    }

    public function insertNavs()
    {
        Navigation::setModuleNavs([//前台主导航
        ]);
        Navigation::setModuleAdminNavs([//后台管理左侧 - 【提示】后台管理只能有一个一级导航无数个子导航
            'name'=>'批量注册',
            '_editName'=>'批量注册', //用于修改导航名称
            'link'=>'ucenter/registers/admin',
            'icon'=>'fa-user-plus',
            '_position'=>['name'=>'分类', '_editName'=>'分类', 'link'=>'ucenter/registers/admin/type', 'icon'=>''], //一个
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
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            /**
             * ENGINE=MyISAM
             * CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB
             */
            $tableOptions = 'ENGINE=MyISAM';
        }

        //uid = 0 为分类，否则为用户
        $this->createTable(' IF NOT EXISTS '.$this->LevTableName, [
            'id' => $this->primaryKey()->unsigned(),
            'typeid' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'name' => $this->string(255)->notNull()->defaultValue(''),
            'username' => $this->string(255)->notNull()->defaultValue(''),
            'uid' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'password' => $this->string(255)->notNull()->defaultValue(''),
            'status' => $this->tinyInteger(2)->notNull()->defaultValue(0)->unsigned(),
            'addtime' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
        ], $tableOptions);

        $this->insert($this->LevTableName, ['name'=>'默认分类', 'addtime'=>time()]);

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
