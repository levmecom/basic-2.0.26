<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-08-24 14:09
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */


/* @var $this \yii\web\View */
?>

<?php if (!$ischild) : $inputname = isset($inputname) && $inputname ? $inputname : 'checkbox[]'?>
    <div class="treeview-item treeview-item-opened">
        <div class="treeview-item-root">
            <div class="treeview-item-content treeview-item-toggle">
                <label class="checkbox flex">
                    <input type="checkbox" onclick="checkedToggle(this,'input[name=\'<?=$inputname?>\']')" />
                    <i class="icon-checkbox"></i>
                    <div class="treeview-item-label"><font color="gray">全选</font></div>
                </label>
            </div>
        </div>
    </div>
<?php endif;?>

<?php if (!empty($top)) { foreach ($top as $v) :?>
<div class="treeview-item <?=!$ischild || $values ? 'treeview-item-opened' : ''?>">
    <div class="treeview-item-root treeview-item-selectable">
    <?php if (isset($child[$v['id']]) && $child[$v['id']]) : ?>
        <div class="treeview-toggle"></div>
    <?php endif; ?>
        <div class="treeview-item-content treeview-item-toggle">
            <label class="checkbox">
                <input type="checkbox" name="<?=isset($inputname) && $inputname ? $inputname : 'checkbox[]'?>"
                       value="<?=$v[$key]?>" <?=is_array($values) && in_array($v[$key], $values) ? 'checked' :''?>/>
                <i class="icon-checkbox"></i>
            </label>
            <div class="treeview-item-label"><?=$v['name']?></div>
        </div>
    </div>
    <?php if (isset($child[$v['id']]) && $_top = $child[$v['id']]) : unset($child[$v['id']]);?>
        <div class="treeview-item-children">
            <?=\levmecom\widgets\tree\tree::widget(['top' => $_top, 'child' => $child, 'template'=>$template, 'inputname'=>$inputname, 'values'=>$values, 'ischild'=>true, 'key'=>$key]);?>
        </div>
    <?php endif; ?>
</div>
<?php endforeach; } ?>
