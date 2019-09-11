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
    <li><table class="headt"><tr><td colspan="1000">丢失上级分类</td></tr></table></li>
<?php endif;?>

<?php if (!empty($top)) { foreach ($top as $v) :?>
    <?php if (isset($child[$v['id']]) && $child[$v['id']]) : ?>
        <li class="accordion-item">
        <div class="item-link item-content accordion-item-box">
    <?php else: ?>
        <li>
        <div class="item-link item-content">
    <?php endif; ?>
        <div class="item-media"><i class="fa fa-folder" aria-hidden="true"></i></div>
        <div class="item-inner">
<table>
    <tr>
        <td class="label-cell tree-name"><li style="display: none;"><i class="tree-name"><?=$v['name']?></i></li>
            <input class="setField" type="text" name="name" opid="<?=$v['id']?>" value="<?=$v['name']?>"></td>
        <td class="checkbox-cell"><label class="checkbox"><input name="ids[]" value="<?=$v['id']?>" type="checkbox"><i class="icon-checkbox"></i></label>
        </td>
        <td class="tab-center wd60"><input class="dorder setField" type="text" name="displayorder" opid="<?=$v['id']?>" value="<?=$v['displayorder']?>"></td>
        <td class="tab-center wd100"><?=$v['id']?></td>
        <td class="tab-center wd100"><?=$v['code']?></td>
        <td class="numeric-cell wd100"><?=$v['threads']?></td>
        <td class="tab-center wd60">
            <label class="toggle toggle-status color-green setStatus" opid="<?=$v['id']?>">
                <input type="checkbox" <?=$v['status']?'':'checked'?>>
                <span class="toggle-icon"></span>
            </label>
        </td>
        <td class="actions-cell" style="width: 200px">
            <a class="link" href="<?=\yii\helpers\Url::current(['add'=>1,'pid'=>$v['id']])?>"><absx>添加子块</absx></a>
            <a class="link" href="<?=\yii\helpers\Url::current(['add'=>1,'opid'=>$v['id']])?>"><absxb>编辑</absxb></a>
        </td>
    </tr>
</table>
        </div>
    </div>
    <?php if (isset($child[$v['id']]) && $_top = $child[$v['id']]) : unset($child[$v['id']]);?>
    <div class="accordion-item-content">
        <ul>
            <?=\levmecom\widgets\tree\tree::widget(['top' => $_top, 'child' => $child, 'template'=>$template, 'ischild'=>true]);?>
        </ul>
    </div>
    <?php endif; ?>
    </li>
<?php endforeach; } ?>
