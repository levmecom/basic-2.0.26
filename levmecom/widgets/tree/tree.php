<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-24 14:01
 *
 * 项目：levme  -  $  - tree.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

namespace levmecom\widgets\tree;

use yii\base\Widget;

class tree extends Widget
{
    public $data = []; // 必须以id为key值

    public $top = [];

    public $child = [];

    public $ischild = false;

    public $template = 'tree';

    public $notop = [];

    public function run()
    {
        if ($this->data) {//print_r($this->data);
            $this->dataInit();//print_r($this->top);echo 'sdf';print_r($this->notop);exit;
        }

        $treehtm = $this->render($this->template, ['top'=>$this->top, 'child'=>$this->child, 'template'=>$this->template, 'ischild'=>$this->ischild]);

        if ($this->notop) {
            $treehtm.= $this->render($this->template, ['top'=>$this->notop, 'child'=>$this->child, 'template'=>$this->template, 'ischild'=>$this->ischild, 'notophead'=>true]);
        }

        return $treehtm;
    }

    /**
     * 无限树型分级 - 无死角显示所有数据
     * pid 对应上级的 id
     * pid=0 默认为顶级
     * pid不存在 或 pid=id 或 pid交错 => 自动提为顶级
     */
    public function dataInit() {
        $childIds = [];
        foreach ($this->data as $v) {
            $v['id'] = isset($v['id']) ? $v['id'] : (microtime(true) + mt_rand(10000, 99999)).'_';
            if (isset($v['pid']) && $v['pid'] && $v['pid'] != $v['id']) {
                if (!isset($this->data[$v['pid']]) || ($v['pid'] && isset($childIds[$v['pid'].'_'.$v['id']]))) {
                    $this->notop[$v['id']] = $v;
                }
                $this->child[$v['pid']][$v['id']] = $v;
            }else {
                $this->top[$v['id']] = $v;
            }
            $childIds[$v['id'].'_'.$v['pid']] = $v['id'];
        }
        unset($childIds);
        $this->data = [];
    }
}







