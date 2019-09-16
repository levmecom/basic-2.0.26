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

<?php if (!empty($top)) { foreach ($top as $v) :?>
<div class="treeview-item treeview-item-opened">
    <div class="treeview-item-root">
    <?php if (isset($child[$v['id']]) && $child[$v['id']]) : ?>
        <div class="treeview-toggle"></div>
    <?php endif; ?>
        <div class="treeview-item-content treeview-item-toggle">
            <label class="radio">
                <input type="radio" name="<?=isset($inputname) && $inputname ? $inputname : 'radio'?>" value="<?=$v[$key]?>" <?=$values==$v[$key]?'checked':''?>/>
                <i class="icon-radio"></i>
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
