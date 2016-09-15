<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "WeighingController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class WeighingController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\Weighing';
}
