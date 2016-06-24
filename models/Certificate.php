<?php

namespace app\models;

use Yii;
use \app\models\base\Certificate as BaseCertificate;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "certificate".
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

}