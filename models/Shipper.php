<?php

namespace app\models;

use Yii;
use app\models\base\Shipper as BaseShipper;

/**
 * This is the model class for table "shipper".
 *
 * @property \app\models\User $userAccount
 */
class Shipper extends BaseShipper
{

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'user_id'    => 'User',
            'name'       => 'Name',
            'address'    => 'Address',
            'cp'         => 'CP',
            'phone'      => 'Phone',
            'email'      => 'Email',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAccount()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'user_id']);
    }

}