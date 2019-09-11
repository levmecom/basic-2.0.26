<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-24 16:39
 *
 * 项目：levme  -  $  - trTree.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */
?>

<?php if (isset($notophead)) :?>
    <tbody class="headt"><tr><td colspan="1000">丢失上级分类</td></tr></tbody>
<?php endif;?>

<?php if (!empty($top)) { foreach ($top as $v) :?>
<tbody class="accordion-item">
    <tr>
        <td class="checkbox-cell">
            <label class="checkbox"><input name="ids[]" value="<?=$v['id']?>" type="checkbox"><i class="icon-checkbox"></i></label>
        </td>
        <td class="tab-center wd60"><input class="dorder setField" type="text" name="displayorder" opid="<?=$v['id']?>" value="<?=$v['displayorder']?>"></td>
        <td class="tab-center wd100"><?=$v['id']?></td>
        <td class="tab-center wd100"><?=$v['code']?></td>
        <td class="label-cell"><input class="setField" type="text" name="name" opid="<?=$v['id']?>" value="<?=$v['name']?>"></td>
        <td class="label-cell"><?=$v['threads']?></td>
        <td class="tab-center">
            <label class="toggle toggle-status color-green setStatus" opid="<?=$v['id']?>">
                <input type="checkbox" <?=$v['status']?'':'checked'?>>
                <span class="toggle-icon"></span>
            </label>
        </td>
        <td class="actions-cell">
            <a class="link" href="<?=\yii\helpers\Url::current(['add'=>1,'opid'=>$v['id']])?>"><absxb>编辑</absxb></a>
        </td>
    </tr>
    <?php if (isset($child[$v['id']]) && $_top = $child[$v['id']]) : unset($child[$v['id']]);?>
    <tr class="childtr accordion-item-content">
        <td colspan="1000" class="child-td">
            <table class="child-table">
                <?=\levmecom\widgets\tree\tree::widget(['top' => $_top, 'child' => $child, 'template'=>$template, 'ischild'=>true]);?>
            </table>
        </td>
    </tr>
    <?php endif; ?>
</tbody>
<?php endforeach; } ?>
