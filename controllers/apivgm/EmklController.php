<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "EmklController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class EmklController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\Emkl';
}
