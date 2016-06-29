<?php

namespace app\models;

use Yii;
use \app\models\base\Container as BaseContainer;

/**
 * This is the model class for table "container".
 */
class Container extends BaseContainer
{

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'               => 'ID',
            'shipper_id'       => 'Shipper',
            'number'           => 'Number',
            'status'           => 'Status',
            'bill'             => 'Bill',
            'grossmass'        => 'Grossmass',
            'weighing_date'    => 'Weighing Date',
            'certificate_file' => 'Certificate File',
            'payment_by'       => 'Payment By',
            'created_by'       => 'Created By',
            'updated_by'       => 'Updated By',
            'billed_by'        => 'Billed By',
            'verified_by'      => 'Verified By',
            'checked_by'       => 'Checked By',
            'sentOwner_by'     => 'Sent Owner By',
            'sentShipper_by'   => 'Sent Shipper By',
            'created_at'       => 'Created At',
            'updated_at'       => 'Updated At',
            'billed_at'        => 'Billed At',
            'checked_at'       => 'Checked At',
            'verified_at'      => 'Verified At',
            'sentOwner_at'     => 'Sent Owner At',
            'sentShipper_at'   => 'Sent Shipper At',
        ];
    }

}