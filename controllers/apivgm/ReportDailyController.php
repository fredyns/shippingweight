<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "ReportDailyController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ReportDailyController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\ReportDaily';
}
