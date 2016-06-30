<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use app\libraries\TPKS;

class TesController extends Controller
{

    public function actionIndex()
    {
        return 'ok';
    }

    public function actionCari($number)
    {
        //\Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;

        $data = TPKS::container($number);

        return '<pre>'.print_r($data, TRUE).'</pre>';
    }

}