<?php

?>
<!-- 注册窗口开始 -->
<div class="login-screen my-signup-screen login_screen">
    <div class="view">
        <div class="page">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="left"><a class="item-link" onclick="login()"><i style="font-size: 20px;" class="fa fa-mail-reply" aria-hidden="true"></i></a></div>
                    <div class="title">注册用户</div>
                    <div class="right">
                        <a class="item-link login-screen-close"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="page-content  login-screen-content">

                <div class="list">
                    <form action="" class="signup-form" method="post">
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
                                        <div class="item-after"><i class="fa fa-lock" aria-hidden="true"></i></div>
                                        <div class="item-input">
                                            <input type="password" name="repassword" placeholder="请再次输入密码">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-content">
                                    <div class="item-inner">
                                        <div class="item-after"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                                        <div class="item-input">
                                            <input type="text" name="email" placeholder="请输入邮箱(Email)">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-content">
                                    <div class="item-inner buttonbox">
                                        <div class="item-input">
                                            <div class="row"><input type="button" onclick="return doSignup()" name="dosubmit" class="button button-active" value=" 注 册 "></div>
                                            <div class="row item-text">
                                                <a class="link" onclick="login()">返回登陆</a>
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

<script>
    function signup() {
        F7app.sheet.close(undefined, false);
        F7app.loginScreen.close(undefined, false);
        F7app.loginScreen.open('.login-screen.my-signup-screen');
    }

    function doSignup() {
        F7app.preloader.show();
        jQuery('form.signup-form').ajaxSubmit({
            url: '<?= Yii::$app->homeUrl?>ucenter/ajax/signup',
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
            }
        });
        return false;
    }
</script>


