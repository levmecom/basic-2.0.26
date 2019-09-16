<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-11 15:54
 *
 * 项目：levme  -  $  - threadList.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */


namespace levmecom\modules\forum\widgets;

use app\modules\forum\models\ForumForums;
use app\modules\forum\models\Threads;
use app\modules\ucenter\models\User;
use levmecom\aalevme\levHelpers;
use Yii;
use yii\base\Widget;
use yii\helpers\StringHelper;

class threadList extends Widget
{

    public $registerJs = false;

    private static $_users = [];

    public function run()
    {
        if ($this->registerJs) {
            return $this->registerJs();
        }
        $limit = 20;
        $page = max(intval(\Yii::$app->request->get('page')), 1);
        $offset = $limit * ($page - 1);
        $model = new Threads();

        $fid = intval(Yii::$app->request->get('fid'));

        $where = ['pid'=>0, 'status'=>0];
        $andWhere = [];
        if ($fid) {
            $fids[] = $fid;
            $forums = ForumForums::find()->where(['pid'=>$fid])->asArray()->all();
            foreach ($forums as $v) {
                $fids[] = $v['id'];
            }
            $andWhere = ['in', 'fid', $fids];
        }else {
            if (Yii::$app->user->isGuest) {
                $loginshow = json_decode(levHelpers::stget('loginshow', 'forum'), true);
                if ($loginshow) $andWhere = ['not in', 'fid', $loginshow];
            }
        }

        $threadList = $model->find()->where($where)->andFilterWhere($andWhere)->with('replyList', 'attachs')->orderBy(['id'=>SORT_DESC])
                            ->offset($offset)->limit($limit)->asArray()->all();//print_r($threadList);exit;

        $insql = levHelpers::inSql($threadList, 'uid,touid', 'replyList');

        $users = !$insql ? [] : (new User())->find()->where("id IN ($insql)")->select(['id', 'username'])->indexBy('id')->asArray()->all();
        $users[0] = ['id'=>0, 'username'=>'游客'];

        self::$_users = $users;

        return $this->render('threadList', ['threadList'=>$threadList, 'users'=>$users]);
    }

    public function registerJs() {
        return $this->render('threadList_js');
    }

    /**
     * @param $r
     * @param $users
     * @param string $bg
     * @return string
     */
    public static function replyHtmls($v, $users = [], $bg = '') {
        $html = '';
        if (!$v['replies']) {
            return '';
        }

        $users = self::$_users ? self::$_users : $users;//print_r($users);exit;

        $model = new Threads();
        $user = new User();

        if (isset($v['replyList'])) {
            $where = ['rootid'=>$v['id']];
        }else {
            $v['replyList'] = $v['replyListPid'];
            $where = ['pid'=>$v['id']];
        }

        if (!($count = count($v['replyList']))) {
            $v['replyList'] = $model->find()->where($where)->with('contents', 'attachs')->limit(10)->asArray()->all();
            $count = count($v['replyList']);
            $insql = \levmecom\aalevme\levHelpers::inSql($v['replyList'], 'uid,touid', '', $users);
            if ($insql) {
                $_users = $user->find()->where("id IN ($insql)")->select(['id', 'username'])->indexBy('id')->asArray()->all();
                $users+= (array)$_users;
                self::$_users = $users;
            }
        }

        $homeUrl = \Yii::$app->homeUrl;

        foreach ($v['replyList'] as $r) {
            $r['authoruid'] = $v['uid'];
            $html.= self::replyHtml($r, $users, $bg);
        }
        if ($count <$v['replies']) {
            $html .= '<li><a class="item-link item-content fa-hand-o-right-box" href="'.$homeUrl.'forum/view/'.$v['id'].'" target="_screen"><div class="item-text">查看全部'.$v['replies'].'条怼 <i class="fa fa-hand-o-right"></i></div></a></li>';
        }

        return $html;

    }
    public static function replyHtml($r, $users = [], $bg = '') {
        if (!in_array($r['touid'], array($r['uid'], $r['authoruid'])) && $r['rootid'] != $r['pid']) {
            $userstr = "{$users[$r['uid']]['username']}<gray>怼</gray>{$users[$r['touid']]['username']}：";
        } else {
            $userstr = "{$users[$r['uid']]['username']}：";
        }
        $contents = StringHelper::truncate(levHelpers::stripTags($r['contents']['contents']), 150, '...<ss>全文</ss>');
        $imgs = '';
        if (isset($r['attachs']) && $r['attachs']) {
            foreach ($r['attachs'] as $ath) {
                $imgs.= '<img src="'.levHelpers::getHomeFull().$ath['src'].'" alt="'.$ath['filename'].'">';
            }
            $imgs = '<div class="imgbox">'.$imgs.'</div>';
        }
        return <<<HTML
            <li class="ts-info {$bg}" pid="{$r['id']}" user="{$users[$r['uid']]['username']}">
                <div class="item-content">
                    <div class="item-inner">
                        <div class="item-text">
                            <b>{$userstr}</b>
                            <span>{$contents}</span>
                            {$imgs}
                        </div>
                    </div>
                </div>
            </li>
HTML;
    }
}














