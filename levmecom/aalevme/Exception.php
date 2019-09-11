<?php


namespace levmecom\aalevme;


class Exception extends \yii\console\Exception
{
    public function getName()
    {

        return '错误！';
    }
}