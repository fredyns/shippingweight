<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Weighing;

/**
* WeighingSearch represents the model behind the search form about `app\models\Weighing`.
*/
class WeighingSearch extends Weighing
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'measured_at', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['job_order', 'container_number', 'measurement_method', 'gatein_trackNumber', 'gateout_trackNumber'], 'safe'],
            [['grossmass', 'gatein_grossmass', 'gateout_grossmass'], 'number'],
];
}

/**
* @inheritdoc
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
$query = Weighing::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'id' => $this->id,
            'measured_at' => $this->measured_at,
            'grossmass' => $this->grossmass,
            'gatein_grossmass' => $this->gatein_grossmass,
            'gateout_grossmass' => $this->gateout_grossmass,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'job_order', $this->job_order])
            ->andFilterWhere(['like', 'container_number', $this->container_number])
            ->andFilterWhere(['like', 'measurement_method', $this->measurement_method])
            ->andFilterWhere(['like', 'gatein_trackNumber', $this->gatein_trackNumber])
            ->andFilterWhere(['like', 'gateout_trackNumber', $this->gateout_trackNumber]);

return $dataProvider;
}
}