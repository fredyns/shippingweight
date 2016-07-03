<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Payment;

/**
* PaymentSearch represents the model behind the search form about `app\models\Payment`.
*/
class PaymentSearch extends Payment
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'customer_id', 'subtotal', 'discount', 'total', 'created_by', 'updated_by', 'paid_by', 'cancel_by', 'created_at', 'updated_at', 'paid_at', 'cancel_at'], 'integer'],
            [['container_list', 'note', 'status'], 'safe'],
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
$query = Payment::find();

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
            'customer_id' => $this->customer_id,
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'total' => $this->total,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'paid_by' => $this->paid_by,
            'cancel_by' => $this->cancel_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'paid_at' => $this->paid_at,
            'cancel_at' => $this->cancel_at,
        ]);

        $query->andFilterWhere(['like', 'container_list', $this->container_list])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'status', $this->status]);

return $dataProvider;
}
}