<?php

namespace app\controllers;

use kartik\mpdf\Pdf;
use yii\web\Controller;
use dosamigos\qrcode\QrCode;

/**
 * This is the class for controller "CertificateController".
 */
class CertificateController extends Controller
{

    /**
     * generate qrcode
     *
     * @param string $container_number
     * @return mixed
     */
    public function actionQrcode($container_number = 0)
    {
        //$model                       = $this->findModel($id);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;

        header('Content-Type: image/png');
        header("Content-Disposition: inline; filename=vgm-".$container_number.".png;");

        return QrCode::png($container_number);
    }

    /**
     * Displays QRCode Image.
     *
     * @return string
     */
    public function actionQrimage($id = 0)
    {
        $model = $this->findModel($id);

        return '<pre><img src="'.$model->qrUrl.'" /></pre>';
    }

    /**
     * generate certificate document
     *
     * @return string
     */
    public function actionPdf($container_number = 0)
    {
        $model = [
            'container_number' => $container_number,
            'vgmGrossmass'     => '30000',
            'vgmDate'          => '2016-07-01',
            'shipperName'      => '<i class="sample-text">shipper name belong here</i>',
            'shipperCompany'   => '<i class="sample-text">shipper company belong here</i>',
            'shipperEmail'     => '<i class="sample-text">shipper email belong here</i>',
            'issuerName'       => 'Badan Klasifikasi Indonesia',
        ];

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