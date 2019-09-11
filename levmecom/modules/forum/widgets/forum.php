<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-18 17:31
 *
 * 项目：levme  -  $  - forum.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */


namespace levmecom\modules\forum\widgets;

use yii\base\Widget;

class forum extends Widget
{
    public static function getFloor($id, $tid, $replies = 0) {
        return $id - $tid;
    }
}