<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="https://a.amap.com/jsapi_demos/static/demo-center/css/demo-center.css" />
    <link rel="stylesheet" type="text/css" href="https://a.amap.com/jsapi_demos/static/demo-center/css/prety-json.css">
    <style>
        html,
        body,
        #container {
            width: 100%;
            height: 100%;
        }
        body .view .page .page-content {width: 100% !important;max-width:100%;}
        .info.list label {font-size: 12px;}

        .amap-icon img.markerlnglat,
        .amap-marker-content img.markerlnglat {
            width: 25px;
            height: 34px;
        }
        .marker-content-x .marker {
            position: absolute;
            top: -20px;
            r-ight: 0;
            color: #666;
            padding: 4px 10px 4px;
            box-shadow: 1px 1px 1px rgba(10, 10, 10, .1);
            white-space: nowrap;
            font-size: 10px;
            font-family: "";
            background-color: #fff;
            border-radius: 3px;
        }

        #container {
            width: 100%;
            height: calc(100% - 240px);
        }
        .info {
            bottom: 0;
            top: unset;
            margin-bottom: 5px;
            height: 200px;
            overflow: hidden;left: 5px;right: 5px;
        }
        .list.media-list {
            height: 120px !important;
            width: 100% !important;max-width: 100% !important;
        }
    </style>
    <title>获取搜索信息</title>
</head>

<body>
<div id="container"></div>
<div class="info list">
    <div class="list  media-list" style="max-height:260px;max-width:320px;overflow: auto;">
        <ul id="streets-lists"></ul>
    </div>
    <ul>
    <li>
        <label class="item-radio item-content">
        <div class="item-media">
                <input type="radio" name="address-radio" class="default-address" checked><i class="icon icon-radio"></i>
        </div>
        <div class="item-inner">
        <div class="item-text"><xsas></xsas></div>
        <div class="item-after">
            <a class="button button-fill color-blue button-close-ppopup">确定</a>
        </div>
        </div>
        </label>
    </li>
    </ul>
</div>
<script src="https://webapi.amap.com/maps?v=1.4.15&key=5c76766ecddbec94c78696dabada35d9&plugin=AMap.CitySearch,AMap.Geocoder"></script>
<script>
    var district = '', formattedAddress = '', setAddress = '';
    // 初始化地图
    var map = new AMap.Map("container", {
        resizeEnable: true,
        zoom:9,
    });

    // 获取搜索信息
    function getAddressLists(keywords, city, pageIndex){
        var streetLists = '';
        AMap.plugin('AMap.PlaceSearch', function(){
            var autoOptions = {
                city: city ? city : '全国',
                pageSize: 150,
                pageIndex: pageIndex ? pageIndex : 1,
            }
            var placeSearch = new AMap.PlaceSearch(autoOptions);
            placeSearch.search(keywords, function(status, result) {
                // 搜索成功时，result即是对应的匹配数据
                if (result.poiList.pois.length) {
                    for (var k in result.poiList.pois) {
                        streetLists += '<li><label class="item-radio item-content ">' +
                            '<input type="radio" name="address-radio" class="" value="'+
                            result.poiList.pois[k].address+'('+result.poiList.pois[k].name+
                            ')" /><i class="icon icon-radio"></i>'+
                            '<div class="item-inner"><div class="item-title-row">' +
                                '<div class="item-text">' +
                                 result.poiList.pois[k].name +
                                '</div><div class="item-after"></div></div><div class="item-subtitle">' +
                            '<div class="item-text small"><small>'+result.poiList.pois[k].address+'</small></div></div>' +
                            '</div></label></li>';
                    }
                }
                jQuery('#streets-lists').html(streetLists);
            })
        })
    }

    //autoInput('重庆大学', '重庆');

</script>
<script type="text/javascript">
    function dw() {
        F7app.preloader.show();
        AMap.plugin('AMap.Geolocation', function () {
            var geolocation = new AMap.Geolocation({
                enableHighAccuracy: true,//是否使用高精度定位，默认:true
                timeout: 10000,          //超过10秒后停止定位，默认：5s
                buttonPosition: 'RB',    //定位按钮的停靠位置
                buttonOffset: new AMap.Pixel(10, 20),//定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
                zoomToAccuracy: true,   //定位成功后是否自动调整地图视野到定位点

            });
            map.addControl(geolocation);
            geolocation.getCurrentPosition(function (status, result) {
                F7app.preloader.hide();
                if (status == 'complete') {
                    levtoast('定位成功');
                    formattedAddress = result.formattedAddress;
                    district = result.addressComponent.province + result.addressComponent.district;
                    getAddressLists(result.formattedAddress, result.formattedAddress);
                } else {
                    getAddressLists(district, district);
                    levtoast('定位失败');
                }
            });
        });
    }
</script>

<script type="text/javascript">
    var marker = null;
    function setMarker(address) {
        var geocoder = new AMap.Geocoder({
            city: '全国', //jQuery('input.default-address').val(), //城市设为北京，默认：“全国”
        });

        if (marker) {
            map.remove(marker);
        }
        marker = new AMap.Marker();

        geocoder.getLocation(address, function (status, result) {
            if (status === 'complete' && result.geocodes.length) {
                var lnglat = result.geocodes[0].location;

                // 自定义点标记内容
                var markerContent = document.createElement("div");
                markerContent.className = 'marker-content-x';

                // 点标记中的图标
                var markerImg = document.createElement("img");
                markerImg.className = "markerlnglat";
                markerImg.src = "//a.amap.com/jsapi_demos/static/demo-center/icons/poi-marker-red.png";
                markerContent.appendChild(markerImg);

                // 点标记中的文本
                var markerSpan = document.createElement("span");
                markerSpan.className = 'marker';
                markerSpan.innerHTML = address;
                markerContent.appendChild(markerSpan);

                marker.setContent(markerContent); //更新点标记内容

                marker.setPosition(lnglat);
                map.add(marker);
                map.setFitView(marker);
                //map.panTo(lnglat);
            } else {
                levtoast('根据地址查询位置失败');
            }
        });
    }
</script>

<script type="text/javascript">
    function getCityName() {
        //实例化城市查询类
        var citysearch = new AMap.CitySearch();
        //自动获取用户IP，返回当前城市
        citysearch.getLocalCity(function(status, result) {
            if (status === 'complete' && result.info === 'OK') {
                if (result && result.city && result.bounds) {
                    district = result.city;
                    jQuery('.default-address').val(district);
                    jQuery('xsas').html(district);
                    if (window.top != window.self) {
                        if (parent.jQuery('input[name=address]').attr('name')) {
                            parent.jQuery('input[name=address]').val(district);
                            parent.jQuery('sas').html(district);
                        }
                    }
                }
            } else {
            }
            dw();
            F7app.ptr.destroy('.ptr-content');
            jQuery(document).on('click', 'input[name="address-radio"]', function () {
                setAddress = !jQuery(this).hasClass('default-address') ? district + this.value : this.value;
                parent.jQuery('input[name=address]').val(setAddress);
                parent.jQuery('sas').html(setAddress);
                setMarker(setAddress);
            });
            jQuery(document).on('click', '.button-close-ppopup', function () {
                parent.F7app.popup.close('.popup-set-address');
            });
        });
    }
</script>

<script>
    getCityName();
</script>
</body>

</html>