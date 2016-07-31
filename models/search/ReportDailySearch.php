<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReportDaily;

/**
* ReportDailySearch represents the model behind the search form about `app\models\ReportDaily`.
*/
class ReportDailySearch extends ReportDaily
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['day'], 'safe'],
            [['registerCount', 'certificateCount'], 'integer'],
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
$query = ReportDaily::find();

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
            'registerCount' => $this->registerCount,
            'certificateCount' => $this->certificateCount,
        ]);

        $query->andFilterWhere(['like', 'day', $this->day]);

return $dataProvider;
}
}