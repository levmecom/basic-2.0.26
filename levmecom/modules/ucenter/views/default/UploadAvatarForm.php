<?php
    if (!\Yii::$app->user->isGuest):
?>
<style>
    .sheet-modal, .sheet-modal-inner .list, .sheet-modal-inner ul, .sheet-modal-inner .item-content, .sheet-modal-inner .item-inner {background:none;}
    .sheet-modal-inner ul::before, .sheet-modal-inner ul::after, .sheet-modal-inner ul .item-inner::after {height:0;}
    .sheet-modal-inner {max-width: 1200px;margin: auto;background: none;}
    .sheet-modal-inner .button {width: 80%;margin: auto;}
</style>
<div class="sheet-modal my-sheet" style="height: auto">
<div class="sheet-content"><div class="sheet-modal-inner">
    <form id="uploadAvatarForm">
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->csrfToken ?>">
        <input type="file" id="uploadAvatarInput" name="UploadAvatarForm[imageFile]" style="display:none !important;">
    <div class="list">
        <ul>
            <li>
                <div class="item-content">
                    <div class="item-inner">
                        <a class="button button-active uploadAvatarInput">上传头像</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="item-content">
                    <div class="item-inner">
                        <a class="button button-fill color-gray sheet-close" data-sheet=".my-sheet">取消</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    </form>
    </div>
</div>
</div>


<script>
    function UploadAvatarSheet() {
        F7app.sheet.open('.my-sheet');

        jQuery(document).on('click', '.uploadAvatarInput', function () {
            jQuery('#uploadAvatarInput').click();
        });

        jQuery(document).on('change', '#uploadAvatarInput', function () {
            F7app.preloader.show();
            jQuery('#uploadAvatarForm').ajaxSubmit({
                url: '<?= Yii::$app->homeUrl?>ucenter/ajax/upload-avatar',
                type:'post',
                dataType: 'json',
                success: function (data) {
                    F7app.preloader.hide();
                    if (parseInt(data.status) >0) {
                        levtoast(data.message);
                        window.setTimeout(function () {
                            window.location.reload();
                        }, 200);
                    }else if (data && data.message) {
                        levtoast(data.message, 15000);
                    }
                },
                error: function (data) {
                    F7app.preloader.hide();
                    errortips(data);
                }
            });
        });
    }
</script>
<?php else:?>
<script>
    function UploadAvatarSheet() {
        login();
    }
</script>
<?php endif;?>
