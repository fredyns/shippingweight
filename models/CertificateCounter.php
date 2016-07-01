<?php

namespace app\models;

use Yii;
use \app\models\base\CertificateCounter as BaseCertificateCounter;

/**
 * This is the model class for table "certificateCounter".
 */
class CertificateCounter extends BaseCertificateCounter
{

    public static function newSequence()
    {
        $year  = date('Y');
        $model = static::findOne(['year' => $year]);

        if ($model)
        {
            $model->published++;
        }
        else
        {
            $model = new static([
                'year'      => $year,
                'published' => 1,
            ]);
        }

        $model->save(FALSE);

        return $model->published;
    }

}