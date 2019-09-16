<?php

namespace app\modules\levmecitys\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\levmecitys\models\Levmecitys;
use levmecom\aalevme\levHelpers;

/**
 * LevmecitysSearch represents the model behind the search form of `app\modules\levmecitys\models\Levmecitys`.
 */
class LevmecitysSearch extends Levmecitys
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pid', 'displayorder', 'status', 'uptime', 'addtime'], 'integer'],
            [['code', 'name', 'streetCode', 'provinceCode', 'cityCode', 'areaCode'], 'safe'],
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
        $query = Levmecitys::find();

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
        $query->andFilterWhere([
            'id' => $this->id,
            'pid' => $this->pid,
            'displayorder' => $this->displayorder,
            'status' => $this->status,
            'uptime' => $this->uptime,
            'addtime' => $this->addtime,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'streetCode', $this->streetCode])
            ->andFilterWhere(['like', 'provinceCode', $this->provinceCode])
            ->andFilterWhere(['like', 'cityCode', $this->cityCode])
            ->andFilterWhere(['like', 'areaCode', $this->areaCode]);

        return $query;
    }
}
