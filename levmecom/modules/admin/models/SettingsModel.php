<?php

namespace app\modules\admin\models;

use app\modules\admin\behaviors\IsSuperAdmin;
use app\modules\forum\models\ForumForums;
use app\modules\levmecitys\models\Levmecitys;
use levmecom\aalevme\levHelpers;
use levmecom\widgets\tree\tree;
use Yii;
use yii\helpers\Html;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "pre_settings".
 *
 * @property int $id
 * @property string $moduleidentifier 模块标识符
 * @property string $title 标题
 * @property string $placeholder 提示语
 * @property string $inputname 输入框名
 * @property string $inputtype 输入框类型
 * @property string $inputvalue 输入框值
 * @property string $settings 通用设置
 * @property int $displayorder 排序
 * @property int $status 状态
 * @property int $uptime 更新时间
 * @property int $addtime 添加时间
 */
class SettingsModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pre_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'inputname', 'inputtype'], 'required'],
            [['settings'], 'string'],
            [['displayorder', 'status', 'uptime', 'addtime'], 'integer'],
            [['moduleidentifier'], 'string', 'max' => 220],
            [['title', 'placeholder', 'inputname', 'inputtype', 'inputvalue'], 'string', 'max' => 255],
            ['inputname', 'match', 'pattern' => '/^[a-z][a-z0-9_\\s]*$/', 'message' => '只允许a-z、0-9、下划线必须以字母开头。'],
        ];
    }

    public static function saveSettings() {
        $identifier = levHelpers::stripTags(Yii::$app->request->get('identifier'));
        if (!$identifier) {
            return levHelpers::responseMsg(-1, '模块标识符不能为空');
        }
        $vars = static::find()->where(['moduleidentifier'=>$identifier])->asArray()->all();
        if ($vars) {
            $counts = 0;
            $posts = Yii::$app->request->post('settings');
            foreach ($vars as $v) {
                if (!isset($posts[$v['inputname']])) $posts[$v['inputname']] = '';
                if (is_array($posts[$v['inputname']])) {
                    $posts[$v['inputname']] = json_encode($posts[$v['inputname']]);
                }
                if ($v['inputvalue'] == $posts[$v['inputname']]) continue;
                $counts += Yii::$app->getDb()->createCommand()
                                    ->update(self::tableName(), ['inputvalue'=>$posts[$v['inputname']]], ['id'=>$v['id']])->execute();
            }
            static::setCaches();
            return levHelpers::responseMsg(1, '成功更新 '.$counts.' 项配置');
        }
        return levHelpers::responseMsg(-2, '没有查询到设置字段');
    }

    public static function addvar() {
        $model = new SettingsModel();

        if ($model->load(Yii::$app->request->post(), '')) {
            $model->addtime = time();
            if ($model->save()) {
                return levHelpers::responseMsg();
            }
        }

        return levHelpers::responseMsg(-1, '新增失败', ['errors'=>$model->errors]);
    }

    public static function setField()
    {
        $ck = static::find()->where(['id'=>intval(Yii::$app->request->post('opid'))])->asArray()->one();
        $ck = static::find()->where(['moduleidentifier'=>$ck['moduleidentifier'], 'inputname'=>levHelpers::stripTags(Yii::$app->request->post('val'))])->andWhere(['<>', 'id', $ck['id']])->one();
        if ($ck) {
            return json_encode(levHelpers::responseMsg(-1, '修改失败，字段名已经存在'));
        }
        $rs = IsSuperAdmin::setField(static::tableName());
        if (strpos($rs, 'succeed') !==false) {
            static::setCaches();
        }
        return $rs;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $this->moduleidentifier = $this->moduleidentifier ?: (levHelpers::stripTags(Yii::$app->request->get('_qy')) ?: '_public');
        $ck = static::find()->where(['moduleidentifier'=>$this->moduleidentifier, 'inputname'=>$this->inputname])
                            ->andWhere(['<>', 'id', $this->id ?: 0])->one();
        if ($ck) {
            $this->addError('inputname', '字段名已经存在');
            return false;
        }

        $this->settings = $this->settings ?: '';
        $this->displayorder = $this->displayorder ?: 0;
        $this->uptime = time();
        $rs = parent::save($runValidation, $attributeNames); // TODO: Change the autogenerated stub
        if ($rs) {
            static::setCaches();
        }
        return $rs;
    }

    public static function setCaches() {
        $data = static::find()->asArray()->all();
        $items = [];
        if ($data) {
            foreach ($data as $v) {
                $items[$v['moduleidentifier']][$v['inputname']] = $v['inputvalue'];
            }
        }
        Yii::$app->cache->set('__settings__', json_encode($items));
    }

    public static function inputHtml($v) {
        $item = [];
        $inputname = 'settings['.$v['inputname'].']';
        if (in_array($v['inputtype'], ['text', 'number'])) {
            $htm = Html::textInput($inputname, $v['inputvalue'], ['placeholder'=>$v['placeholder'], 'class'=>'form-control']);
        }else if (in_array($v['inputtype'], ['textarea'])) {
            $htm = Html::textarea($inputname, $v['inputvalue'], ['placeholder'=>$v['placeholder'], 'class'=>'form-control','rows'=>6]);
        }else if (in_array($v['inputtype'], ['radio'])) {
            $htm = Html::radioList($inputname, $v['inputvalue'], ['关闭', '开启'], ['class'=>'form-control']);
        }else if (in_array($v['inputtype'], ['color'])) {
            $htm = '<div class="flex" onclick="setColor(\''.$inputname.'\', \''.$v['inputvalue'].'\')"><i class="icon color-list-icon" id="'.$inputname.'-color-picker-rgba-value" style="background-color:'.$v['inputvalue'].'"></i>';
            $htm.= Html::textInput($inputname, $v['inputvalue'], ['class'=>'form-control color-input-rgba']).'</div>';
        }else if (in_array($v['inputtype'], ['select'])) {
            $_item = StringHelper::explode($v['settings'], "\n", true, true) ?: [];
            foreach ($_item as $k => $r) {
                $one = StringHelper::explode($r, '=');
                $item[$one[0]] = levHelpers::arrv(1, $one, '');
            }
            $htm = Html::dropDownList($inputname, $v['inputvalue'], $item, ['class'=>'form-control']);
        }else if (in_array($v['inputtype'], ['selects'])) {
            $_item = StringHelper::explode($v['settings'], "\n", true, true);
            foreach ($_item as $k => $r) {
                $one = StringHelper::explode($r, '=');
                $item[$one[0]] = levHelpers::arrv(1, $one, '');
            }
            $values = json_decode($v['inputvalue']);
            $htm = Html::checkboxList($inputname.'[]', $values, $item, ['class'=>'checkbox-list wd270']);
        }else if (in_array($v['inputtype'], ['forum'])) {
            $_item[0] = ['id'=>0, 'pid'=>0, 'name'=>'空'];
            $_item+= ForumForums::forums();
            $htm = '<div class="form-control block treebox '.$v['inputname'].'-treebox"><div class="treeview">'.tree::widget(['data' => $_item, 'template' => 'radioTree', 'inputname' => $inputname, 'values'=>$v['inputvalue']]).'</div></div>';
            Yii::$app->getView()->registerJs('levtoMaoTop(".'.$v['inputname'].'-treebox input:checked",".'.$v['inputname'].'-treebox",".treeview-item");');
        }else if (in_array($v['inputtype'], ['forums'])) {
            $_item = ForumForums::forums();
//            foreach ($_item as $r) {
//                $item[$r['id']] = $r['id'].'. '.$r['name'];
//            }
//            $values = json_decode($v['inputvalue']);
//            $htm = Html::checkboxList($inputname.'[]', $values, $item, ['class'=>'checkbox-list wd270']);
            $values = json_decode($v['inputvalue']);
            $htm = '<div class="form-control block treebox treebox-checkbox '.$v['inputname'].'-treebox"><div class="treeview">'.tree::widget(['data' => $_item, 'template' => 'checkboxTree', 'inputname' => $inputname.'[]', 'values'=>$values]).'</div></div>';
        }else if (in_array($v['inputtype'], ['citys', 'provinces'])) {
            switch ($v['inputtype']) {
                case 'provinces' : $_item = Levmecitys::find()->where(['provinceCode'=>''])->select(['code as id', 'provinceCode as pid', 'name'])->asArray()->all(); break;
                default: $_item = Levmecitys::find()->where(['cityCode'=>''])->select(['code as id', 'provinceCode as pid', 'name'])->asArray()->all(); break;
            }
            $values = json_decode($v['inputvalue']);
            $htm = '<div class="form-control block treebox treebox-checkbox '.$v['inputname'].'-treebox"><div class="treeview">'.tree::widget(['data' => $_item, 'template' => 'checkboxTree', 'inputname' => $inputname.'[]', 'values'=>$values, 'key'=>'name']).'</div></div>';
        }else if (in_array($v['inputtype'], ['date', 'time'])) {
            $htm = Html::input($v['inputtype'], $inputname, $v['inputvalue'], ['placeholder'=>$v['placeholder'], 'class'=>'form-control']);
        }else if (in_array($v['inputtype'], ['datetime'])) {
            $htm = Html::input($v['inputtype'].'-local', $inputname, $v['inputvalue'], ['placeholder'=>$v['placeholder'], 'class'=>'form-control']);
        }else {
            $htm = '<b style="color: red">未知input类型 &raquo; '.$v['inputtype'].'</b>';
        }
        return $htm;
    }

    public static function inputtype() {
        return [
            'text' => '字符串(text)',
            'number' => '数字(number)',
            'textarea' => '多行文本(textarea)',
            'radio' => '开关(radio)',
            'select' => '单项选择(select)',
            'selects' => '多项选择(selects)',
            'color' => '颜色选择器(color)',
            'date' => '日期(date)',
            'time' => '时间(time)',
            'datetime' => '日期时间(datetime)',
            'forum' => '版块单选(forum)',
            'forums' => '版块多选(forums)',
            'group' => '用户组单选(group)',
            'groups' => '用户组多选(groups)',
            'credit' => '扩展积分(credit)',
            'provinces' => '省市(provinces)',
            'citys' => '城市(citys)',
            //'areas' => '县城(areas)',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'moduleidentifier' => '模块标识符',
            'title' => '标题',
            'placeholder' => '提示语',
            'inputname' => '输入框名',
            'inputtype' => '输入框类型',
            'inputvalue' => '输入框值',
            'settings' => '扩展设置',
            'displayorder' => '排序',
            'status' => '状态',
            'uptime' => '更新时间',
            'addtime' => '添加时间',
        ];
    }
}
