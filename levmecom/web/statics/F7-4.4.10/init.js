
jQuery('img').addClass('lazy');

var F7app = new Framework7({
	// App root element
	root: '#f7app',
	theme: 'aurora',//aurora(pc) md(android) auto ios
	// App Name
	name: 'Levme.com',
	// App id
	id: 'com.lemve.f7app',
	dialog: {
		buttonOk: '确定',
		buttonCancel: '取消'
	},
	clicks: {
		// External Links
		//externalLinks: 'a',
	},
	touch: {
		tapHold: true //enable tap hold events
	},
	view: {
		iosDynamicNavbar: false,
	}
});
var mainView = jQuery('.view-main').hasClass('view-main') ? F7app.views.create('.view-main') : null;

if (F7app.device.ie) {
	F7app.dialog.alert('', '抱歉，暂不支持IE内核浏览器！请换用chrome、firefox、edge等新一代主流浏览器');
}

var __location__history = [];
var loadTime = null;
Dom7(document).on('taphold', '.preloader-modal', function () {
	levtoast('已取消遮罩');
	F7app.preloader.hide();
	if (loadTime != null) clearTimeout(loadTime);
});

jQuery('.ptr-content').on('ptr:pullstart', function (e) {
	jQuery('.ptr-preloader').show();
})
jQuery('.ptr-content').on('ptr:refresh', function (e) {
	//F7app.preloader.show();
	jQuery('.ptr-preloader').show();
	window.location.reload();
	//F7app.ptr.done();
})

jQuery(document).on('click', '.accordionItemTr .tree-name', function () {
	if (jQuery(this).parents('.accordionItemTr').eq(0).hasClass('accordionItemTrOpen')) {
		jQuery(this).parents('.accordionItemTr').eq(0).removeClass('accordionItemTrOpen');
	}else {
		jQuery(this).parents('.accordionItemTr').eq(0).addClass('accordionItemTrOpen');
	}
})

//默认a标签可点击
jQuery(document).on('click', 'a, .openziframescreen', function () {
	return aclick(this);
})
function aclick(obj) {
	if (jQuery(obj).hasClass('exit')) return true;
	if (jQuery(obj).hasClass('goback')) {
		window.history.back();
		return false;
	}
	var _target = jQuery(obj).attr('target');
	if (_target && _target == '_iframe') return true;
	var _href = jQuery(obj).attr('href');
	if (!obj.href && !_href) return true;
	if (_href && (_href.indexOf('javascript:') >=0 || _href.indexOf('#') >=0)) return true;

	if (_href && typeof (siteUri) !='undefined' && _href.indexOf('http') ==0 && _href.indexOf(siteUri) !=0) {
		if (jQuery(obj).parents('.check-out-side-a').hasClass('check-out-side-a')) {
			aToLoginScreen(obj, '', true);
			return false;
		}
	}

	if ((jQuery(obj).hasClass('openziframescreen') || (_target && _target.indexOf('_screen') == 0)) && typeof (aToLoginScreen) == 'function') {
		var ck = aToLoginScreen(obj);
		if (ck) return false;
	}

	if (!jQuery(obj).hasClass('external') && F7app.routes.length > 0) {
		for (var _k in F7app.routes) {
			if (F7app.routes[_k].path == _href) return false;
		}
	}

	//F7app.preloader.show();
	if (_target == '_blank') {
		window.open(obj.href ? obj.href : _href, '_blank').location;
	} else if (_target == '_top') {
		if (window.top != window.self) {
			F7app.preloader.show();
		}
		window.top.location = obj.href ? obj.href : _href;
	} else {
		window.location = obj.href ? obj.href : _href;
	}
	return false;
}

function panelLeft() {
	F7app.panel.left.open();
}

function panelRight() {
	F7app.panel.right.open();
}

function levtoast(text, closeTimeout) {
	F7app.toast.create({
		text: text,
		position: 'center',
		closeTimeout: closeTimeout ? closeTimeout : 2000,
	}).open();
	jQuery(document).on('click', '.toast.toast-center.modal-in', function () {
		F7app.toast.close(this);
	});
}
function errortips(obj) {
	if (!obj) {
		levtoast('未知错误', 5000);
	} else if (obj.responseJSON && obj.responseJSON.message) {
		levtoast(obj.responseJSON.message, 15000);
	}else if (obj.error && obj.error.message) {
		levtoast(obj.error.message, 15000);
	}else if (obj.message) {
		levtoast(obj.message, 15000);
	}else {
		levtoast(obj.responseText ? obj.responseText : '未知错误', 5000);
	}
}

function showFormErrors(data) {
	jQuery('errors').hide();
	for (var key in data) {
		if (jQuery('[name="'+ key +'"], #'+ key).parent().find('errors').html()) {
			jQuery('[name="'+ key +'"], #'+ key).parent().find('errors').html(data[key]).show();
		}else {
			jQuery('[name="'+ key +'"], #'+ key).parent().append('<errors>'+ data[key] +'</errors>');
		}
	}
	jQuery(document).on('change', 'input,textarea', function () {
		jQuery(this).parent().find('errors').hide();
	});
}

function levtoMao(val) {
	var myY = jQuery("#"+val).offset().top;
	jQuery("html,body").stop().animate({ scrollTop:myY},800);
}    

function dlevrandom(max, num){
	var randarr = [];//从0－max随机取出不重复的数字；num取出个数
	var a = [];
	for(var i = 0; i <=max; i++){
	    a.push(i);
	}
	for (var j=0; j < num; j++) {
		var b = [];
		var _idx = -1;
		for (i=0; i <=max; i++) {
			if (!isNaN(a[i])) {
				_idx+= 1;
				b[_idx] = a[i];
			}
		}
		var _len = b.length;
		var _randnum = levrandom(1, _len) -1;
		randarr[j] = b[_randnum];
		a.splice(_randnum, 1);
		//a.sort();console.log('数组：', a);
	}
    return randarr;
}
function levrandom(min, max) {
    if (max == null) {
        max = min;
        min = 0;
    }
    return min + Math.floor(Math.random() * (max - min + 1));
}

jQuery(function () {
	jQuery('.max-show').each(function () {
		var ht = jQuery(this).height();
		var ht_content = jQuery(this).children().eq(0).height();
		if (ht_content > ht) {
			var perct = Math.ceil((ht_content - ht) / ht_content * 100);
			jQuery(this).append('<maxshow><i class="fa fa-hand-o-down" aria-hidden="true"></i><p>展开全文(剩余'+perct+'%)</p></maxshow>');
		}
	});
	jQuery(document).on('click', '.max-show, maxshow', function () {
		if (jQuery(this).hasClass('max-show')) {
			jQuery(this).find('maxshow').hide();
			jQuery(this).css('max-height', 'none');
		}else {
			jQuery(this).hide();
			jQuery(this).parent('.max-show').css('max-height', 'none');
		}
	});
});

jQuery(function () {
	jQuery(document).on('load', function () {
		F7app.preloader.hide();
	});
});






