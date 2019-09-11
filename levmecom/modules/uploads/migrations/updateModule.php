<?php

namespace app\modules\uploads\migrations;

use app\modules\navigation\models\Navigation;
use yii\db\Migration;

/**
 *
 * 基础必备模块，随系统首次安装
 *
 */
class updateModule extends Migration
{
    public function updateReadme() {
        return '本次更新内容：<ol>

            <li>功能更新；</li>
            
        </ol>';
    }

    public function getModuleInfo() {
        return [
            'name' => '图片、文件管理',
            'descs' => '用户上传图片、文件管理',
            'copyright' => 'Levme.com',
            'version' => '20190827.2',
        ];
    }

    public function doUpdateModule() {

        $this->compact = true;
        $this->safeUp();

        $this->updateData();
        $this->updateNavs();

    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    }

    public function updateData()
    {
    }

    public function updateNavs()
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

}
