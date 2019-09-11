<?php


namespace app\modules\admin\behaviors;


use yii\base\Behavior;
use levmecom\aalevme\Exception;
use yii\web\Controller;

class UserAccess extends Behavior
{

    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }


    /**
     *
     * @throws Exception
     */
    public function beforeAction()
    {
        //权限控制
    }
}