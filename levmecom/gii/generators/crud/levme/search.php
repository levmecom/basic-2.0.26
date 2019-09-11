<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */

use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $modelAlias = $modelClass . 'Model';
}
$rules = $generator->generateSearchRules();
$labels = $generator->generateSearchLabels();
$searchAttributes = $generator->getSearchAttributes();
$searchConditions = $generator->generateSearchConditions();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->searchModelClass, '\\')) ?>;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use <?= ltrim($generator->modelClass, '\\') . (isset($modelAlias) ? " as $modelAlias" : "") ?>;
use levmecom\aalevme\levHelpers;

/**
 * <?= $searchModelClass ?> represents the model behind the search form of `<?= $generator->modelClass ?>`.
 */
class <?= $searchModelClass ?> extends <?= isset($modelAlias) ? $modelAlias : $modelClass ?>

{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            <?= implode(",\n            ", $rules) ?>,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::find();

        if (isset($params['srh']['_daydate']) && strpos($params['srh']['_daydate'], '.') !==false) {
            $_daydate = explode('.', $params['srh']['_daydate']);
            $field = levHelpers::stripTags($_daydate[1]);
            if ($_daydate[0] == 1) {
                $today = date('Y-m-d', time());
                $stime = strtotime($today);
                $etime = time();
            } else if ($_daydate[0] == 2) {
                $yestoday = date('Y-m-d', time() - 3600 * 24);
                $today = date('Y-m-d', time());
                $stime = strtotime($yestoday);
                $etime = strtotime($today);
            } else {
                $field = isset($_daydate[2]) ? levHelpers::stripTags($_daydate[2]) : '';
                $stime = strtotime($_daydate[0]) ?: 0;
                $etime = strtotime($_daydate[1]) ?: time();
            }
            $scenarios = $this->scenarios();
            if (in_array($field, $scenarios[Model::SCENARIO_DEFAULT])) {
                $query->andWhere(['between', $field, $stime, $etime]);
            }
        }

        // add conditions that should always apply here

        $this->load($params, 'srh');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $query;
        }

        // grid filtering conditions
        <?= implode("\n        ", $searchConditions) ?>

        return $query;
    }
}
