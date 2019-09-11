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
    <?php if (isset($child[$v['id']]) && $child[$v['id']]) : ?>
        <li class="accordion-item">
    <?php else : ?>
        <li>
    <?php endif; ?>
    <div class="item-link item-content">
        <div class="item-media"><i class="fa fa-folder" aria-hidden="true"></i></div>
        <div class="item-inner">
            <div class="item-text">
                <a class="link"><?=$v['name']?></a>
            </div>
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
