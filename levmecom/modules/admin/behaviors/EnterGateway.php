<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-09-08 14:24
 *
 * 项目：levme  -  $  - baseController.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */


namespace app\modules\admin\behaviors;

use levmecom\aalevme\Exception;
use yii\base\Behavior;
use yii\web\Controller;

class EnterGateway extends Behavior
{

    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    public static function beforeAction()
    {
        //throw new Exception('222222'); //执行前调用
    }

}