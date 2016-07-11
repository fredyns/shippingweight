<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Customer;
use app\models\search\PaymentContainer;
use app\behaviors\CustomerBehavior;

/**
 * Description of PaymentForm
 *
 * @author fredy
 */
class PaymentForm extends \app\models\Payment
{
    public $customer_address;
    public $customer_phone;
    public $containers;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
                parent::behaviors(), [
                [ 'class' => CustomerBehavior::className()],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /* default value */
            [['status'], 'default', 'value' => static::STATUS_PAID],
            /* required */
            [['customer_id', 'containers', 'total'], 'required'],
            /* optional */
            /* field type */
            [['subtotal', 'discount', 'total'], 'integer'],
            [['status', 'note', 'customer_address'], 'string'],
            [['container_list', 'customer_phone'], 'string', 'max' => 255],
            [
                'customer_id',
                'string',
                'max'  => 255,
                'when' => function ($model, $attribute)
                {
                    return (is_numeric($model->$attribute) == FALSE);
                },
            ],
            ['containers', 'each', 'rule' => ['integer']],
            /* value limitation */
            ['status', 'in', 'range' => [
                    self::STATUS_BILLED,
                    self::STATUS_PAID,
                    self::STATUS_CANCELED,
                ],
            ],
            /* value references */
            [
                ['customer_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Customer::className(),
                'targetAttribute' => ['customer_id' => 'id'],
                'when'            => function ($model, $attribute)
            {
                return (is_numeric($model->$attribute));
            },
            ],
        ];
    }

    public function create()
    {
        // load form data
        if ($this->load($_POST) == FALSE)
        {
            return FALSE;
        }

        // validate input
        if ($this->validate() == FALSE)
        {
            return FALSE;
        }

        // find containers
        $containers = PaymentContainer::find()
            ->where([
                'id'     => $this->containers,
                'status' => PaymentContainer::STATUS_REGISTERED,
            ])
            ->all();

        if (count($containers) == 0)
        {
            $this->addError('containers', "Containers not found.");

            return FALSE;
        }

        // init transaction
        $transaction = Yii::$app->db->beginTransaction();

        // data processing
        try
        {
            // save payment
            $this->save(FALSE);

            $containerList = [];

            // add payment connection
            foreach ($containers as $container)
            {
                $containerList         = $container->id;
                $container->payment_id = $this->id;

                $container->save(FALSE);
            }

            // save container list
            $this->container_list = implode(',', $containerList);

            $this->save(FALSE);

            // commit data processing
            $transaction->commit();

            return TRUE;
        }
        catch (\Exception $e)
        {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();

            $this->addError('_exception', $msg);

            // cancel all processed data
            $transaction->rollback();

            return FALSE;
        }
    }

}