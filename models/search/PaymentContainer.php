<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Container;
use app\models\Shipper;

/**
 * ContainerSearch represents the model behind the search form about `app\models\Container`.
 */
class PaymentContainer extends Container
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'bill'], 'integer'],
            [['shipper_id', 'number'], 'safe'],
            [['grossmass'], 'number'],
            [['weighing_date'], 'date', 'format' => 'php:Y-m-d'],
            [
                'number',
                'required',
                'when' => function ($model, $attribute)
                {
                    return (Yii::$app->user->isGuest);
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
        $query = Container::find()
            ->joinWith('shipper');

        if (Yii::$app->user->identity->isAdmin)
        {
            $query->joinWith('shipper.userAccount');
        }

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize'  => 100,
                'pageParam' => 'page-containers',
            ],
        ]);

        $this->load($params);

        if (Yii::$app->user->isGuest)
        {
            if (empty($this->number))
            {
                $query->where('0=1');
            }
        }

        if (!$this->validate() OR empty($this->number))
        {
            $query->where('0=1');

            return $dataProvider;
        }

        $query->andFilterWhere([
            static::tableName().'.id'            => $this->id,
            static::tableName().'.bill'          => $this->bill,
            static::tableName().'.grossmass'     => $this->grossmass,
            static::tableName().'.weighing_date' => $this->weighing_date,
            //static::tableName().'.status'        => static::STATUS_REGISTERED,
        ]);

        if ($this->shipper_id)
        {
            if (is_numeric($this->shipper_id))
            {
                $query->andFilterWhere([
                    static::tableName().'.shipper_id' => $this->shipper_id,
                ]);
            }
            else
            {
                $query->andFilterWhere(['like', Shipper::tableName().'.name', $this->shipper_id]);
            }
        }

        $batchNumber = (strpos($this->number, ',') !== FALSE OR strpos($this->number, ' ') !== FALSE);

        if ($this->number)
        {
            if ($batchNumber)
            {
                $numberList = str_replace(' ', ',', $this->number);
                $numberList = explode(',', $numberList);
                $numberList = array_filter($numberList);

                $query->andFilterWhere([
                    static::tableName().'.number' => $numberList,
                ]);
            }
            else
            {
                $query->andFilterWhere(['like', static::tableName().'.number', $this->number]);
            }
        }

        return $dataProvider;
    }

}