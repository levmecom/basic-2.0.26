<?php

namespace app\modules\ucenter\modules\registers\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\ucenter\modules\registers\models\UcenterRegisters;
use levmecom\aalevme\levHelpers;

/**
 * UcenterRegistersSearch represents the model behind the search form of `app\modules\ucenter\modules\registers\models\UcenterRegisters`.
 */
class UcenterRegistersSearch extends UcenterRegisters
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'typeid', 'uid', 'status', 'addtime'], 'integer'],
            [['name', 'username', 'password'], 'safe'],
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
        $query = UcenterRegisters::find();

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
            'typeid' => $this->typeid,
            'uid' => $this->uid,
            'status' => $this->status,
            'addtime' => $this->addtime,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password]);

        return $query;
    }
}
