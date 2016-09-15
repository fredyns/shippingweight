<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "ShipperController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ShipperController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\Shipper';
}
