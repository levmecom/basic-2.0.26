(function () {
    var a = {
            exec: function (editor) {
                //调用jsp中的函数弹出上传框，
                levtoast('上传图片');
            }
        },
        b = 'uploadimg';
    CKEDITOR.plugins.add(b, {
        init: function (editor) {
            editor.addCommand(b, a);
            editor.ui.addButton('uploadimg', {
                label: '添加图片',  //鼠标悬停在插件上时显示的名字
                icon: 'plugins/uploadimg/image.png',   //自定义图标的路径
                command: b
            });
        }
    });
})();
