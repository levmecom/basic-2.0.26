<?php

namespace app\modules\forum\controllers;

use app\modules\admin\behaviors\IsSuperAdmin;
use app\modules\forum\models\Threads;
use app\modules\ucenter\models\User;
use levmecom\aalevme\levHelpers;
use levmecom\modules\forum\widgets\replyList;
use levmecom\modules\forum\widgets\threadList;
use yii\console\Exception;
use yii\web\Controller;

/**
 * Default controller for the `forum` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($fid = 0)
    {
        return $this->render('index');
    }

    /**
     * ajax 加载分页数据
     * @return string
     * @throws \Exception
     */
    public function actionList($fid = 0) {

        return threadList::widget();

    }

    /**
     * @param int $id
     * @return string
     * @throws Exception
     */
    public function actionView($id = 0) {

        if (\Yii::$app->request->get('ajax')) {
            return replyList::widget(['pid' => $id]);
        }

        $model = new Threads();

        $thread = $model->find()->where(['id'=>$id, 'status'=>0])->with('contents', 'userinfo')->asArray()->one();
        if (empty($thread)) {
            throw new Exception('抱歉，没有找到相关内容');
        }

        return $this->render('view', ['thread'=>$thread]);

    }

}
