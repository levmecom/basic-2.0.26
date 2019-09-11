<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-08-13 14:46
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

?>

<style>
    .login-screen.als-screen iframe {width: 100%;height:calc(100% - 0px);border: 0;margin: 0;}
    .login-screen.als-screen .page-content {overflow:hidden;}
    .login-screen.als-screen.hide-navbar .navbar {display:none !important;}
    .login-screen.als-screen.hide-navbar .page-content {padding-top:0;}
    .login-screen.als-screen .fab.fab-right-top.login-screen-close {margin: 0;top: 0;right: 0;border-radius: 0;height: 38px;}
    .login-screen.als-screen .fab.fab-right-top.login-screen-close a {border-radius:0;font-size:22px;font-weight:normal;height:38px;}
    .login-screen.als-screen .fa {-webkit-text-stroke: 2px #ff2d55;color: white;font-size: 26px;margin-top:-0.5px;}
    .login-screen.als-screen .fab.fab-right-bottom.draggable_btn {bottom: 50px;transform: scale(0.95);min-width: 50px;}
    .login-screen.als-screen .fab.fab-right-bottom.draggable_btn a {z-index: 999999999;}
    .login-screen.als-screen .fab.fab-right-bottom.draggable_btn .fab-buttons {visibility: visible;pointer-events: auto;}
    .login-screen.als-screen .fab.fab-right-bottom.draggable_btn .fab-buttons a {opacity: 1;transform:scale(1);}
    .login-screen.als-screen .fa.fa-chevron-left {margin-top: 3px;margin-right: 3px;font-size: 22px;-webkit-text-stroke: 1px #ff2d55;}
</style>

<div class="login-screen als-screen a-to-login-screen">
    <div class="view">
        <div class="page">
            <div class="page-content login-screen-iframe-box"></div>

            <div class="fab fab-right-bottom color-pink draggable_btn">
                <a class="draggable_btnc login-screen-close">
                    <i class="fa fa-close login-screen-close" aria-hidden="true"></i>
                    <i class="fa fa-close login-screen-close" aria-hidden="true"></i>
                </a>
                <div class="fab-buttons fab-buttons-left openziframescreen draggable_btnc goback">
                    <a class="draggable_btnc goback"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function aToLoginScreen(obj, _href, force) {
        var force = force ? force : jQuery(obj).attr('force');
        if (F7app.device.desktop && !force) return false;

        var loginScreenOpenedName = '.a-to-login-screen';

        if (!_href) {
            var _href = obj.href ? obj.href : jQuery(obj).attr('href');

            if(window.top != window.self) {
                F7app.preloader.show();
                if (jQuery(obj).attr('target') == '_blank') {
                    window.open(obj.href ? obj.href : _href, '_blank').location;
                } else if (jQuery(obj).attr('target') == '_top') {
                    window.top.location = obj.href ? obj.href : _href;
                } else if (_href && !force) {
                    window.location = obj.href ? obj.href : _href;
                }
                if (force) {
                    F7app.preloader.hide();
                    parent.aToLoginScreen(obj, _href, force);
                }
                return true;
            }
        }

        var iframeBox = loginScreenOpenedName + ' .login-screen-iframe-box';

        F7app.preloader.show();
        F7app.loginScreen.close(undefined, false);

        if (!jQuery(iframeBox).html().trim()) {
            jQuery(iframeBox).html('<iframe name="screen-iframe" src="'+_href+'"></iframe>');
        }else {
            jQuery(iframeBox).find('iframe').attr('src', _href);
        }

        loadTime = window.setTimeout(function () {
            if (loadTime) {
                loadTime = clearTimeout(loadTime);
                F7app.loginScreen.open(loginScreenOpenedName);
            }
        }, 4000);

        jQuery(iframeBox + ' iframe').on('load', function (e) {
            if (loadTime) {
                loadTime = clearTimeout(loadTime);
                F7app.loginScreen.open(loginScreenOpenedName);
            }
        });

        Dom7(loginScreenOpenedName).on('loginscreen:opened', function () {
            F7app.preloader.hide();
        })

        Dom7(loginScreenOpenedName).on('loginscreen:closed', function () {
            //jQuery(iframeBox).html('');
            jQuery(iframeBox).find('iframe').removeAttr('src');
        });

        jQuery(".draggable_btnc").draggable({ cursor: "move", containment:'.draggable_btn',
            delay:111111111110, //此项设置目的在于禁止拖动，实现click事件
        });//拖动

        jQuery(document).on('click', '.goBackScreen', function () {//有问题
            if (typeof (parent.__location__history) != 'undefined' && parent.__location__history.length) {
                parent.aToLoginScreen(null, parent.__location__history.pop(), true);
            }
        });
        return true;
    }
</script>
