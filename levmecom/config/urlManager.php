<?php

return [
    'class' => 'yii\web\urlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    //'enableStrictParsing' => false,//严格的URL规则
    //'suffix' => '.html',
    //'routeParam' => '',
    //'ruleConfig' => [],
    'rules' => [
        '/' => 'forum',
        'forum/<fid:\w+>' => 'forum/default/index',
        'forum/view/<id:\w+>' => 'forum/default/view',
        'ucenter/<id:\d+>' => 'ucenter/default/view',
        //'<module:[\w\-]+>/<controller:[\w\-]+>/<action:[\w\-]+>' => 'levme/<module>/<controller>/<action>',
        //'<module:[\w\-]+>' => 'levme/<module>',
    ],
];