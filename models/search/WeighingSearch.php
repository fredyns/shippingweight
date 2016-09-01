<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Weighing;

/**
 * WeighingSearch represents the model behind the search form about `app\models\Weighing`.
 */
class WeighingSearch extends Weighing
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'container_id', 'emkl_id'], 'integer'],
            [['container_number', 'job_order', 'stack_datetime', 'gatein_tracknumber', 'gateout_tracknumber'], 'safe'],
            [['grossmass', 'gatein_grossmass', 'gateout_grossmass'], 'number'],
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
        $query = Weighing::find()->orderBy(['id' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate() OR Yii::$app->user->identity->isAdmin == FALSE)
        {
            $query->where('0=1');

            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'                => $this->id,
            'container_id'      => $this->container_id,
            'grossmass'         => $this->grossmass,
            'stack_datetime'    => $this->stack_datetime,
            'emkl_id'           => $this->emkl_id,
            'gatein_grossmass'  => $this->gatein_grossmass,
            'gateout_grossmass' => $this->gateout_grossmass,
        ]);

        $query
            ->andFilterWhere(['like', 'container_number', $this->container_number])
            ->andFilterWhere(['like', 'job_order', $this->job_order])
            ->andFilterWhere(['like', 'gatein_tracknumber', $this->gatein_tracknumber])
            ->andFilterWhere(['like', 'gateout_tracknumber', $this->gateout_tracknumber]);

        return $dataProvider;
    }

}