<?php

namespace app\modules\ucenter\migrations;

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
            'typeid' => 9,
            'name' => '用户中心',
            'descs' => '基础用户中心，其它模块可在此用户基础上扩展更多功能',
            'copyright' => 'Levme.com',
            'version' => '20190827.8',
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
        (new installModule())->insertNavs();
    }

}









