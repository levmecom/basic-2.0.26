<?php

namespace app\modules\uploads\migrations;

use app\modules\navigation\models\Navigation;
use yii\db\Migration;

/**
 * 需手动补加表名
 */
class installModule extends Migration
{
    public $LevTableName = '{{%uploads}}';

    public function getModuleInfo() {
        return [
            'name' => '图片、文件管理',
            'descs' => '用户上传图片、文件管理',
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
        (new uninstallModule())->doUninstallModule();
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
            'name'=>'上传附件管理',
           '_editName'=>'上传附件管理', //用于修改导航名称
           'link'=>'',
           'icon'=>'fa-folder',
           //'_position'=>['name'=>'分类', '_editName'=>'分类', 'link'=>'', 'icon'=>''], //一个
            '_child'=>[
                ['name'=>'附件管理', '_editName'=>'', 'link'=>'uploads/admingii', 'icon'=>'fa-file-zip-o',
                    //'_position'=>['name'=>'分类', '_editName'=>'', 'link'=>'', 'icon'=>'fa-user-plus'],
                    '_child'=>[]
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
            $tableOptions = 'CHARACTER SET '.\Yii::$app->db->charset.' ENGINE=MyISAM';
        }

        $this->createTable($this->LevTableName, [
            'id' => $this->primaryKey(),
            'uid' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'sourceid' => $this->integer()->notNull()->defaultValue(0)->unsigned(),
            'idtype' => $this->tinyInteger()->notNull()->defaultValue(0)->unsigned(),
            'filetype' => $this->tinyInteger(2)->notNull()->defaultValue(0)->unsigned(),
            'filename' => $this->string(255)->notNull()->defaultValue(''),
            'src' => $this->string(255)->notNull()->defaultValue(''),
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
