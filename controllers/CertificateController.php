<?php

namespace app\controllers;

use yii\helpers\Url;
use dosamigos\qrcode\QrCode;
use app\models\Certificate;

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

}