<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transfer;

/**
 * TransferSearch represents the model behind the search form about `app\models\Transfer`.
 */
class TransferSearch extends Transfer
{
    public $time_at_range;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'containerCount', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [
                ['id', 'time', 'from', 'containerList_all', 'containerList_confirmed', 'containerList_missed', 'note', 'time_at_range'],
                'safe',
            ],
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
        $query = Transfer::find()->orderBy(['id' => SORT_DESC]);

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
            'time'           => $this->time,
            'amount'         => $this->amount,
            'containerCount' => $this->containerCount,
            'created_by'     => $this->created_by,
            'updated_by'     => $this->updated_by,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ]);

        $this->filteringId($query, $this->id);

        $query
            ->andFilterWhere(['like', 'from', $this->from])
            ->andFilterWhere(['like', 'containerList_all', $this->containerList_all])
            ->andFilterWhere(['like', 'containerList_confirmed', $this->containerList_confirmed])
            ->andFilterWhere(['like', 'containerList_missed', $this->containerList_missed])
            ->andFilterWhere(['like', 'note', $this->note]);

        if (!empty($this->time_at_range) && strpos($this->time_at_range, '-') !== false)
        {
            list($start_date, $end_date) = explode(' - ', $this->time_at_range);

            $start_date = trim($start_date);
            $end_date   = trim($end_date);
            $start      = date_create_from_format('m/d/Y', $start_date);
            $end        = date_create_from_format('m/d/Y', $end_date);

            if ($start && $end)
            {
                $query->andFilterWhere([
                    'between',
                    static::tableName().'.time',
                    $start->format('Y-m-d 00:00:00'),
                    $end->format('Y-m-d 23:59:59'),
                ]);
            }
        }

        return $dataProvider;
    }

    public function filteringId(\yii\db\ActiveQuery $query, $id)
    {
        if (empty($id))
        {
            return;
        }

        $list = explode(',', $id);

        if (empty($list))
        {
            return;
        }

        $criteria = [];

        foreach ($list as $item)
        {
            if (strstr($item, '-'))
            {
                list($start, $end) = explode('-', $item);
                $start = (int) trim($start);
                $end   = (int) trim($end);

                if ($start > 0 && $end > $start)
                {
                    $criteria[] = ['between', 'id', $start, $end];
                }
            }
            else
            {
                $item = trim($item);

                if (is_numeric($item))
                {
                    $criteria[] = ['id' => $item];
                }
            }
        }

        if (empty($criteria) == FALSE)
        {
            array_unshift($criteria, "or");

            $query->andFilterWhere($criteria);
        }
    }

}