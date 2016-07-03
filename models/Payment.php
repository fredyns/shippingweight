<?php

namespace app\models;

use Yii;
use \app\models\base\Payment as BasePayment;

/**
 * This is the model class for table "payment".
 */
class Payment extends BasePayment
{

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'customer_id'    => 'Customer',
            'container_list' => 'Container List',
            'note'           => 'Note',
            'subtotal'       => 'Subtotal',
            'discount'       => 'Discount',
            'total'          => 'Total',
            'status'         => 'Status',
            'created_by'     => 'Created By',
            'updated_by'     => 'Updated By',
            'paid_by'        => 'Paid By',
            'cancel_by'      => 'Cancel By',
            'created_at'     => 'Created At',
            'updated_at'     => 'Updated At',
            'paid_at'        => 'Paid At',
            'cancel_at'      => 'Cancel At',
        ];
    }

}