<?php

namespace app\models;

use Yii;
use \app\models\base\CertificateCounter as BaseCertificateCounter;

/**
 * This is the model class for table "certificateCounter".
 */
class CertificateCounter extends BaseCertificateCounter
{

    /**
     * generate new certificate sequence
     * save last sequence number
     *
     * @return integer
     */
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

    /**
     * generate new certificate number
     *
     * @return integer
     */
    public static function newNumber($sequence = null)
    {
        /*
         * format: '0126-x-SMC/I054-L02/P9/'.date('y')
         */

        if (empty($sequence))
        {
            $sequence = static::newSequence();
        }

        $year   = date('y');
        $number = "0126-{$sequence}-SMC/I054-L02/P9/{$year}";

        return $number;
    }

}