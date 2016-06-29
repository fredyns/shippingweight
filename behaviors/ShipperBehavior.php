<?php

namespace app\behaviors;

use Yii;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;
use app\models\Shipper;

/**
 * handling Shipper property
 * when typing a name instead of selecting, it will be inserted as new Shipper
 *
 * @property string $userAttribute
 * @property string $shipperAttribute
 * @property string $shipperAddressAttribute
 * @property string $shipperEmailAttribute
 *
 * @author fredy
 */
class ShipperBehavior extends AttributeBehavior
{
    public $userAttribute           = 'user_id';
    public $shipperAttribute        = 'shipper_id';
    public $shipperAddressAttribute = 'shipper_address';
    public $shipperEmailAttribute   = 'shipper_email';
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
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->shipperAttribute,
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->shipperAttribute,
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
        $value = ArrayHelper::getValue($this->owner, $this->shipperAttribute);

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
            $user_id = (Yii::$app->user->identity->isAdmin) ?
                ArrayHelper::getValue($this->owner, $this->userAttribute) : Yii::$app->user->id;

            $model = new Shipper([
                'user_id' => $user_id,
                'name'    => $value,
                'address' => ArrayHelper::getValue($this->owner, $this->shipperAddressAttribute),
                'email'   => ArrayHelper::getValue($this->owner, $this->shipperEmailAttribute),
            ]);

            return $model->save(FALSE) ? $model->id : 0;
        }
    }

}