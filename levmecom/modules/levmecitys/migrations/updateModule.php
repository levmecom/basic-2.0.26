<?php

namespace app\modules\levmecitys\migrations;

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
            'name' => '城市地区',
            'descs' => '2018年统计用区划代码和城乡划分代码（截止时间：2018-10-31）',
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
