<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Container;

/**
* ContainerSearch represents the model behind the search form about `app\models\Container`.
*/
class ContainerSearch extends Container
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'shipper_id', 'bill', 'payment_by', 'created_by', 'updated_by', 'billed_by', 'verified_by', 'checked_by', 'sentOwner_by', 'sentShipper_by', 'created_at', 'updated_at', 'billed_at', 'checked_at', 'verified_at', 'sentOwner_at', 'sentShipper_at'], 'integer'],
            [['number', 'status', 'weighing_date', 'certificate_file'], 'safe'],
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
$query = Container::find();

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
            'bill' => $this->bill,
            'grossmass' => $this->grossmass,
            'weighing_date' => $this->weighing_date,
            'payment_by' => $this->payment_by,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'billed_by' => $this->billed_by,
            'verified_by' => $this->verified_by,
            'checked_by' => $this->checked_by,
            'sentOwner_by' => $this->sentOwner_by,
            'sentShipper_by' => $this->sentShipper_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'billed_at' => $this->billed_at,
            'checked_at' => $this->checked_at,
            'verified_at' => $this->verified_at,
            'sentOwner_at' => $this->sentOwner_at,
            'sentShipper_at' => $this->sentShipper_at,
        ]);

        $query->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'certificate_file', $this->certificate_file]);

return $dataProvider;
}
}