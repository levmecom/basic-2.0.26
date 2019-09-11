<?php

//defined('APP_ROOT') or define('APP_ROOT', dirname(__DIR__));
//defined('VENDOR_ROOT') or define('VENDOR_ROOT', dirname(APP_ROOT));

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', '{yii_debug}');
defined('YII_ENV') or define('YII_ENV', '{yii_env}');

defined('SUPER_ADMIN') or define('SUPER_ADMIN', '{super_admin}');

if (YII_DEBUG) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}else {
    error_reporting(E_ALL^E_NOTICE);
}
