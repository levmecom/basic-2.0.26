<?php

namespace app\modules\forum\models;

use app\modules\ucenter\models\User;
use app\modules\uploads\models\Uploads;
use levmecom\aalevme\levHelpers;
use levmecom\modules\forum\widgets\threadList;
use yii\helpers\HtmlPurifier;

/**
 * This is the model class for table "{{%forum_threads}}".
 *
 * @property int $id
 * @property int $pid 父ID
 * @property int $fid 版块ID(分类ID)
 * @property int $uid
 * @property int $touid
 * @property int $textlen 内容长度
 * @property string $title
 * @property string $address
 * @property int $topshow
 * @property int $attach  0：无附件、1：图片、2：压缩包 其它
 * @property int $views 查看数量
 * @property int $replies 回复数量
 * @property int $status  0:开启、1:关闭
 * @property int $uptime
 * @property int $addtime
 */
class Threads extends \yii\db\ActiveRecord
{

    public $contents;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%forum_threads}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['pid', 'fid', 'uid', 'touid', 'topshow', 'attach', 'views', 'replies', 'status', 'uptime', 'addtime'], 'integer'],
            [['contents'], 'required'],
            [['title', 'address'], 'string', 'max' => 255],
            [['contents'], 'string', 'min' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => '标题',
            'address' => '地址',
            'contents' => '内容',
        ];
    }

    public function getAttachs() {
        return $this->hasMany(Uploads::className(), ['sourceid'=>'id'])->where(['idtype'=>1])->limit(20)->select(['src', 'sourceid', 'filename'])->orderBy(['id'=>SORT_DESC]);
    }
    public function getRootinfo() {
        return $this->hasOne(self::className(), ['id'=>'rootid'])->select(['title','id','rootid']);
    }
    public function getUserinfo() {
        return $this->hasOne(User::className(), ['id'=>'uid'])->select(['username', 'id']);
    }
    public function getReplyList() {
        return $this->hasMany(self::className(), ['rootid'=>'id'])->with('contents', 'attachs')->limit(10)->orderBy(['textlen'=>SORT_DESC]);
    }
    public function getReplyListPid() {
        return $this->hasMany(self::className(), ['pid'=>'id'])->with('contents', 'attachs')->limit(10)->orderBy(['textlen'=>SORT_DESC]);
    }
    public function getContents() {
        return $this->hasOne(Posts::className(), ['id'=>'id'])->select(['contents', 'id']);
    }

    public function sendThread()
    {
        if (!$this->load(\Yii::$app->request->post(), '')) {
            return levHelpers::responseMsg(-4002, '请输入内容');
        }

        $contents = HtmlPurifier::process($this->contents);
        if (!$contents) {
            return levHelpers::responseMsg(-4005, '内容不能为空', ['errors'=>['contents'=>'请输入内容']]);
        }

        if ($this->getIsNewRecord()) {
            try {

                $this->fid = intval(\Yii::$app->request->post('fid')) ?: 1;
                $this->pid = intval(\Yii::$app->request->post('pid'));
                $this->address = $this->address ?: '';
                $this->attach = $this->checkAttach($contents);
                $this->uptime = time();
                $this->addtime = time();
                $this->uid = \Yii::$app->user->identity->getId();
                $this->textlen = strlen(levHelpers::stripTags($contents));

                if (!$this->pid) { //发送
                    $this->title = levHelpers::stripTags($this->title) ?: levHelpers::cutString($this->contents, 80, '');
                }else {//回复
                    $pidInfo = $this->find()->select(['id', 'pid', 'uid', 'rootid', 'fid'])->where(['id'=>$this->pid])->asArray()->one();
                    if (empty($pidInfo)) {
                        return levHelpers::responseMsg(-4003, '查无此帖');
                    }
                    $this->fid = $pidInfo['fid'];
                    $this->rootid = $pidInfo['rootid'] ?: $this->pid;
                    $this->touid = $pidInfo['uid'];
//                    if ($pidInfo['pid']) {
//                        if ($this->touid == $this->uid) {// || $pidInfo['pid'] != $pidInfo['rootid']
//                            $this->pid = $pidInfo['pid'];
//                        }
//                    }
                }
                if ($this->insert()) {
                    $posts = new Posts();
                    $posts->setAttributes(['id'=>$this->id, 'contents'=>$contents]);
                    $posts->insert();
                    if ($this->attach) {
                        Uploads::updateAll(['sourceid'=>$this->id], ['uid'=>$this->uid, 'sourceid'=>0]);
                    }
                    if ($this->fid) {
                        ForumForums::updateAllCounters(['threads'=>1], ['id'=>$this->fid]);
                    }

                    $replyHtml = '';
                    if ($this->pid) {
                        $this->updateAllCounters(['views'=>mt_rand(1, 5), 'replies'=>1], 'id IN('.$this->pid.', '.$pidInfo['rootid'].')');

                        $data = $this->toArray();
                        $data['authoruid'] = 0;
                        $data['contents']['contents'] = $contents;
                        $users = (new User())->find()->where("id IN ({$this->uid},{$pidInfo['uid']})")
                            ->select(['id', 'username'])->indexBy('id')->asArray()->all();
                        $replyHtml = threadList::replyHtml($data, $users, 'b-g');
                    }

                    return levHelpers::responseMsg(1, '发送成功', ['replyHtml'=>$replyHtml]);
                }else {
                    return levHelpers::responseMsg(-4004, '发送失败', ['errors'=>$this->errors]);
                }
            } catch (\Throwable $e) {
                //throw new Exception('发送失败：'.$e->getMessage());
                return levHelpers::responseMsg(-4001, '发送失败'.$e->getMessage(), ['errors'=>$this->errors]);
            }
        }

        return levHelpers::responseMsg(-4001, '发送失败', ['errors'=>$this->errors]);

    }

    /**
     * @param $str
     * @return mixed
     */
    public function checkAttach($str)
    {
        if (stripos($str, '<img') !==false) {
            return 1;
        }elseif (stripos($str, '.zip') !==false) {
            return 2;
        }

        return 0;
    }






}
