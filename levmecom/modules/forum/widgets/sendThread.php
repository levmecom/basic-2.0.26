<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-11 00:14
 *
 * 项目：levme  -  $  - sendThread.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

namespace levmecom\modules\forum\widgets;

use yii\bootstrap\Widget;

class sendThread extends Widget
{

    public $bottom = false;//底部发帖条
    public $counts = 0;
    public $pid = 0;
    public $user = '';

    public function run()
    {
        parent::run(); // TODO: Change the autogenerated stub

        $toolbar = !$this->bottom ? '' : $this->render('bottomSendThrad', ['counts'=>$this->counts, 'user'=>$this->user]);
        return $this->render('sendThread').$toolbar;
    }

}