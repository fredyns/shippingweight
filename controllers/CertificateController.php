<?php

namespace app\controllers;

use kartik\mpdf\Pdf;
use yii\web\Controller;
use app\models\Certificate;
use dosamigos\qrcode\QrCode;

/**
 * This is the class for controller "CertificateController".
 */
class CertificateController extends Controller
{

    /**
     * generate qrcode
     *
     * @param string $id
     * @return mixed
     */
    public function actionQrcode($id = 0, $container_number = 'trial')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;

        $model = Certificate::findOne($id);

        if ($model)
        {
            header('Content-Type: image/png');
            header("Content-Disposition: inline; filename=vgm-".$model->number.".png;");

            return $model->qrcode;
        }

        header('Content-Type: image/png');
        header("Content-Disposition: inline; filename=trial-".$container_number.".png;");

        return QrCode::png($container_number.'(trial)');
    }

    /**
     * generate certificate document
     *
     * @return string
     */
    public function actionPdf($id = 0, $container_number = 0)
    {
        $model = Certificate::findOne($id);

        if (empty($model))
        {
            $model = [
                'id'             => '0',
                'number'         => $container_number,
                'booking_number' => '<i class="sample-text">booking number</i>',
                'grossmass'      => '<i class="sample-text">mass</i>',
                'weighing_date'  => '<i class="sample-text">date</i>',
                'shipper'        => [
                    'name'    => '<i class="sample-text">shipper name belong here</i>',
                    'address' => '<i class="sample-text">shipper company belong here</i>',
                    'email'   => '<i class="sample-text">shipper email belong here</i>',
                ],
            ];
        }

        if (strpos($container_number, 'view') !== FALSE)
        {
            return $this->render('pdf', ['model' => $model]);
        }

        $content = $this->renderPartial('pdf', ['model' => $model]);
        $css     = $this->renderPartial('pdf.css');

        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            'options'         => ['title' => 'VGM Certificate by BKI'],
            'filename'        => 'vgm-'.$container_number.'.pdf',
            // set to use core fonts only
            'mode'            => Pdf::MODE_CORE,
            // A4 paper format
            'format'          => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation'     => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination'     => Pdf::DEST_BROWSER,
            // your html content input
            'content'         => $content,
            'cssInline'       => $css,
            'marginTop'       => 10,
            'defaultFontSize' => 12,
            'marginFooter'    => 15,
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

}