<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Container;
use app\models\Shipper;
use app\behaviors\ShipperBehavior;

/**
 * Description of ContainerForm
 *
 * @author fredy
 */
class ContainerForm extends Container
{
    public $user_id;
    public $shipper_address;
    public $shipper_email;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => ShipperBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /* default value */
            [['user_id'], 'default', 'value' => Yii::$app->user->id],
            [['bill'], 'default', 'value' => 60000],
            [['status'], 'default', 'value' => static::STATUS_REGISTERED],
            /* required */
            [['user_id', 'shipper_id', 'number'], 'required'],
            /* optional */
            /* field type */
            [['user_id', 'bill'], 'integer'],
            [['status', 'certificate_file', 'shipper_address', 'shipper_email'], 'string'],
            [['grossmass'], 'number'],
            [['weighing_date'], 'date', 'format' => 'php:Y-m-d'],
            [['number'], 'string', 'max' => 64],
            [
                'shipper_id',
                'string',
                'max'  => 255,
                'when' => function ($model, $attribute)
                {
                    return (is_numeric($model->$attribute) == FALSE);
                },
            ],
            ['shipper_email', 'email'],
            /* value limitation */
            ['status', 'in', 'range' => [
                    static::STATUS_REGISTERED,
                    static::STATUS_READY,
                    static::STATUS_VERIFIED,
                    static::STATUS_ALERT,
                ]
            ],
            [
                'number',
                'unique',
                'filter' => [
                    'status' => [
                        static::STATUS_REGISTERED,
                        static::STATUS_READY,
                        static::STATUS_ALERT,
                    ],
                ],
            ],
            /* value references */
            [
                ['shipper_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Shipper::className(),
                'targetAttribute' => ['shipper_id' => 'id'],
                'when'            => function ($model, $attribute)
            {
                return (is_numeric($model->$attribute));
            },
            ],
        ];
    }

}