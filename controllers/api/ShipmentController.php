<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "ShipmentController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ShipmentController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\Shipment';
}
