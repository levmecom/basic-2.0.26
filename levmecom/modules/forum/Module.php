<?php

namespace app\modules\forum;

use app\modules\adminModules\Module as AdminModule;
use app\modules\forum\models\ForumForums;
use levmecom\aalevme\levHelpers;

/**
 * forum module definition class
 */
class Module extends \yii\base\Module
{

    public $urlRuleClass = 'yii\web\UrlRule';
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\forum\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        AdminModule::checkModuleInstalls('uploads');
        AdminModule::checkModuleInstall($this->uniqueId);
    }

    /**
     * 导入版块
     * @param array $rows
     * @return int
     * @throws \yii\db\Exception
     */
    public static function importForums($rows = []) {
        if (empty($rows)) return 0;
        foreach ($rows[0] as $column => $v) {
            $columns[] = $column;
        }
        $insql = levHelpers::inSql($rows, 'code');
        if ($insql) {
            $excepts = ForumForums::find()->where("code IN ($insql)")->indexBy('code')->asArray()->all();
            if ($excepts) {
                foreach ($rows as $k => $v) {
                    if (isset($excepts[$v['code']])) unset($rows[$k]);
                }
            }
        }
        $count = \Yii::$app->db->createCommand()->batchInsert(ForumForums::tableName(), $columns, $rows)->execute();
        return $count;
    }
}
