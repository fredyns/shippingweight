<?php

namespace app\models\form;

use Yii;
use app\models\Shipper;

/**
 * Description of ShipperForm
 *
 * @author fredy
 */
class ShipperForm extends Shipper
{

    public function beforeSave($insert)
    {
        $this->user_id = Yii::$app->user->id;

        return parent::beforeSave($insert);
    }

}