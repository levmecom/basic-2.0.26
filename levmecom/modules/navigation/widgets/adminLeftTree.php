<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-26 17:43
 *
 * 项目：levme  -  $  - adminLeftTree.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

namespace app\modules\navigation\widgets;

class adminLeftTree extends \yii\base\Widget
{
    public function run()
    {
        $navs = \app\modules\navigation\models\Navigation::navByTypeid(10);

        //$x = microtime(true);
         return \levmecom\widgets\tree\tree::widget(['data' => $navs, 'template' => 'adminLeftTree']);
         //return microtime(true) - $x;
    }
}