<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-09-15 23:29
 *
 * 项目：basic-2.0.26  -  $  - interfaceController.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */


namespace app\modules\forum\controllers;

use app\modules\forum\models\Threads;
use app\modules\levmecitys\models\Levmecitys;
use app\modules\ucenter\modules\registers\models\UcenterRegisters;
use levmecom\aalevme\levHelpers;
use yii\rest\Controller;

class InterfaceController extends Controller
{
    public function actionSendThread() {
        $bodyParams = \Yii::$app->request->getBodyParams();
        if (!isset($bodyParams['secret']) || $bodyParams['secret'] !== 'interface.levme.com') {
            return levHelpers::responseMsg(-1, '非法请求');
        }

        if (\Yii::$app->cache->get('interfaceSendThread')) {
            return levHelpers::responseMsg(-3, '重复或频繁发送');
        }
        \Yii::$app->cache->set('interfaceSendThread', 1, 3);

        $users = UcenterRegisters::getUsersByTypeName('6彩定位分析');//print_r($users);
        $count = count($users);
        $uid = $count ? $users[mt_rand(0, $count-1)]['uid'] : 0;//echo $uid;

        $address = json_decode(levHelpers::stget('citys', 'levmecitys'), true);
        if (!$address) {
            $address = Levmecitys::find()->where(['cityCode'=>''])->select(['name'])->asArray()->all();
            $address = $address ? $address[mt_rand(0, count($address)-1)]['name'] : '';
        }else {
            shuffle($address);
            $address = $address ? reset($address) : '';
        }
        $bodyParams['address'] = $address;
        //$bodyParams['code'] = 'xglhc';
        //$bodyParams['contents'] = microtime(true).\Yii::$app->request->getRemoteIP().'--'.\Yii::$app->request->userIP;
        \Yii::$app->request->setBodyParams($bodyParams);

        return (new Threads())->sendThread($uid);

    }
}