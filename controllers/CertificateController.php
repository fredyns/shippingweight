<?php

namespace app\controllers;

use DateTime;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use yii\web\Controller;
use app\models\Certificate;
use dosamigos\qrcode\QrCode;
use app\libraries\TPKS;
use yii\web\NotFoundHttpException;

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
    public function actionPdf($id = null, $container_number = null)
    {
        if (empty($id))
        {
            return $this->redirect(['pdf-sample', 'container_number' => $container_number]);
        }

        $viewing = 0;
        $id      = str_replace('view', '', $id, $viewing);
        $model   = Certificate::findOne($id);

        if (empty($model))
        {
            throw new NotFoundHttpException("Container not found.");
        }

        if ($viewing)
        {
            return $this->render('pdf', ['model' => $model]);
        }

        $content = $this->renderPartial('pdf', ['model' => $model]);
        $css     = $this->renderPartial('pdf.css');

        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            'options'         => ['title' => 'VGM Certificate by BKI'],
            'filename'        => 'vgm-'.$model->number.'.pdf',
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

    public function actionPdfFile($id = null, $container_number = null)
    {
        $viewing          = 0;
        $id               = str_replace('view', '', $id, $viewing);
        $container_number = str_replace('view', '', $container_number, $viewing);
        $criteria         = $id ? $id : ['number' => $container_number];
        $model            = Certificate::findOne($criteria);

        if (empty($model))
        {
            return $this->redirect(['pdf-sample', 'container_number' => $container_number]);
        }

        if ($viewing)
        {
            return $this->render('pdf', ['model' => $model]);
        }

        $content = $this->renderPartial('pdf', ['model' => $model]);
        $css     = $this->renderPartial('pdf.css');
        $folder  = "@web/contents/certificate/{$model->id}";

        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            'options'         => ['title' => 'VGM Certificate by BKI'],
            'filename'        => $folder.'/vgm-'.$model->number.'.pdf',
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
            'destination'     => Pdf::DEST_FILE,
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionPdfSample($container_number = 0)
    {
        $viewing          = 0;
        $container_number = str_replace('view', '', $container_number, $viewing);
        $model            = $this->findVGM(null, $container_number);

        if ($viewing)
        {
            return $this->render('pdf', ['model' => $model]);
        }

        $content = $this->renderPartial('pdf-sample', ['model' => $model]);
        $css     = $this->renderPartial('pdf-sample.css');

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

    public function findVGM($id = null, $containerNumber = null)
    {
        $model = null;

        if ($id)
        {
            $model = Certificate::findOne($id);
        }
        elseif ($containerNumber)
        {
            try
            {
                $vgm       = TPKS::container($containerNumber);
                $model     = [
                    'id'             => '0',
                    'number'         => $containerNumber,
                    'booking_number' => ArrayHelper::getValue(
                        $vgm, 'JOB_ORDER_NO', '<i class="sample-text">booking number</i>'
                    ),
                    'grossmass'      => '<i class="sample-text">mass</i>',
                    'weighing_date'  => '<i class="sample-text">date</i>',
                    'shipper'        => [
                        'name'    => '<i class="sample-text">shipper name belong here</i>',
                        'address' => '<i class="sample-text">shipper company belong here</i>',
                        'email'   => '<i class="sample-text">shipper email belong here</i>',
                    ],
                ];
                $grossmass = ArrayHelper::getValue($vgm, 'GROSS_KG');
                $verfTime  = ArrayHelper::getValue($vgm, 'GROSS_VERIFIED_TIME');

                if ($grossmass)
                {
                    $model['grossmass'] = number_format($grossmass, 0, '.', ',').' KGM';
                }

                if ($verfTime)
                {
                    $date = DateTime::createFromFormat('d-m-Y H:i:s', $verfTime);

                    if ($date)
                    {
                        $model['weighing_date'] = $date->format('M jS, Y');
                    }
                }
            }
            catch (Exception $exc)
            {

            }
        }

        if (!$model)
        {
            $model = [
                'id'             => '0',
                'number'         => $containerNumber,
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

        return $model;
    }

}