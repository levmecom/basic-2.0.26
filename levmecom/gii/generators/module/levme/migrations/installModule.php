<?php
/**
 * This is the template for generating a module class file.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */

$className = $generator->moduleClass;
$pos = strrpos($className, '\\');
$ns = ltrim(substr($className, 0, $pos), '\\');
$className = substr($className, $pos + 1);

echo "<?php\n";

?>

namespace <?= $ns ?>\migrations;

use app\modules\navigation\models\Navigation;
use yii\db\Migration;

/**
 * 需手动补加表名
 */
class installModule extends Migration
{
    public $LevTableName = '{{%}}';

    public function getModuleInfo() {
        return [
            'name' => '<?=$generator->moduleName?>',
            'descs' => '<?=$generator->moduleDescs?>',
            'copyright' => '<?=$generator->moduleCopyright?>',
            'version' => '<?=$generator->moduleVersion?>',
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
//            'name'=>'<?=$generator->moduleName?>',
//           '_editName'=>'<?=$generator->moduleName?>', //用于修改导航名称
//           'link'=>'admin/default/settings?identifier=<?=$generator->moduleID?>',
//           'icon'=>'fa-folder',
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

        $this->createTable($this->LevTableName, [
            'id' => $this->primaryKey()->unsigned(),
            'typeid' => $this->integer()->notNull()->defaultValue(0)->unsigned()->comment('分类'),
            'name' => $this->string(80)->notNull()->defaultValue('')->comment('名称'),
            'descs' => $this->string(255)->notNull()->defaultValue('')->comment('简短描述'),
            'cityname' => $this->string(80)->notNull()->defaultValue('')->comment('所在地区'),
            'ishot' => $this->tinyInteger(2)->notNull()->defaultValue(0)->unsigned()->comment('热门'),
            'settings' => $this->text()->notNull()->comment('通用设置'),
            'displayorder' => $this->smallInteger()->notNull()->defaultValue(0)->unsigned()->comment('排序'),
            'status' => $this->tinyInteger(2)->notNull()->defaultValue(0)->unsigned()->comment('状态'),
            'uptime' => $this->integer()->notNull()->defaultValue(0)->unsigned()->comment('更新时间'),
            'addtime' => $this->integer()->notNull()->defaultValue(0)->unsigned()->comment('创建时间'),
        ], $tableOptions);

        //$this->insert($this->LevTableName, ['name'=>'默认分类', 'addtime'=>time()]);

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
