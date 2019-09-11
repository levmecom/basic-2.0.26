<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-08-17 10:35
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */


/* @var $this \yii\web\View */

use levmecom\widgets\nativeShare\assets\appAssets;

$baseUrl = appAssets::register($this)->baseUrl;

?>

<style>
    .fa.fa-qq, .fa.fa-weixin, .fa.fa-weibo, .fa.fa-copy
    {font-size:18px;color:#fff;width:32px;height:32px;border-radius:50%;background:#297fd6;line-height:32px;text-align:center;}
    .fa.fa-weixin {background:#00bc0d;}
    .fa.fa-weibo {background:#fb5555;}
</style>
<i class="clipboard"></i><!--载入复制js-->

<script>
    function showShareGrid() {
        var ShareGrid = F7app.actions.create({
            targetEl: '.my-share-grid-actions',
            grid: true,
            convertToPopover: false,
            buttons: [
                [{
                    text: '微信好友',
                    icon: '<i class="fa fa-weixin" aria-hidden="true"></i>',
                    onClick: function () { doNativeShare('wechatFriend'); }
                },{
                    text: '朋友圈',
                    icon: '<img src="<?=$baseUrl?>/wxpengyouquan.png" width="32"/>',
                    onClick: function () { doNativeShare('wechatTimeline'); }
                },{
                    text: 'QQ好友',
                    icon: '<i class="fa fa-qq" aria-hidden="true"></i>',
                    onClick: function () { doNativeShare('qqFriend'); }
                },
                ],[
                    {
                        text: 'QQ空间',
                        icon: '<img src="<?=$baseUrl?>/qzone.png" width="32"/>',
                        onClick: function () { doNativeShare('qZone'); }
                    },{
                        text: '新浪微博',
                        icon: '<i class="fa fa-weibo" aria-hidden="true"></i>',
                        onClick: function () { doNativeShare('weibo'); }
                    },{
                        text: '复制',
                        icon: '<i class="fa fa-copy" aria-hidden="true"></i>',
                        onClick: function () { doNativeShare('copy'); }
                }]
            ]
        });
        ShareGrid.open();
    }

</script>

<script>
    function doNativeShare(command, title, desc, link, icon) {

        var command = command ? command : 'wechatFriend';

        var title = title ? title : jQuery('head title').html();
        var desc = desc ? desc : jQuery('meta[name="description"]').attr('content');
        var link = link ? link : window.location.href;
        var icon = icon ? icon : jQuery('link[rel="apple-touch-icon"]').attr('href');

        var nativeShare = new NativeShare();

        var shareData = {
            title: title,
            desc: desc,
            // 如果是微信该link的域名必须要在微信后台配置的安全域名之内的。
            link: link,
            icon: icon,
            // 不要过于依赖以下两个回调，很多浏览器是不支持的
            success: function() {
                console.log('success')
            },
            fail: function() {
                console.log('fail')
            }
        }
        nativeShare.setShareData(shareData)

        call(command);

        function call(command) {
            try {
                nativeShare.call(command)
            } catch (err) {
                // 如果不支持，你可以在这里做降级处理
                if (typeof(in__android__app) !='undefined') {
                    in__android__app.share(title+'：\\r\\n '+link);
                }else {
                    var tips = (command !="copy" ? '<i class="fa fa-info-circle"></i> 客户端不支持调用<br>' : '');
                    doCopy(title+' '+link, tips+'已为您复制分享内容和地址')
                }
            }
        }

        function setTitle(title) {
            nativeShare.setShareData({
                title: title,
            })
        }

        function doCopy(share_text, tips) {
            var clipboard = new ClipboardJS('.actions-grid', {
                text: function() {
                    return share_text;
                }
            });

            clipboard.on('success', function(e) {
                levtoast(tips);
            });

            clipboard.on('error', function(e) {
                levtoast('复制失败');
            });
        }
    }
</script>
