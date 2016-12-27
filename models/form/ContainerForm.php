<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Container;
use app\models\Shipper;
use app\behaviors\ShipperBehavior;
use app\helpers\FilterHelper;

/**
 * Description of ContainerForm
 *
 * @author fredy
 */
class ContainerForm extends Container
{
    public $shipper_address;
    public $shipper_npwp;
    public $shipper_cp;
    public $shipper_phone;
    public $shipper_email;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
                parent::behaviors(), [
                [ 'class' => ShipperBehavior::className()],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /* default value */
            [['bill'], 'default', 'value' => 60000],
            [['status'], 'default', 'value' => static::STATUS_REGISTERED],
            /* required */
            [['shipper_id', 'number', 'booking_number'], 'required'],
            [
                ['shipper_address'],
                'required',
                'when' => function ($model, $attribute)
            {
                return (is_numeric($model->shipper_id) == FALSE);
            },
                'whenClient' => "
                    function (attribute, value) {
                        shipperInput = $('#containerform-shipper_id').val();

                        return (shipperInput && isNaN(shipperInput));
                    }",
            ],
            /* optional */
            /* field type */
            [['bill'], 'integer'],
            [['status', 'certificate_file', 'shipper_address', 'shipper_email'], 'string'],
            [['grossmass'], 'number'],
            [['weighing_date'], 'date', 'format' => 'php:Y-m-d'],
            [['number', 'shipper_npwp'], 'string', 'max' => 64],
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
            [['shipper_cp', 'shipper_phone', 'shipper_email'], 'string', 'max' => 255],
            /* value limitation */
            ['status', 'in', 'range' => [
                    static::STATUS_REGISTERED,
                    static::STATUS_READY,
                    static::STATUS_VERIFIED,
                    static::STATUS_ALERT,
                ]
            ],
            [
                ['number', 'booking_number'],
                'unique',
                'targetAttribute' => ['number', 'booking_number'],
            ],
            [
                ['number', 'booking_number'],
                'filter',
                'filter' => function($value)
            {
                $value = FilterHelper::stripSpaces($value);
                $value = FilterHelper::utf8($value);

                return (strtoupper($value));
            },
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(
                parent::attributeLabels(),
                [
                'shipper_id'      => 'Shipper Name',
                'shipper_address' => 'Shipper Address',
                'shipper_npwp'    => 'Shipper NPWP',
                'shipper_cp'      => 'Shipper Contact Person',
                'shipper_phone'   => 'Shipper Phone',
                'shipper_email'   => 'Shipper Email',
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(),
                [
                'create'      => [
                    'shipper_id',
                    'shipper_address',
                    'shipper_npwp',
                    'shipper_cp',
                    'shipper_phone',
                    'shipper_email',
                    'booking_number',
                    'number',
                ],
                'update'      => [
                    'shipper_id',
                    'shipper_address',
                    'shipper_npwp',
                    'shipper_cp',
                    'shipper_phone',
                    'shipper_email',
                    'booking_number',
                    'number',
                ],
                'semi-update' => [
                    'shipper_id',
                    'shipper_address',
                    'shipper_npwp',
                    'shipper_cp',
                    'shipper_phone',
                    'shipper_email',
                    'booking_number',
                ],
                'payment'     => ['bill'],
        ]);
    }

    /**
     * confirm payment
     *
     * @return boolean
     */
    public function paying()
    {
        if ($this->load($_POST) == FALSE)
        {
            return FALSE;
        }

        if ($this->validate() == FALSE)
        {
            return FALSE;
        }

        $this->status    = static::STATUS_READY;
        $this->billed_by = Yii::$app->user->id;
        $this->billed_at = time();

        return $this->save(FALSE);
    }

}