<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-09 20:34
 *
 * 项目：levme  -  $  - AjaxController.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */


namespace app\modules\forum\controllers;

use app\modules\forum\models\Threads;
use app\modules\uploads\models\Uploads;
use Yii;
use yii\rest\Controller;
use yii\web\UploadedFile;
use levmecom\aalevme\levHelpers;
use levmecom\modules\forum\models\UploadImageForm;

class AjaxController extends Controller
{

    public $enableCsrfValidation = true;


    public function actionSuports() {

        if (\Yii::$app->user->isGuest) {
            return levHelpers::responseMsg(-5, '抱歉，您需要先登陆用户');
        }

        $pid = intval(Yii::$app->request->post('pid'));

        $cachekey = 'forum_suports_'.$pid.'_user_'.\Yii::$app->user->identity->getId();

        if (\Yii::$app->cache->get($cachekey) >0) {
            //return levHelpers::responseMsg(-3, '已赞');
            $num = -1;
        }else {
            $num = 1;
        }
        \Yii::$app->cache->set($cachekey, $num, 3600*24*3);

        $model = new Threads();
        $model->updateAllCounters(['suports'=>$num], ['id'=>$pid]);
        return levHelpers::responseMsg(1, $num >0 ? '点赞成功' : '已取消赞', ['num'=>$num]);
    }

    public function actionSendThread()
    {
        //echo json_encode(Yii::$app->request->post());exit;
        if (\Yii::$app->user->isGuest) {
            return levHelpers::responseMsg(-5, '抱歉，您需要先登陆用户');
        }

        if (\Yii::$app->cache->get('forum_add_user_'.\Yii::$app->user->identity->getId())) {
            return levHelpers::responseMsg(-3, '重复或频繁发送');
        }
        \Yii::$app->cache->set('forum_add_user_'.\Yii::$app->user->identity->getId(), 1, 3);

        return (new Threads())->sendThread();

    }

    /**
     * @return array
     */
    public function actionUpload() {

        if (Yii::$app->user->isGuest) {
            return levHelpers::responseMsg(-302, '抱歉，需要登陆后才可以上传图片');
        }

        return (new Uploads())->uploadToForum();

        //return levHelpers::responseMsg(-301, '请上传一张图片');
    }
}