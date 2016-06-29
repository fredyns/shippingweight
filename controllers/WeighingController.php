<?php

namespace app\controllers;

use Yii;

/**
 * This is the class for controller "WeighingController".
 */
class WeighingController extends \app\controllers\base\WeighingController
{

    public function init()
    {
        if (Yii::$app->user->identity->isAdmin == FALSE)
        {
            throw new HttpException(404, 'Who are you?');
        }

        return parent::init();
    }

}