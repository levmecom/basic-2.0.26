<?php

namespace app\modules\amap\migrations;

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
            'name' => '高德地图',
            'descs' => '高德地图API，获取地理位置和附近彩票站等',
            'copyright' => 'Levme.com',
            'version' => '20190908.1',
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
