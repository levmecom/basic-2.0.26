(function () {
    b = 'lev_uploadimg2';   //在config.js配置文件中写的注册自定义按钮名称
    CKEDITOR.plugins.add(b, {
        requires: ["dialog"],
        init: function (a) {
            a.addCommand(b, new CKEDITOR.dialogCommand(b));
            a.ui.addButton("lev_uploadimg2", {  //注意这里SimpleUpload是大写的，是在config.js中配置按钮名称
                label: "上传图片",  //鼠标放在按钮上时显示提示
                command: b,
                icon: this.path + "images.png"   //自定义上传按钮图片，放在在simpleupload文件夹下的images文件夹中

            });

            (function () {
                CKEDITOR.dialog.add("lev_uploadimg2",
                    function (a) {
                        console.log(a);
                        return {
                            title: "上传图片",
                            minWidth: 300,  //弹出框的最小宽度
                            minHeight: 80,   //弹出框的最小高度
                            contents: [{
                                id: "tab1",
                                label: "",
                                title: "",
                                expand: true,
                                padding: 0,
                                elements: [{
                                    type: "html",
                                    html: '123123'//initImageDlgInnerHtml(a.name) //对话框中要显示的内容，a.name:表示的是当前编辑器的id，initImageDlgInnerHtml方法是调用页面上的js方法（注意：a.name是为了解决同一个页面上使用多个编辑器）
                                }]
                            }],
                            onOk: function () {
                                //initUploadImage();  //点击确定按钮调用页面上的js方法
                            },
                            onLoad: function () {
                                //弹出框中默认的按钮为【确定】和【取消】，这里将【确定】按钮的文字为【上传】，鼠标悬停时显示也为上传
                                $('.cke_dialog_ui_button_ok > .cke_dialog_ui_button').text('上传');
                                $('.cke_dialog_ui_button_ok').attr('title', '上传');
                            }
                        }
                    })
            })();

        }
    })
})();
