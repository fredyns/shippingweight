<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "ContainerController".
 */
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ContainerController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Container';

    public function actionVerify($container_number = null, $job_order = null)
    {

    }

}