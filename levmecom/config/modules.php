<?php

return [
    'install' => [
        'class' => 'app\modules\install\Module',
        'params' => ['title'=>'系统安装'],
    ],
    'ucenter' => [
        'class' => 'app\modules\ucenter\Module',
        'params' => ['title'=>'用户中心'],
    ],
    'admin' => [
        'class' => 'app\modules\admin\Module',
        'params' => ['title'=>'管理后台'],
    ],
    'adminModules' => [
        'class' => 'app\modules\adminModules\Module',
        'params' => ['title'=>'模块管理'],
    ],
    'navigation' => [
        'class' => 'app\modules\navigation\Module',
        'params' => ['title'=>'导航管理'],
    ],
    'forum' => [
        'class' => 'app\modules\forum\Module',
        'params' => ['title'=>'论坛'],
    ],
    'uploads' => [
        'class' => 'app\modules\uploads\Module',
        'params' => ['title'=>'上传管理'],
    ],
    'lotterys' => [
        'class' => 'app\modules\lotterys\Lotterys',
        'params' => ['title'=>'彩票'],
    ],
    'levmecitys' => [
        'class' => 'app\modules\levmecitys\levmeCitys',
        'params' => ['title'=>'中国城市'],
    ],
    'amap' => [
        'class' => 'app\modules\amap\Amap',
        'params' => ['title'=>'高德地图'],
    ],
];