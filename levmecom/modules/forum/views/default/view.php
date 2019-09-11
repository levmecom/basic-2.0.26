<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-08-13 19:35
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

use app\modules\ucenter\widgets\Ucenter;

echo $this->render('../layout', ['counts'=>$thread['replies'], 'user'=>$thread['userinfo']['username']]);

?>

<?php $this->beginBlock('navbar') ?>
<div class="navbar navbar-fixed-top forum">
    <div class="navbar-inner">
        <div class="left">
            <a class="item-link icon-only goback back">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </a>
            <a class="item-link item-content external" target="_top" href="<?=Yii::$app->homeUrl?>">
                <i class="fa fa-home" aria-hidden="true"></i>
            </a>
        </div>
        <div class="center b-user">
            <?php if ($thread['rootid']) : ?>
                <b>评论</b>
            <?php else :?>
            <img class="avatar" src="<?=Ucenter::avatar($thread['uid'])?>" width="20" height="20">
            <b><?=$thread['userinfo']['username']?></b>
            <?php endif;?>
        </div>
        <div class="right">
            <a class="link panel-open" data-panel="right"><i class="fa fa-bars" aria-hidden="true"></i></a>
        </div>
    </div>
</div>
<?php $this->endBlock() ?>

<div class="list block title-box">
    <div class="item-inner">
        <div class="item-title">
            <h1><?=$thread['title']?:\levmecom\aalevme\levHelpers::cutString($thread['contents']['contents'], 22, '');?></h1>
        </div>
        <div class="item-title-row">
            <div class="item-media"><img src="<?=Ucenter::avatar($thread['uid'])?>" class="avatar"></div>
            <div class="item-media"><?=$thread['userinfo']['username']?></div>
            <div class="item-after date"><?=Yii::$app->formatter->asDatetime($thread['addtime'], 'short')?></div>
<!--           <div class="item-after"><a class="button button-active"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;关注</a></div>-->
        </div>
    </div>
</div>
<div class="max-show">
<div class="block ck-content toPhotoBrowserBox check-out-side-a targetEl_x_<?=$thread['id']?>">
    <?=$thread['contents']['contents']?>
</div>
</div>
<div class="block-footer list ts-info" pid="<?=$thread['id']?>" user="<?=$thread['userinfo']['username']?>">
    <div class="item-inner">
        <div class="item-text bottox">
            <address class="<?=$thread['address']?'openziframescreen':''?>" force="1" href="<?=\yii\helpers\Url::toRoute(['/amap/default/show-point', 'address'=>$thread['address']])?>"><?=$thread['address']?:'神迷网友';?></address>
            <i class="fa fa-circle"></i>
            <?= Yii::$app->formatter->asRelativeTime($thread['addtime'], time()) ?>
            <i class="fa fa-circle"></i>
            <a class="reply-ta-<?=$thread['id']?>" onclick="replyTA(this)">怼TA</a>
        </div>
        <div class="item-after f-thumb-box first-d">
            <small><?=$thread['views']?></small>
            <i class="fa fa-street-view" aria-hidden="true"></i>
        </div>
        <div class="item-after f-thumb-box">
            <a class="prt10 suport-btn" onclick="doSuports(this)">
                <small><?=$thread['suports']?></small><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
            </a>
            <a class="prt10 more-btn" onclick="myMoreBtnPopover(this)" pid="<?=$thread['id']?>">
                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>

<div class="block-footer"><b>全部怼</b> <small>(<?=$thread['replies']?>)</small></div>

<div class="list media-list thread-list" style="padding:0;">
    <ul class="ajax-page-list check-out-side-a"> <?= \levmecom\modules\forum\widgets\replyList::widget(['pid' => $thread['id']]) ?> </ul>
    <div class="item-content morebtnbox"><a class="button button-active color-gray" page="2" onclick="ajaxPageList(this)">
            <small>点此加载更多</small>
            <div class="preloader" style="display:none;"></div>
        </a></div>
</div>

<script>
    var ajax_loading = false;
    document.ready(function () {
        jQuery('.thread-list').parents('.page-content').addClass('infinite-scroll-content');
        F7app.infiniteScroll.create('.infinite-scroll-content');
        Dom7('.infinite-scroll-content').on('infinite', function () {
            if (!ajax_loading) ajaxPageList('.morebtnbox a');
        });
    })
    function ajaxPageList(obj) {
        ajax_loading = true;

        if (jQuery(obj).find('.preloader').is(':visible')) return ;
        if (jQuery(obj).find('small').attr('nodata')) return ;
        var page = parseInt(jQuery(obj).attr('page'));
        setAjaxStatus();
        jQuery.ajax({
            url: '<?=Yii::$app->homeUrl?>forum/view/<?=$thread['id']?>',
            data: {page:page, ajax:1, _:Math.random()},
            dataType: 'html',
            type: 'get',
            success: function (data) {
                ajax_loading = false;

                setAjaxStatus(true);
                if (data && data.indexOf('</li>') >0) {
                    jQuery(obj).attr('page', page+1);
                    jQuery(obj).parents('.list').find('.ajax-page-list').append(data);
                }else {
                    jQuery(obj).find('small').html('没有了').show().attr('nodata', 1);
                }
            },
            error: function (data) {
                setAjaxStatus(true);
                jQuery(obj).find('small').html('加载失败了，点此重试');
                errortips(data);
            }
        });
        function setAjaxStatus(status) {
            if (status) {
                jQuery(obj).find('small').show();
                jQuery(obj).find('.preloader').hide();
            }else {
                jQuery(obj).find('small').hide();
                jQuery(obj).find('.preloader').show();
            }
        }
    }
</script>


