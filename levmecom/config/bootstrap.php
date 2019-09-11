<?php

$dir = dirname(__DIR__);

Yii::setAlias('levmecom', $dir);

Yii::setAlias('modules', $dir.'/modules');
Yii::setAlias('aalevme', $dir.'/aalevme');
Yii::setAlias('assets', $dir.'/assets');

require $dir.'/modules/install/levmeInstall.php';
(new levmeInstall())->checkInstall();

