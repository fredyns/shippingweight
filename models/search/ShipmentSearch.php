<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Shipment;

/**
* ShipmentSearch represents the model behind the search form about `app\models\Shipment`.
*/
class ShipmentSearch extends Shipment
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'shipper_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['job_order', 'container_number', 'payment'], 'safe'],
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
$query = Shipment::find();

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
            'shipper_id' => $this->shipper_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'job_order', $this->job_order])
            ->andFilterWhere(['like', 'container_number', $this->container_number])
            ->andFilterWhere(['like', 'payment', $this->payment]);

return $dataProvider;
}
}