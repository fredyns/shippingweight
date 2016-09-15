<?php

namespace app\controllers;

use Yii;

/**
 * This is the class for controller "ReportDailyController".
 */
class ReportDailyController extends \app\controllers\base\ReportDailyController
{

    public function actionIndex()
    {
        Yii::$app->db->createCommand('call recapYesterday();')->execute();
        Yii::$app->db->createCommand('call recapToday();')->execute();

        return parent::actionIndex();
    }

    public function actionView($day = null)
    {
        throw new HttpException(404, 'The requested page does not exist.');
    }

    public function actionCreate()
    {
        throw new HttpException(404, 'The requested page does not exist.');
    }

    public function actionUpdate($day = null)
    {
        throw new HttpException(404, 'The requested page does not exist.');
    }

    public function actionDelete($day = null)
    {
        throw new HttpException(404, 'The requested page does not exist.');
    }

}