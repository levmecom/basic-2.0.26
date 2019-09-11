
jQuery(document).on('click', '.checkAll', function () {
    jQuery('.data-table th input[name="ids[]"]').prop('indeterminate', false);
    if (jQuery('.data-table th input[name="ids[]"]').prop('checked')) {//th中的ids[]
        jQuery('.data-table input[name="ids[]"]').prop('checked', false);
    }else {
        jQuery('.data-table input[name="ids[]"]').prop('checked', true);
    }
});
jQuery(document).on('click', '.deleteCheckAll', function () {//删除选中数据
    var cklen = jQuery('.data-table td input[name="ids[]"]:checked').length;
    if (cklen >0) {
        F7app.dialog.confirm('您确定要删除已选中的 <absx> '+ cklen +' </absx> 条数据吗？', '', function () {
            F7app.preloader.show();
            jQuery('form[name="dataTableForm"]').ajaxSubmit({
                type: 'post',
                dataType: 'json',
                data: {adminop:'deleteIds', _:Math.random()},
                success: function (data) {
                    F7app.preloader.hide();
                    levtoast(data.message);
                    if (data && data.succeed == "1") {
                        window.setTimeout(function () {
                            window.location.reload();
                        }, 200)
                    }
                },
                error: function (data) {
                    F7app.preloader.hide();
                    errortips(data);
                }
            });
        });
    }else {
        levtoast('您至少选中一项');
    }
});

//搜索表单监听
jQuery(document).on('keyup', 'form[name=searchbarForm]', function (e) {
    if (e.which == 13) {
        jQuery('form[name=searchbarForm]').submit();
    }
});

//搜索表单监听
jQuery(document).on('change', 'form[name=dataTableForm] .srh', function (e) {
    jQuery('form[name=dataTableForm] input[name="ids[]"]').attr('disabled', true);
    jQuery('form[name=dataTableForm] input[type=hidden]').attr('disabled', true);
    jQuery('form[name=dataTableForm] .srh').each(function () {
        if (this.value == '') jQuery(this).attr('disabled', true);
    })
    jQuery('form[name=dataTableForm]').attr('method', 'get');
    jQuery('form[name=dataTableForm]').submit();
});

//状态字段修改
jQuery(document).on('change', '.toggle.setStatus', function (e) {
    var opid = jQuery(this).attr('opid');
    var status = jQuery(this).find('input[type=checkbox]:checked').val() ? 0 : 1;
    jQuery.ajax({
        type: 'post',
        dataType: 'json',
        data: {adminop:'setStatus', status:status, opid:opid, _csrf:_csrf, _:Math.random()},
        success: function (data) {
            F7app.preloader.hide();
            levtoast(data.message);
            if (data && data.succeed == "1") {
                window.setTimeout(function () {
                    //window.location.reload();
                }, 200)
            }
        },
        error: function (data) {
            F7app.preloader.hide();
            errortips(data);
        }
    });
});

//字段修改 - 通用
jQuery(document).on('change', '.setField', function (e) {
    var opid = jQuery(this).attr('opid');
    var field = jQuery(this).attr('name');
    var val = jQuery(this).val();
    jQuery.ajax({
        //url: homeUrl + 'admin/default/set-field',
        type: 'post',
        dataType: 'json',
        data: {adminop:'setField', field:field, val:val, opid:opid, _csrf:_csrf, _:Math.random()},
        success: function (data) {
            F7app.preloader.hide();
            levtoast(data.message);
            if (data && data.succeed == "1") {
                window.setTimeout(function () {
                    //window.location.reload();
                }, 200)
            }
        },
        error: function (data) {
            F7app.preloader.hide();
            errortips(data);
        }
    });
});

jQuery(document).on('click', '.doDeleteDay', function () {//删除几天前数据
    var day = parseFloat(jQuery('form[name="deleteDay"] input[name=day]').val());
    if (isNaN(day)) {
        levtoast('天数非法');
        return false;
    }
    F7app.dialog.confirm('您确定要删除 <absx> '+ day +'天 </absx> 前的数据吗？', '', function () {
        F7app.preloader.show();
        jQuery('form[name="deleteDay"]').ajaxSubmit({
            type: 'post',
            dataType: 'json',
            data: {adminop:'deleteDay', _:Math.random()},
            success: function (data) {
                F7app.preloader.hide();
                levtoast(data.message);
                if (data && data.succeed == "1") {
                    window.setTimeout(function () {
                        window.location.reload();
                    }, 200)
                }
            },
            error: function (data) {
                F7app.preloader.hide();
                errortips(data);
            }
        });
    });
});

jQuery(document).on('click', '.dateSearchDo', function () {//昨天、今天日期查询

    var sdate = jQuery('form[name=dateSearch] input[name=sdate]').val();
    var edate = jQuery('form[name=dateSearch] input[name=edate]').val();
    var field = jQuery('form[name=dateSearch] input[name=field]').val();
    jQuery('form[name=dateSearch] input').attr('disabled', true);
    jQuery('form[name=dateSearch]').append('<input type="hidden" name="srh[_daydate]" value="'+sdate+'.'+edate+'.'+field+'">').submit();
    return false;
});

jQuery(document).on('click', '.adminTopNavPopoverOpen', function () {//打开顶部popover
    if (jQuery('.my-admin-nav-popover li').html() == 'undefined' || !jQuery('.my-admin-nav-popover li').html()) {
        return false;
    }
    F7app.popover.close(undefined, false, false);
    F7app.popover.open('.my-admin-nav-popover', this);
});




jQuery('.panel-open').on('click', function(){
    var panel_left_open = false;
    jQuery('.panel-left').on('panel:open', function () {
        panel_left_open = true;
    });
    if (!panel_left_open) {
        F7app.panel.close('left');
    }
});

F7app.panel.open('left', false);

jQuery(document).on('click', '.my-admin-nav-popover a, a.panel-a, .toIframe', function () {
    if (jQuery('.panel a[href="' + jQuery(this).attr('href') + '"]').eq(0).html()) {
        jQuery('.panel a[href="'+jQuery(this).attr('href')+'"]').eq(0).click();
        return false;
    }else {
        return aToIframe(this);
    }
});
jQuery(document).on('click', '.refresh-this', function () {
    var src = jQuery('#iframe_x_box iframe:visible').attr('src');
    jQuery('#iframe_x_box iframe:visible').attr('src', src);
});

/*
* 必须在a标签中加入元素 target="_iframe"
* */
jQuery(document).on('click', '.panel a', function() { return aToIframe(this) });
function aToIframe(obj) {
    if (jQuery(obj).hasClass('exit')) return true;
    var _href = obj.href ? obj.href : jQuery(obj).attr('href');
    if (!_href) return true;
    if (_href && (_href.indexOf('javascript:') >=0 || _href.indexOf('#') >=0)) return true;
    if (jQuery(obj).attr('target') == '_blank' || jQuery(obj).hasClass('openziframescreen')) return false;
    jQuery('.panel a.oned').removeClass('oned');
    jQuery(obj).addClass('oned');
    F7app.loginScreen.close(undefined, false);
    var base64uri = 'c' + window.btoa(encodeURI(_href)).replace(/=/g, '').replace(/\//g, '-').replace(/\\/g, '-');
    jQuery('#iframe_x_box iframe').hide();
    if (jQuery('#iframe_x_box .'+base64uri).hasClass(base64uri)) {
        jQuery('#iframe_x_box .'+base64uri).show();
    }else {
        jQuery('#iframe_x_box').append('<iframe class="'+base64uri+'" src=' + _href + '></iframe>');
    }
    var lis = jQuery(obj).parents('.accordion-item').html();
    if (lis) {
        jQuery(obj).parents('.accordion-item').addClass('accordion-item-opened');
        lis = '<li class="accordion-item accordion-item-opened">'+ lis +'</li>';
    }else {
        lis = '<li>'+ jQuery(obj).parents('li').html() +'</li>';
    }
    //console.log(jQuery(obj).prop('outerHTML'));
    jQuery('.iframe-navbar .navnamebox').html(jQuery(obj).html());
    jQuery('.my-admin-nav-popover ul').html(lis);
    return false;
}