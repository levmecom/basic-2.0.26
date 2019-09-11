<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-11 00:17
 *
 * 项目：levme  -  $  - sendThread.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */

use yii\helpers\Url;

?>

<?php if (!\Yii::$app->user->isGuest) : ?>
<style>
    .my-forum-send-thread-sheet {height:auto;}
    .my-forum-send-thread-sheet .forum-threads.list {margin: 0;}
    .my-forum-send-thread-sheet .forum-threads.list .item-input {width: 100%;}
    .my-forum-send-thread-sheet .forum-threads.list .ck.ck-content,
    .contents-box textarea,
    .contents-box {min-height: 150px;background: #f9f9f9;}
    .my-forum-send-thread-sheet .contents-box errors {right: 20px;bottom: 10px;}
</style>

<!-- 发帖窗口开始 -->
<div class="sheet-modal my-forum-send-thread-sheet">
    <div class="sheet-modal-inner">
        <div class="sheet-modal-swipe-step">
<div class="forum-threads list">
    <form id="threads-form">
        <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken ?>">
        <input type="hidden" name="fid" value="<?=intval(Yii::$app->request->get('fid'))?>">
        <ul>
            <li>
                <div class="item-content">
                    <div class="item-inner">
                        <div class="item-media"><i class="fa fa-text-height" aria-hidden="true"></i></div>
                        <div class="item-input">
                            <input type="text" id="forum_send_thread_title" name="title" placeholder="请输入标题(选填)">
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="item-content">
                    <div class="item-inner">
                        <div class="item-input contents-box">
                            <?php if (false && \Yii::$app->request->get('pid')) : ?>
                                <textarea name="contents" class="resizable" id="send_thread_contents" placeholder="请输入内容"></textarea>
                            <?php else : ?>
                            <?= \levmecom\widgets\ckeditor\CKEditor5::widget([
                                    'name' => 'contents',
                                    'options' => ['placeholder' => '请输入内容', 'id'=>'send_thread_contents'],
                                    //'editorType' => 'Inline',
                                    //'toolbar' => ['imageUpload'],
                                    'style' => (\levmecom\aalevme\levHelpers::ckmobile() ? 'mobile' : 'basic'),
                                    'uploadUrl' => Url::to('@web/forum/ajax/upload'),
                            ]) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <input type="hidden" id="forum_send_thread_address" name="address" placeholder="请输入地址(选填)">
                <div class="item-content">
                    <div class="item-inner">
                        <div class="item-media"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                        <div class="item-text" onclick="setAddress(this)" style="white-space:nowrap;">
                            <label><small><sas>标注地理位置</sas></small></label>
                        </div>
                        <div class="item-after small reply-who"></div>
                        <div class="item-after" style="margin-left: 2px;">
                            <label onclick="doSendThread()" class="button-active button">发送</label>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </form>
</div><!-- forum-threads -->
        </div>
    </div>
</div>

<div class="popup popup-set-address" style="z-index: 99999999999 !important;overflow: hidden;height: calc(100% - 40px);">
    <div class="page-content" style="overflow: hidden;width: 100%;">
        <iframe style="width:100%;height:calc(100% - 0px);border:0;margin:0;"></iframe>
    </div>
</div>

<script>
    var from_click_to_replyTA_obj = null;
    function replyTA(obj) {
        from_click_to_replyTA_obj = obj;
        F7app.sheet.close(undefined, false);
        F7app.sheet.open('.my-forum-send-thread-sheet');
        var user = jQuery(from_click_to_replyTA_obj).parents('.ts-info').attr('user');
        if (user) {
            jQuery('.reply-who').html('怼'+ user);
        }else {
            jQuery('.reply-who').html('');
        }

        if (!jQuery('.popup-set-address iframe').attr('src')) {
            jQuery('.popup-set-address iframe').attr('src', "<?=Url::toRoute(['/amap'])?>");
        }
        //jQuery('#send_thread_contents').focus();
    }

    function doSendThread() {
        F7app.preloader.show();
        //console.log(window.editor.getData());
        var contents = typeof (window.editor) != 'undefined' ? window.editor.getData() : (jQuery('#send_thread_contents').val() ? jQuery('#send_thread_contents').val() : jQuery('#send_thread_contents').html());
        var pid = jQuery(from_click_to_replyTA_obj).parents('.ts-info').attr('pid');
        jQuery('form#threads-form').ajaxSubmit({
            url: homeUrl + 'forum/ajax/send-thread',
            type:'post',
            data: {pid:pid,contents:contents},
            dataType: 'json',
            success: function(data){
                F7app.preloader.hide();
                if (parseInt(data.status) >0) {
                    F7app.sheet.close(undefined);
                    resetSendForm();
                    prepEndList(data.replyHtml);
                }else if (data && data.message) {
                    levtoast(data.message, 15000);
                }
                showFormErrors(data.errors);
                statusLogin(data);
            },
            error: function(data) {
                F7app.preloader.hide();
                console.log(data);
                errortips(data);
            }
        });
        return false;
    }
    function resetSendForm() {
        if (typeof window.editor != 'undefined') {
            window.editor.setData('');
        }
        jQuery('#forum_send_thread_title, #send_thread_contents').val('');
    }
    function prepEndList(replyHtml) {
        jQuery(from_click_to_replyTA_obj).parents('.ts-info').find('.replies-box ul').prepend(replyHtml);
        if (!jQuery(from_click_to_replyTA_obj).parents('.ts-info').find('.replies-box').html()) {
            window.setTimeout(function () {
                window.location.reload();
            }, 100);
        }
    }

    function setAddress(obj) {
        F7app.popover.open('.popup-set-address');
    }
</script>

<?php else : ?>
    <script>
        function replyTA(obj) {
            login()
        }
    </script>
<?php endif ?>





