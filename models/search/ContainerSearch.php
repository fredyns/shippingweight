<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Container;
use app\models\Shipper;
use app\models\User;

/**
 * ContainerSearch represents the model behind the search form about `app\models\Container`.
 */
class ContainerSearch extends Container
{
    public $user_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'bill'], 'integer'],
            [['user_id', 'shipper_id', 'number', 'status'], 'safe'],
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
            'query' => $query,
        ]);

        $this->load($params);

        if (Yii::$app->user->isGuest)
        {
            if (empty($this->number))
            {
                $query->where('0=1');
            }
        }
        elseif (Yii::$app->user->identity->isAdmin == FALSE)
        {
            $this->user_id = Yii::$app->user->id;
        }

        if (!$this->validate())
        {
            $query->where('0=1');

            return $dataProvider;
        }

        $query->andFilterWhere([
            static::tableName().'.id'            => $this->id,
            static::tableName().'.bill'          => $this->bill,
            static::tableName().'.grossmass'     => $this->grossmass,
            static::tableName().'.weighing_date' => $this->weighing_date,
        ]);

        $query
            ->andFilterWhere(['like', static::tableName().'.number', $this->number])
            ->andFilterWhere(['like', static::tableName().'.status', $this->status]);

        if ($this->user_id)
        {
            if (is_numeric($this->user_id))
            {
                $query->andFilterWhere([
                    Shipper::tableName().'.user_id' => $this->user_id,
                ]);
            }
            else
            {
                $query->andFilterWhere(['like', User::tableName().'.username', $this->user_id]);
            }
        }

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

        return $dataProvider;
    }

}