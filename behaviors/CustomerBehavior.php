<?php

namespace app\behaviors;

use Yii;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;
use app\models\Customer;

/**
 * handling Customer property
 * when typing a name instead of selecting, it will be inserted as new Customer
 *
 * @property string $userAttribute
 * @property string $customerAttribute
 * @property string $customerAddressAttribute
 * @property string $customerPhoneAttribute
 *
 * @author fredy
 */
class CustomerBehavior extends AttributeBehavior
{
    public $customerAttribute        = 'customer_id';
    public $customerAddressAttribute = 'customer_address';
    public $customerPhoneAttribute   = 'customer_phone';
    public $value;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes))
        {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->customerAttribute,
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->customerAttribute,
            ];
        }
    }

    /**
     * Evaluates the value of the user.
     * The return result of this method will be assigned to the current attribute(s).
     * @param Event $event
     * @return mixed the value of the user.
     */
    protected function getValue($event)
    {
        $value = ArrayHelper::getValue($this->owner, $this->customerAttribute);

        if (is_numeric($value))
        {
            return $value;
        }
        elseif (empty($value))
        {
            return NULL;
        }
        else
        {
            $model = new Customer([
                'name'    => $value,
                'address' => ArrayHelper::getValue($this->owner, $this->customerAddressAttribute),
                'phone'   => ArrayHelper::getValue($this->owner, $this->customerPhoneAttribute),
            ]);

            return $model->save(FALSE) ? $model->id : 0;
        }
    }

}