<?php

return [
    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'templateFile' => '@app/config/console/templateFile/migration.php',
        'migrationPath' => null, // disable non-namespaced migrations if app\migrations is listed below
        'migrationNamespaces' => [
            'app\migrations',
            'app\modules\ucenter\migrations',
            'app\modules\forum\migrations',
            #'{{add_namespace}}' //模块添加命名空间变量 - 不要修改本行
        ],
        'fields' => [
            'name:string(255):notNull',
            'status:tinyInteger:notNull:defaultValue(0):unsigned',
            'uptime:integer:notNull:defaultValue(0):unsigned',
            'addtime:integer:notNull:defaultValue(0):unsigned',
        ],
    ],
];