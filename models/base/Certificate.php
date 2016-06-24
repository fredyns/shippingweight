<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "certificate".
 *
 * @property integer $id
 * @property string $vgm_number
 * @property string $vgm_date
 * @property double $vgm_gross
 * @property string $container_number
 * @property string $booking_number
 * @property string $shipper_name
 * @property string $shipper_address
 * @property string $stack_at
 * @property string $download_at
 * @property integer $dwelling_time
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $aliasModel
 */
abstract class Certificate extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'certificate';
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vgm_number', 'container_number'], 'required'],
            [['vgm_date', 'stack_at', 'download_at'], 'safe'],
            [['vgm_gross'], 'number'],
            [['shipper_address'], 'string'],
            [['dwelling_time'], 'integer'],
            [['vgm_number', 'container_number', 'booking_number', 'shipper_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vgm_number' => 'Vgm Number',
            'vgm_date' => 'Vgm Date',
            'vgm_gross' => 'Vgm Gross',
            'container_number' => 'Container Number',
            'booking_number' => 'Booking Number',
            'shipper_name' => 'Shipper Name',
            'shipper_address' => 'Shipper Address',
            'stack_at' => 'Stack At',
            'download_at' => 'Download At',
            'dwelling_time' => 'Dwelling Time',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }




}
