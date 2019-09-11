<?php

namespace app\modules\adminModules\migrations;

use yii\db\Migration;

/**
 *
 * 基础必备模块，随系统首次安装
 *
 */
class updateModule extends Migration
{
    public $LevTableName = '{{%admin_modules}}';

    public function updateReadme() {
        return '本次更新内容：<ol>
            <li>功能更新；</li>
        </ol>';
    }

    public function getModuleInfo() {
        return [
            'id' => 1,
            'typeid' => 9,
            'name' => '模块管理',
            'descs' => '对模块进行安装、更新、卸载',
            'copyright' => 'Levme.com',
            'version' => '20190827.2',
            'addtime'=> time(),
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
    }

}
