<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Shipper;
use app\models\User;

/**
 * ShipperSearch represents the model behind the search form about `app\models\Shipper`.
 */
class ShipperSearch extends Shipper
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['user_id', 'name', 'address', 'cp', 'phone', 'email'], 'safe'],
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
        $query = Shipper::find()
            ->with('userAccount');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (Yii::$app->user->isGuest)
        {
            $query->where('0=1');
        }
        elseif (Yii::$app->user->identity->isAdmin == FALSE)
        {
            $this->user_id = Yii::$app->user->id;
        }

        if (!$this->validate())
        {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            static::tableName().'.id' => $this->id,
        ]);

        $query
            ->andFilterWhere(['like', static::tableName().'.name', $this->name])
            ->andFilterWhere(['like', static::tableName().'.address', $this->address])
            ->andFilterWhere(['like', static::tableName().'.cp', $this->cp])
            ->andFilterWhere(['like', static::tableName().'.phone', $this->phone])
            ->andFilterWhere(['like', static::tableName().'.email', $this->email]);

        if ($this->user_id)
        {
            if (is_numeric($this->user_id))
            {
                $query->andFilterWhere([
                    static::tableName().'.user_id' => $this->user_id,
                ]);
            }
            else
            {
                $query->andFilterWhere(['like', User::tableName().'.username', $this->user_id]);
            }
        }

        return $dataProvider;
    }

}