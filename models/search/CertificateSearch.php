<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Certificate;

/**
* CertificateSearch represents the model behind the search form about `app\models\Certificate`.
*/
class CertificateSearch extends Certificate
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'shipper_id', 'shipment_id', 'weighing_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['date', 'container_number'], 'safe'],
            [['grossmass'], 'number'],
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
$query = Certificate::find();

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
            'shipment_id' => $this->shipment_id,
            'weighing_id' => $this->weighing_id,
            'date' => $this->date,
            'grossmass' => $this->grossmass,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'container_number', $this->container_number]);

return $dataProvider;
}
}