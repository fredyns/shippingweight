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
                [['vgm_date', 'vgm_gross', 'container_number'], 'required'],
                [['vgm_date'], 'date', 'format' => 'php:Y-m-d'],
                [['vgm_number'], 'unique'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(),
                [
                'vgm_number' => 'VGM Number',
                'vgm_date'   => 'VGM Date',
                'vgm_gross'  => 'VGM Gross',
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
            'vgm_date'         => $this->vgm_date,
            'vgm_gross'        => $this->vgm_gross,
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
            'vgm_date'         => $this->vgm_date,
            'vgm_gross'        => $this->vgm_gross,
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