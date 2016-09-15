<?php

namespace app\models\search;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
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
    public $created_at_range;
    public $verified_at_range;
    public $paid;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paid'], 'default', 'value' => 1],
            [['id', 'bill', 'paid'], 'integer'],
            [['user_id', 'shipper_id', 'booking_number', 'number', 'status', 'created_at_range', 'verified_at_range'], 'safe'],
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
            ->joinWith('shipper')
            ->orderBy([
            static::tableName().'.id' => SORT_DESC,
        ]);

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
            ->andFilterWhere(['like', static::tableName().'.booking_number', $this->booking_number])
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

        if (!empty($this->created_at_range) && strpos($this->created_at_range, '-') !== false)
        {
            list($start_date, $end_date) = explode(' - ', $this->created_at_range);

            $start_date = trim($start_date);
            $end_date   = trim($end_date);
            $start      = date_create_from_format('m/d/Y H:i:s', $start_date.' 00:00:00');
            $end        = date_create_from_format('m/d/Y H:i:s', $end_date.' 23:59:59');

            if ($start && $end)
            {
                $query->andFilterWhere([
                    'between',
                    static::tableName().'.created_at',
                    $start->getTimestamp(),
                    $end->getTimestamp(),
                ]);
            }
        }

        if (!empty($this->verified_at_range) && strpos($this->verified_at_range, '-') !== false)
        {
            list($start_date, $end_date) = explode(' - ', $this->verified_at_range);

            $start_date = trim($start_date);
            $end_date   = trim($end_date);
            $start      = date_create_from_format('m/d/Y', $start_date);
            $end        = date_create_from_format('m/d/Y', $end_date);

            if ($start && $end)
            {
                $query->andFilterWhere([
                    'between',
                    static::tableName().'.weighing_date',
                    $start->format('Y-m-d 00:00:00'),
                    $end->format('Y-m-d 23:59:59'),
                ]);
            }
        }

        if ($this->paid == 0)
        {
            $query->andWhere(static::tableName().'.transfer_id IS NULL');
        }

        return $dataProvider;
    }

    public static function debt($limit = '1 month ago')
    {
        $dtoLimit     = new \DateTime($limit);
        $params       = [
            'verified_at_range' => '08/01/2016 - '.$dtoLimit->format('m/d/Y'),
            'paid'              => 0,
        ];
        $search       = new static();
        $dataProvider = $search->search(['ContainerSearch' => $params]);

        // base query

        $dataProvider->query->select([
            'quantity'     => 'count(*)',
            'weighing_min' => 'min(weighing_date)',
            'weighing_max' => 'max(weighing_date)',
        ]);

        // debt

        $debt = $dataProvider->query->createCommand()->queryOne();

        // olah data

        $weighing_min      = ArrayHelper::getValue($debt, 'weighing_min');
        $weighing_max      = ArrayHelper::getValue($debt, 'weighing_max');
        $debt['dtoVgmMin'] = ($weighing_min) ? date_create($weighing_min) : null;
        $debt['dtoVgmMax'] = ($weighing_max) ? date_create($weighing_max) : null;
        $debt['dayVgmMin'] = ($debt['dtoVgmMin']) ? $debt['dtoVgmMin']->format('d M') : null;
        $debt['dayVgmMax'] = ($debt['dtoVgmMax']) ? $debt['dtoVgmMax']->format('d M') : null;

        $url = [
            '/container',
            'ContainerSearch' => $params,
        ];

        $debt['range'] = 'Kontainer terhitung  sejak '.$debt['dayVgmMin'].' hingga '.$debt['dayVgmMax'].'.<br/>'
            .Html::a('daftar kontainer yang belum dibayar', $url, ['target' => '_blank', 'title' => 'lihat container']).'<br/>';

        return $debt;
    }

}