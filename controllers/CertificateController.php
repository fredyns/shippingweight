<?php

namespace app\controllers;

use kartik\mpdf\Pdf;

/**
 * This is the class for controller "CertificateController".
 */
class CertificateController extends \app\controllers\base\CertificateController
{

    /**
     * generate qrcode
     *
     * @param int $id
     * @return mixed
     */
    public function actionQrcode($id)
    {
        $model = $this->findModel($id);

        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename=VGM-"'.$model->id.'.png"');

        return $model->qrcode;
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
    public function actionPdf($id = 0)
    {
        $model   = $this->findModel($id);
        $content = $this->renderPartial('pdf', ['model' => $model]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode'        => Pdf::MODE_CORE,
            // A4 paper format
            'format'      => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content'     => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile'     => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline'   => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options'     => ['title' => 'BKI VGM'],
            // call mPDF methods on the fly
            'methods'     => [
                'SetHeader' => ['Verified Gross Mass'],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

}