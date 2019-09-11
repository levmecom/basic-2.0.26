<?php

namespace app\modules\levmecitys\migrations;

use app\modules\navigation\models\Navigation;
use yii\db\Migration;
use yii\helpers\StringHelper;

/**
 * 需手动补加表名
 */
class installModule extends Migration
{
    public $LevTableName = '{{%levmecitys}}';
    public $streetsTable = '{{%levmecitys_streets}}';

    public function getModuleInfo() {
        return [
            'name' => '城市地区',
            'descs' => '2018年统计用区划代码和城乡划分代码（截止时间：2018-10-31）',
            'copyright' => 'Levme.com',
            'version' => '20190827',
            'settings' => serialize(['dropTables'=>[$this->LevTableName, $this->streetsTable]]),
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
        //村数据太大自行移动table目录文件到数据库
        ini_set('memory_limit', '256M');
        $rows = include_once 'data/rows.php';
        foreach ($rows[0] as $field => $v) {
            $columns[] = $field;
        }
        $chunk = array_chunk($rows, 3000);//print_r($chunk);
        foreach ($chunk as $rows) {
            $this->batchInsert($this->LevTableName, $columns, $rows);
        }
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
            $tableOptions = 'ENGINE=MyISAM';
        }

        $this->createTable(' IF NOT EXISTS '.$this->LevTableName, [
            'id' => $this->primaryKey()->unsigned(),
            'pid' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'code' => $this->string(32)->notNull()->defaultValue(''),
            'name' => $this->string(80)->notNull()->defaultValue(''),
            'streetCode' => $this->string(32)->notNull()->defaultValue(''),
            'provinceCode' => $this->string(32)->notNull()->defaultValue(''),
            'cityCode' => $this->string(32)->notNull()->defaultValue(''),
            'areaCode' => $this->string(32)->notNull()->defaultValue(''),
            'displayorder' => $this->smallInteger()->notNull()->defaultValue(0)->unsigned(),
            'status' => $this->tinyInteger(2)->notNull()->defaultValue(0)->unsigned(),
            'uptime' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'addtime' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
        ], $tableOptions);

        $this->createIndex('code', $this->LevTableName, ['code'], false);
        $this->createIndex('provinceCode', $this->LevTableName, ['provinceCode'], false);
        $this->createIndex('cityCode', $this->LevTableName, ['cityCode'], false);
        $this->createIndex('areaCode', $this->LevTableName, ['areaCode'], false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(' IF EXISTS '.$this->LevTableName);
        $this->dropTable(' IF EXISTS '.$this->streetsTable);
    }

}