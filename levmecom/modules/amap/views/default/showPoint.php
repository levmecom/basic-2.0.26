<?php

/*
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 *
 * 创建时间：2019-09-09 01:33
 *
 * 项目：Default (Template) Project  -  $  - ${FILE_NAME}
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */


/* @var $this \yii\web\View */
$this->title = Yii::$app->request->get('address');
?>
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
        .amap-icon img.markerlnglat,
        .amap-marker-content img.markerlnglat {width: 25px;height: 34px;}
        .marker-content-x .marker {
            position: absolute;
            top: -20px;
            r-ight: 0;
            color: #666;
            padding: 4px 10px 4px;
            box-shadow: 1px 1px 1px rgba(10, 10, 10, .2);
            white-space: nowrap;
            font-size: 10px;
            font-family: "";
            background-color: #fff;
            border-radius: 3px;
        }
    </style>
</head>

<body>
<div id="container"></div>
<script src="https://webapi.amap.com/maps?v=1.4.15&key=5c76766ecddbec94c78696dabada35d9&plugin=AMap.CitySearch,AMap.Geocoder"></script>

<script type="text/javascript">
    var marker = null;
    function setMarker(address) {
        // 初始化地图
        var map = new AMap.Map("container", {
            resizeEnable: true,
            zoom:13,
        });

        var geocoder = new AMap.Geocoder({
            city: '全国', //jQuery('input.default-address').val(), //城市设为北京，默认：“全国”
            zoom:13,
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

<?= $this->registerJs('
    window.setTimeout(function(){setMarker(\''.Yii::$app->request->get('address').'\');}, 200);
');
?>
</body>

</html>
