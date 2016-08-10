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
    public $created_at_range;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day'], 'safe'],
            [['registerCount', 'certificateCount'], 'integer'],
            [['created_at_range'], 'safe'],
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
        $query = ReportDaily::find()->orderBy(['day' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate())
        {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'registerCount'    => $this->registerCount,
            'certificateCount' => $this->certificateCount,
        ]);

        $query->andFilterWhere(['like', 'day', $this->day]);

        if (!empty($this->created_at_range) && strpos($this->created_at_range, '-') !== false)
        {
            list($start_date, $end_date) = explode(' - ', $this->created_at_range);

            $start_date = trim($start_date);
            $end_date   = trim($end_date);
            $start      = date_create_from_format('m/d/Y', $start_date);
            $end        = date_create_from_format('m/d/Y', $end_date);

            if ($start && $end)
            {
                $query->andFilterWhere([
                    'between',
                    'day',
                    $start->format('Y-m-d'),
                    $end->format('Y-m-d'),
                ]);
            }
        }

        return $dataProvider;
    }

}