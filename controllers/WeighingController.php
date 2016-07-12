<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;

/**
 * This is the class for controller "WeighingController".
 */
class WeighingController extends \app\controllers\base\WeighingController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

}