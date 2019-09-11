<?php

namespace app\modules\admin\migrations;

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
            'name' => '管理后台',
            'descs' => '后台管理，设置',
            'copyright' => 'Levme.com',
            'version' => '20190827',
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
