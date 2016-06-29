<?php

namespace app\controllers;

use Yii;

/**
 * This is the class for controller "EmklController".
 */
class EmklController extends \app\controllers\base\EmklController
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