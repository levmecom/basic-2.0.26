<?php

?>
<?php if (Yii::$app->user->isGuest): ?>
<style>
    .login_screen .item-input {width: 100%;}
    .login_screen .list {max-width: 320px !important;min-width: 320px;}
    .login_screen .button.button-active {margin-top: 20px;}
    .login_screen .rememberme label {cursor: pointer;color: #777;font-size: 13px;}
    .login_screen .list form .item-after {width:22px;}
    .login_screen .list .item-inner.buttonbox {padding-right: 0;}
</style>

<!-- 登陆窗口开始 -->
<div class="login-screen my-login-screen login_screen">
    <div class="view">
        <div class="page">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="left"><a class="item-link login-screen-close"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a></div>
                    <div class="title">用户登陆</div>
                    <div class="right">
                        <a class="item-link login-screen-close"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>

            <div class="page-content  login-screen-content">

                <div class="list">
                    <form action="" class="login-form" method="post">
                        <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken ?>">
                        <ul>
                            <li>
                                <div class="item-content">
                                    <div class="item-inner">
                                        <div class="item-after"><i class="fa fa-user" aria-hidden="true"></i></div>
                                        <div class="item-input">
                                            <input type="text" name="username" placeholder="请输入用户名">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-content">
                                    <div class="item-inner">
                                        <div class="item-after"><i class="fa fa-lock" aria-hidden="true"></i></div>
                                        <div class="item-input">
                                            <input type="password" name="password" placeholder="请输入密码">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-content">
                                    <div class="item-inner">
                                        <div class="item-after"><i class="fa fa-user-secret" aria-hidden="true"></i></div>
                                        <div class="item-input rememberme">
                                            <label><input type="checkbox" name="rememberMe" value="1" checked>自动登陆</label>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-content">
                                    <div class="item-inner buttonbox">
                                        <div class="item-input">
                                            <div class="row"><input type="submit" onclick="return doLogin()" name="dosubmit" class="button button-active" value=" 登 陆 "></div>
                                            <div class="row item-text">
                                                <a class="link" onclick="signup()">立即注册</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>


<?= $this->render('SignupForm')?>

<script>
    function login() {
        F7app.sheet.close(undefined, false);
        F7app.loginScreen.close(undefined, false);
        F7app.loginScreen.open('.login-screen.my-login-screen');
    }
    function doLogin() {
        F7app.preloader.show();
        jQuery('form.login-form').ajaxSubmit({
            url: '<?= Yii::$app->homeUrl?>ucenter/default/login',
            type:'post',
            dataType: 'json',
            success: function(data){
                F7app.preloader.hide();
                if (parseInt(data.status) >0) {
                    levtoast(data.message);
                    window.setTimeout(function () {
                        window.location.reload();
                    }, 100);
                }else if (data && data.message) {
                    levtoast(data.message, 15000);
                }
                showFormErrors(data.errors);
            },
            error: function(data) {
                F7app.preloader.hide();
                errortips(data);
                //levtoast(data.responseText, 15000);
            }
        });
        return false;
    }
</script>

<?php endif; ?>

<script>
    function logout() {
        F7app.dialog.confirm('', '您确定要退出吗？', function () {
            F7app.preloader.show();
            jQuery.ajax({
                url:'<?=Yii::$app->homeUrl?>ucenter/ajax/logout',
                data:{<?=Yii::$app->request->csrfParam?>:'<?=Yii::$app->request->csrfToken?>',_:Math.random()},
                dataType:'json',
                type:'post',
                success:function(data){
                    F7app.preloader.hide();
                    if (parseInt(data.status) >0) {
                        levtoast(data.message);
                        window.setTimeout(function(){window.top.location.reload();}, 200);
                    }else if (data && data.message) {
                        levtoast(data.message, 15000);
                    }
                    showFormErrors(data.errors);
                },
                error:function(data){
                    F7app.preloader.hide();
                    errortips(data);
                }
            });
        });
    }
    function statusLogin(data) {
        if (typeof login == 'function' && data && data.status =="-5") {
            login();
        }
    }
</script>
