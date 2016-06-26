<?php

namespace app\models;

use Yii;
use \app\models\base\Certificate as BaseCertificate;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use dosamigos\qrcode\QrCode;

/**
 * This is the model class for table "certificate".
 *
 * @property string $pdfUrl
 * @property string $qrUrl
 * @property string $qrcode
 */
class Certificate extends BaseCertificate
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
                [
                [['container_number'], 'required'],
                [['date'], 'date', 'format' => 'php:Y-m-d'],
        ]);
    }

    /**
     * generate URL to document printout
     *
     * @return string
     */
    public function getPdfUrl()
    {
        $url = [
            '/certificate/pdf',
            'id'               => $this->id,
            'container_number' => $this->container_number,
            'grossmass'        => $this->grossmass,
            'date'             => $this->date,
        ];

        return Url::to($url);
    }

    /**
     * generate URL to QRCode
     *
     * @return string
     */
    public function getQrUrl()
    {
        $url = [
            '/certificate/qrcode',
            'id'               => $this->id,
            'container_number' => $this->container_number,
            'grossmass'        => $this->grossmass,
            'date'             => $this->date,
        ];

        return Url::to($url);
    }

    /**
     * generate QRCode binaries
     *
     * @return mixed
     */
    public function getQrcode()
    {
        return QrCode::png($this->pdfUrl);
    }

}