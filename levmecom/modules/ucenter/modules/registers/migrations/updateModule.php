<?php

namespace app\modules\ucenter\modules\registers\migrations;

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
            'name' => '批量注册',
            'descs' => '批量注册用户，供程序内部调用或占坑',
            'copyright' => 'Levme.com',
            'version' => '20190827.1',
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
