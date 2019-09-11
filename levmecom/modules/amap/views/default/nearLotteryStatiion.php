<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-09-09 12:10
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */


/* @var $this \yii\web\View */
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="https://cache.amap.com/lbs/static/AMap.DrivingRender1120.css"/>
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
            height: calc(100% - 190px);
        }
        .info {
            bottom: 0;
            top: unset;
            margin-bottom: 5px;
            height: 170px;
            overflow: hidden;left: 5px;right: 5px;
            margin-top:0;
        }
        .list.media-list {
            height: 100px !important;
            width: 100% !important;max-width: 100% !important;margin: 7px 0 !important;
        }
        #panel {
            position: fixed;
            background-color: white;
            max-height: 66%;
            overflow-y: auto;
            top: 10px;
            right: 10px;
            width: 260px;z-index: 9999999;
        }
        #panel .amap-lib-driving {
            border-radius: 4px;
            overflow: hidden;
        }
        .amap-lib-driving .plan dt {
            font-size: 10px;
            color: #666;
        }
        .amap-lib-driving b, .amap-lib-driving strong {
            font-size: 12px;
            font-weight: 500;
            color: #666;
        }
        .amap-lib-driving .blue,
        .amap-lib-driving .planTitle .clearfix a {
            text-decoration: none;
            color: #0c8bfb;
        }
        #panel .amap-call {
            background-color: #009cf9;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;text-decoration: none;
        }
        #panel .amap-lib-walking {
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
            overflow: hidden;
        }
        #panel .amap-lib-transfer {
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
            overflow: hidden;
        }
        .item-after .button {
            font-size: 12px;
            line-height: 22px;
            height: 23px;
            margin-left: 7px;padding: 0 7px;
        }
    </style>
    <title>获取搜索信息</title>
</head>

<body>
<div id="container"></div>
<div id="panel"></div>

<div class="info list">
    <ul>
        <li>
            <label class="item-radio item-content">
                <div class="item-media">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                </div>
                <div class="item-inner">
                    <div class="item-text"><xsas></xsas></div>
                    <div class="item-after">
                        <a class="button button-fill button-do-method button-active"><i class="fa fa-car" aria-hidden="true"></i> 驾车</a>
                        <a class="button button-fill button-do-method riding color-gray"><i class="fa fa-bicycle" aria-hidden="true"></i> 骑行</a>
                        <a class="button button-fill button-do-method transfer color-gray"><i class="fa fa-bus" aria-hidden="true"></i> 公交</a>
                        <a class="button button-fill button-do-method walking color-gray"><i class="fa fa-blind" aria-hidden="true"></i> 步行</a>
                    </div>
                </div>
            </label>
        </li>
    </ul>
    <div class="list media-list" style="max-height:260px;max-width:320px;overflow: auto;">
        <ul id="streets-lists"></ul>
    </div>
</div>
<script src="https://webapi.amap.com/maps?v=1.4.15&key=5c76766ecddbec94c78696dabada35d9&plugin=AMap.CitySearch,AMap.Geocoder,AMap.Driving,AMap.Walking,AMap.Transfer,AMap.Riding"></script>
<script type="text/javascript" src="https://cache.amap.com/lbs/static/DrivingRender1230.js"></script>
<script>
    var province = '', district = '', formattedAddress = '', setAddress = '';
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
                    jQuery('xsas').html(formattedAddress);
                    getAddressLists(result.formattedAddress+'彩票', result.formattedAddress);
                } else {
                    getAddressLists(district+'彩票', district);
                    levtoast('定位失败');
                }
            });
        });
    }
</script>

<script type="text/javascript">
    function setMarker(address, text) {
        var geocoder = new AMap.Geocoder({
            city: '全国', //jQuery('input.default-address').val(), //城市设为北京，默认：“全国”
        });

        var marker = new AMap.Marker();

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
                markerSpan.innerHTML = text ? text : address;
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
    function doDriving(saddress, eaddress) {
        //驾车导航，您如果想修改结果展现效果，请参考页面：https://lbs.amap.com/fn/css-style/
        var drivingOption = {
            policy: AMap.DrivingPolicy.LEAST_TIME
        };
        var driving = new AMap.Driving(drivingOption); //构造驾车导航类
        //根据起终点坐标规划驾车路线
        driving.search([{keyword: saddress}, {keyword: eaddress}], function (status, result) {
            if (status === 'complete' && result.info === 'OK') {
                (new Lib.AMap.DrivingRender()).autoRender({
                    data: result,
                    map: map,
                    panel: "panel"
                });

                levtoast('绘制驾车路线完成')
            } else {
                levtoast('获取驾车数据失败：' + result)
            }
        });
    }
</script>
<script type="text/javascript">
    function doWalking(saddress, eaddress) {
        //步行导航
        var walking = new AMap.Walking({
            map: map,
            panel: "panel"
        });
        walking.search([
            {keyword: saddress},
            {keyword: eaddress}
        ], function (status, result) {
            // result即是对应的步行路线数据信息，相关数据结构文档请参考  https://lbs.amap.com/api/javascript-api/reference/route-search#m_WalkingResult
            if (status === 'complete') {
                levtoast('绘制步行路线完成')
            } else {
                levtoast('步行路线数据查询失败' + result)
            }
        });
    }
</script>
<script type="text/javascript">
    function doTransfer(saddress, eaddress, province) {
        var transOptions = {
            map: map,
            city: province,
            panel: 'panel',
            policy: AMap.TransferPolicy.LEAST_TIME //乘车策略
        };
        //构造公交换乘类
        var transfer = new AMap.Transfer(transOptions);
        //根据起、终点名称查询公交换乘路线
        transfer.search([
            {keyword: saddress},
            //第一个元素city缺省时取transOptions的city属性
            {keyword: eaddress}
            //第二个元素city缺省时取transOptions的cityd属性
        ], function (status, result) {
            // result即是对应的公交路线数据信息，相关数据结构文档请参考  https://lbs.amap.com/api/javascript-api/reference/route-search#m_TransferResult
            if (status === 'complete') {
                levtoast('绘制公交路线完成')
            } else {
                levtoast('公交路线数据查询失败' + result)
            }
        });
    }
</script>
<script type="text/javascript">
    function doRiding(saddress, eaddress) {
        //步行导航
        var riding = new AMap.Riding({
            map: map,
            panel: "panel"
        });
        riding.search([
            {keyword: saddress},
            {keyword: eaddress}
        ], function (status) {
            // result即是对应的骑行路线数据信息，相关数据结构文档请参考  https://lbs.amap.com/api/javascript-api/reference/route-search#m_RidingResult
            if (status === 'complete') {
                levtoast('绘制骑行路线完成')
            } else {
                levtoast('骑行路线数据查询失败' + result)
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
                    province = result.city;
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
                map.clearMap();
                setMarker(formattedAddress, '<font color=green>起点</font>');
                setMarker(setAddress, '<font color=red>终点</font>');
                jQuery('.button-do-method.button-active').click();
            });
            jQuery(document).on('click', '.button-close-ppopup', function () {
                parent.F7app.popup.close('.popup-set-address');
            });
            jQuery(document).on('click', '.button-do-method', function () {
                jQuery('.button-do-method.button-active').addClass('color-gray').removeClass('button-active');
                jQuery(this).addClass('button-active').removeClass('color-gray');
                jQuery('#panel').html('');
                if (jQuery(this).hasClass('walking')) {
                    doWalking(formattedAddress, setAddress);
                }else if (jQuery(this).hasClass('transfer')) {
                    doTransfer(formattedAddress, setAddress, province);
                }else if (jQuery(this).hasClass('riding')) {
                    doRiding(formattedAddress, setAddress);
                }else {
                    doDriving(formattedAddress, setAddress);
                }
            });
        });
    }
</script>

<script>
    getCityName();
</script>
</body>

</html>
