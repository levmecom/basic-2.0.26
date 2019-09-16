<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-08-14 18:36
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

use app\modules\forum\models\Threads;
use app\modules\ucenter\widgets\Ucenter;
if (!($pid = Yii::$app->request->get('id'))) {
    $where = intval(Yii::$app->request->get('fid')) ? ['fid'=>intval(Yii::$app->request->get('fid'))] : '';
    $counts = Threads::find()->where($where)->count();
}
?>


<?php $this->beginBlock('toolbar') ?>
<div class="toolbar toolbar-bottom sendthread-toolbar ts-info" pid="<?=$pid?>" user="<?=$user?>">
    <div class="toolbar-bottom-inner">
        <div class="list">
            <div class="item-content">
                <div class="item-text avatar-box">
                    <a href="<?=Yii::$app->homeUrl?>ucenter"><img class="avatar" src="<?=Ucenter::avatar()?>"></a></div>
                <div class="item-input" onclick="replyTA(this)">
                    <i class="fa fa-pencil"></i><?=$user?'怼楼主'.$user:'怼点什么呢'?>...
                </div>
                <div class="item-after"><a class="item-link">
                    <i class="fa fa-commenting" aria-hidden="true"></i>
                        <span><?=\Yii::$app->formatter->asShortSize($counts)?></span>
                    </a>
                </div>
                <div class="item-after">
                    <a onclick="showShareGrid()" class="item-link"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBlock() ?>
