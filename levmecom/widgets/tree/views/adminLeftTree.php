<?php
/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-08-26 17:34
 *
 * 项目：levme  -  $  - adminLeftTree.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

use app\modules\navigation\Module;

?>

<?php if (!empty($top)) { foreach ($top as $v) : $_tops = []; ?>
    <?php if (isset($child[$v['id']]) && $child[$v['id']]) : ?>
        <li class="accordion-item">
    <?php else : ?>
        <li>
    <?php endif; ?>
        <div class="item-link item-content">
            <div class="item-media"><?=Module::icon($v['icon'])?></div>
            <div class="item-inner">
                <div class="item-text">
                    <a class="link" target="_iframe" href="<?=Module::link($v['link'])?>"><?=$v['name']?></a>
                </div>
                <?php if (isset($v['_position']) && $v['_position']) :?>
                <div class="item-after">
                    <?php foreach ($v['_position'] as $item) :
                        if (isset($child[$item['id']]) && $child[$item['id']]) {$_tops[$item['id']] = $child[$item['id']];}
                    ?>
                    <a class="link" target="_iframe" href="<?=Module::link($item['link'])?>"><?=$item['name']?></a>
                    <?php endforeach;?>
                </div>
                <?php endif;?>
            </div>
        </div>
    <?php if (isset($child[$v['id']]) && $child[$v['id']]) { $_tops[$v['id']] = $child[$v['id']]; }?>
    <?php if ($_tops) :?>
        <div class="accordion-item-content">
            <ul><?php foreach ($_tops as $key => $_top) : unset($child[$key]); ?>
                <?=\levmecom\widgets\tree\tree::widget(['top' => $_top, 'child' => $child, 'template'=>$template, 'ischild'=>true]);?>
            <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    </li>
<?php endforeach; } ?>
