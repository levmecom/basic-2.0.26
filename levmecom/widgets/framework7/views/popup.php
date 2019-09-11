<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-08-13 08:13
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

?>

<style>
    .popup.a-to-popup iframe {width: 100%;height:calc(100% - 0px);border: 0;margin: 0;}
    .popup.a-to-popup .page-content {overflow:hidden;}
</style>

<div class="popup popup-tablet-fullscreen a-to-popup">
    <div class="view">
        <div class="page">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="title">Popup</div>
                    <div class="right">
                        <!-- Link to close popup -->
                        <a class="link popup-close">Close</a>
                    </div>
                </div>
            </div>
            <div class="page-content popup-iframe-box">
<!--                <iframe name="_popup"></iframe>-->
            </div>
        </div>
    </div>
</div>

<script>
    function aToPopup(obj) {
        F7app.popup.close(undefined, false);
        F7app.loginScreen.close(undefined, false);

        if (jQuery(obj).attr('nofull')) {
            jQuery('.popup.a-to-popup').removeClass('popup-tablet-fullscreen');
        }else {
            jQuery('.popup.a-to-popup').addClass('popup-tablet-fullscreen');
        }

        var _href = obj.href ? obj.href : jQuery(obj).attr('href');

        var base64uri = 'c' + window.btoa(encodeURI(_href)).replace(/=/g, '').replace(/\//g, '-').replace(/\\/g, '-');
        //console.log(base64uri, this.href);return;
        jQuery('.popup.a-to-popup .popup-iframe-box iframe').hide();
        if (jQuery('.popup.a-to-popup .popup-iframe-box .'+base64uri).hasClass(base64uri)) {
            jQuery('.popup.a-to-popup .popup-iframe-box .'+base64uri).show();
        }else {
            jQuery('.popup.a-to-popup .popup-iframe-box').append('<iframe class="'+ base64uri +'" src="' + _href + '"></iframe>');
        }
        F7app.popup.open('.popup.a-to-popup');

        jQuery('.popup.a-to-popup').on('popup:close', function () {
            //var iframe = jQuery('.popup.a-to-popup .popup-iframe-box .'+base64uri).contents();
            if (jQuery(obj).attr('target') =='_popup') {
                jQuery('.popup.a-to-popup .popup-iframe-box .'+base64uri).remove();
            }
        });
    }
</script>