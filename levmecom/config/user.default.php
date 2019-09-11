<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-18 11:06
 *
 * 项目：levme  -  $  - user.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */


return [
    'identityClass' => 'app\modules\ucenter\models\User',
    'enableAutoLogin' => true,
    'identityCookie' => ['name' => '_identity-levmecom', 'httpOnly' => true],
];