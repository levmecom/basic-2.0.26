<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-08-13 07:41
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

use levmecom\widgets\framework7\photoBrowser;
?>

<?= photoBrowser::widget(['imgClass' => '.toPhotoBrowserBox img']) ?>

<div class="popover my-morebtn-popover">
    <div class="popover-inner">
    <div class="list">
        <div class="item-content">
            <div class="item-inner">
                <a class="item-text link reply-ta">怼TA</a>
                <a class="item-text link copy-btn">分享</a>
                <a class="item-text link report-btn">举报</a>
                <a class="item-text link copy-btn clipboard">复制</a>
            </div>
        </div>
    </div>
    </div>
</div>

<script>
    function doSuports(obj) {

        //if (jQuery(obj).hasClass('suported')) return;

        if (isGuest) {
            login(); return false;
        }

        var pid = jQuery(obj).parents('.ts-info').attr('pid');

        F7app.preloader.show();
        jQuery.ajax({
            url: homeUrl + 'forum/ajax/suports',
            data: {pid:pid, _:Math.random(), '_csrf':_csrf},
            dataType: 'json',
            type: 'post',
            success: function (data) {
                F7app.preloader.hide();
                if (parseInt(data.status) =="-5") {
                    login(); return '';
                }else if (parseInt(data.succeed) >0) {
                    levtoast(data.message);
                }else if (data && data.message) {
                    //levtoast(data.message, 15000);
                }
                setStatus(obj, data);
            },
            error: function (data) {
                F7app.preloader.hide();
                errortips(data);
            }
        });

        function setStatus(obj, data) {
            if (data.num =="1") {
                jQuery(obj).addClass('suported');
                jQuery(obj).find('small').html(parseInt(jQuery(obj).find('small').text())+1);
            }else if (data.num =="-1") {
                jQuery(obj).removeClass('suported');
                jQuery(obj).find('small').html(parseInt(jQuery(obj).find('small').text())-1);
            }
        }
    }
</script>

<script>
    function myMoreBtnPopover(obj) {

        var opid = jQuery(obj).parents('.ts-info').attr('pid');

        jQuery('.targetEl_x_'+ opid).addClass('bg-gray');
        jQuery('.my-morebtn-popover').attr('pid', opid);

        F7app.popover.open('.my-morebtn-popover', '.targetEl_x_'+ opid);

        Dom7('.my-morebtn-popover').on('popover:close', function (e, popover) {
            jQuery('.targetEl_x_'+ opid).removeClass('bg-gray');
        });

        jQuery(document).on('click', '.my-morebtn-popover .reply-ta', function () {
            F7app.popover.close(undefined, false);
            jQuery('.ts-info .reply-ta-'+jQuery('.my-morebtn-popover').attr('pid')).click();
        });
        jQuery(document).on('click', '.my-morebtn-popover .report-btn', function () {
            levtoast('已举报');
        });

        var clipboard = new ClipboardJS('.my-morebtn-popover .copy-btn', {
            text: function() {
                return jQuery('.targetEl_x_'+ jQuery('.my-morebtn-popover').attr('pid')).text().trim();
            }
        });
        clipboard.on('success', function(e) {
            levtoast('复制成功，快快分享吧');
        });
        clipboard.on('error', function(e) {
            levtoast('复制失败');
        });
    }
</script>