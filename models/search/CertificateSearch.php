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
[['id', 'dwelling_time', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['vgm_number', 'vgm_date', 'container_number', 'booking_number', 'shipper_name', 'shipper_address', 'stack_at', 'download_at'], 'safe'],
            [['vgm_gross'], 'number'],
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
            'vgm_date' => $this->vgm_date,
            'vgm_gross' => $this->vgm_gross,
            'stack_at' => $this->stack_at,
            'download_at' => $this->download_at,
            'dwelling_time' => $this->dwelling_time,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'vgm_number', $this->vgm_number])
            ->andFilterWhere(['like', 'container_number', $this->container_number])
            ->andFilterWhere(['like', 'booking_number', $this->booking_number])
            ->andFilterWhere(['like', 'shipper_name', $this->shipper_name])
            ->andFilterWhere(['like', 'shipper_address', $this->shipper_address]);

return $dataProvider;
}
}