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
        if (Yii::$app->user->identity->isAdmin == FALSE)
        {
            $this->user_id = Yii::$app->user->id;
        }

        return parent::beforeSave($insert);
    }

}