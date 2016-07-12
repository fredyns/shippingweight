<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;

/**
 * This is the class for controller "EmklController".
 */
class EmklController extends \app\controllers\base\EmklController
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