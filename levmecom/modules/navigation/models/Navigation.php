<?php

namespace app\modules\navigation\models;

use levmecom\aalevme\levHelpers;
use Yii;

/**
 * This is the model class for table "{{%navigation}}".
 *
 * @property int $id
 * @property int $pid
 * @property int $typeid
 * @property string $moduleidentifier
 * @property string $name
 * @property string $icon
 * @property string $link
 * @property string $target
 * @property string $descs
 * @property int $position
 * @property int $displayorder
 * @property int $status
 * @property int $uptime
 * @property int $addtime
 *
    [1,  0,  0, '默认分类', '', time()],
    [10, 1,  0, '后台管理左侧', '', time()],
    [11, 2,  0, '后台管理顶部', '', time()],
    [12, 3,  0, '前台主导航', '', time()],
    [13, 4,  0, '前台-顶部-左', '', time()],
    [14, 5,  0, '前台-顶部-右', '', time()],
    [15, 6,  0, '前台-侧滑-左', '', time()],
    [16, 7,  0, '前台-侧滑-右', '', time()],
    [17, 8,  0, '前台-页脚', '', time()],
    [18, 9,  0, '前台-底部浮动', '', time()],
    [19, 10, 0, '用户中心', '', time()],
    [20, 11, 0, '发现页面', '', time()],
 */
class Navigation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%navigation}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'typeid', 'position', 'displayorder', 'status', 'uptime', 'addtime'], 'integer'],
            [['moduleidentifier', 'name'], 'string', 'max' => 64],
            [['icon', 'link', 'descs'], 'string', 'max' => 255],
            [['target'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'typeid' => '分类ID',
            'moduleidentifier' => '标识符',
            'name' => '名称',
            'icon' => '图标',
            'link' => '链接',
            'target' => 'Target',
            'descs' => '描述',
            'position' => '位置',
            'displayorder' => '排序',
            'status' => '状态',
            'uptime' => '更新时间',
            'addtime' => '添加时间',
        ];
    }

    public static function navByTypeid($typeid = 1) {
        $navs = static::find()->where(['typeid'=>$typeid, 'status'=>0])->indexBy('id')->orderBy(['displayorder'=>SORT_ASC])->asArray()->all();
        $navs = self::positionNavs($navs);
        return $navs;
    }
    public static function positionNavs($navs = []) {
        $fnavs = [];
        foreach ($navs as $v) {
            if ($v['position'] ==1 && isset($navs[$v['pid']]) && $navs[$v['pid']]['position']!=1 && !isset($fnavs[$v['pid']]['_position'])) {
                $fnavs[$v['pid']]['_position'][] = $v;
            }elseif (isset($fnavs[$v['id']])) {
                $fnavs[$v['id']]+= $v;
            }else {
                if ($v['position'] ==1) {
                    $v['pid'] = isset($navs[$v['pid']]) ? $navs[$v['pid']]['pid'] : $v['pid'];
                }
                $fnavs[$v['id']] = $v;
            }
        }
        unset($navs);
        return $fnavs;
    }

    public static function delModuleNavs() {
        static::deleteAll(['moduleidentifier' => Yii::$app->controller->module->uniqueId]);
    }
    //前台主导航
    public static function setModuleNavs($data = []) {
        $data['typeid'] = 12;
        self::setModuleAdminNavs($data);
    }
    //后台管理左侧
    public static function setModuleAdminNavs($data = []) {
        if (!isset($data['name']) || !$data['name']) return false;
        $model = new Navigation();
        $identifier = Yii::$app->controller->module->uniqueId;
        $insql = levHelpers::moduleUniqueIdArray($identifier);
        $mynavs = $model::find()->where(['moduleidentifier'=>$identifier])->indexBy('name')->orderBy(['id'=>SORT_DESC])->asArray()->all();
        if (empty($mynavs)) {
            $navs = $model::find()->where(['in', 'moduleidentifier', $insql])->orderBy(['id'=>SORT_DESC])->indexBy('moduleidentifier')->asArray()->all();
            if ($navs) {
                krsort($navs, SORT_STRING);
                $navs = reset($navs);
            }
        }else {
            $navs = end($mynavs);
        }
        $data['typeid'] = isset($data['typeid']) ? intval($data['typeid']) : 10;
        $data['pid'] = $mynavs ? $navs['pid'] : ($navs ? $navs['id'] : 0);
        $data['moduleidentifier'] = $identifier;
        $data['position'] = 0;
        $data['uptime'] = time();
        self::recursionChildNav($data, $mynavs);
        return true;
    }
    public static function recursionChildNav($data = [], $mynavs = []) {
        if (!isset($data['name']) || !$data['name']) return false;

        if (isset($mynavs[$data['name']])) {
            $model = static::findOne(['id'=>$mynavs[$data['name']]['id']]);
            $data['addtime'] = $model->addtime;
        }else {
            $model = new Navigation();
            $data['addtime'] = time();
        }
        $data['name'] = isset($data['_editName']) && $data['_editName'] ? $data['_editName'] : $data['name'];
        $model->setAttributes($data);//print_r($model->toArray());
        $model->save();
        $pid = $model->id;
        if (isset($data['_position']['name'])) {
            $data['_position']['typeid'] = $data['typeid'];
            $data['_position']['pid'] = $pid;
            $data['_position']['moduleidentifier'] = $data['moduleidentifier'];
            $data['_position']['position'] = 1;
            $data['_position']['uptime'] = time();
            self::recursionChildNav($data['_position'], $mynavs);
        }
        if (isset($data['_child'][0])) {
            foreach ($data['_child'] as $v) {
                $v['typeid'] = $data['typeid'];
                $v['pid'] = $pid;
                $v['moduleidentifier'] = $data['moduleidentifier'];
                $v['position'] = 0;
                $v['uptime'] = time();
                self::recursionChildNav($v, $mynavs);
            }
        }
        return true;
    }

    public static function navs() {
        return static::find()->where('typeid!=0')->select(['id','name'])->indexBy('id')->orderBy(['displayorder'=>SORT_ASC])->asArray()->all();
    }

    public static function types() {
        return static::find()->where(['typeid'=>0])->select(['id','name'])->indexBy('id')->orderBy(['displayorder'=>SORT_ASC])->asArray()->all();
    }

    public static function targets() {
        return [
            '' => ['target'=>'', 'name'=>'本页'],
            '_self' => ['target'=>'_self', 'name'=>'本页'],
            '_blank' => ['target'=>'_blank', 'name'=>'新页'],
            '_iframe' => ['target'=>'_iframe', 'name'=>'框架'],
            '_ziframe' => ['target'=>'_ziframe', 'name'=>'弹窗'],
        ];
    }

    public static function positions() {
        return [
            0 => ['id'=>0, 'name'=>'默认', 'descs'=> ''],
            1 => ['id'=>1, 'name'=>'右侧', 'descs'=>'一般指管理后台的右侧（2~3）个字的子导航'],
        ];
    }
}
