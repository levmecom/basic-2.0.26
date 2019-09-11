<?php

use levmecom\modules\forum\widgets\threadList;

echo $this->render('../layout');

?>

<div class="list media-list thread-list check-out-side-a" style="padding:0;">
    <ul class="ajax-page-list"> <?= threadList::widget() ?> </ul>
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
            url: '<?=Yii::$app->homeUrl?>forum/default/list',
            data: {page:page, fid:'<?=intval(Yii::$app->request->get('fid'))?>', _:Math.random()},
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
                //ajax_loading = false;
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








