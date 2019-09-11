<?php

namespace app\modules\navigation\migrations;

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
            'name' => '导航管理',
            'descs' => '可设置前台、后台等站内所有导航',
            'copyright' => 'Levme.com',
            'version' => '20190827.3',
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
