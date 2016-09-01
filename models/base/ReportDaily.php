<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "reportDaily".
 *
 * @property string $day
 * @property integer $registerCount
 * @property integer $certificateCount
 * @property integer $paidCount
 * @property string $aliasModel
 */
abstract class ReportDaily extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reportDaily';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day'], 'required'],
            [['registerCount', 'certificateCount', 'paidCount'], 'integer'],
            [['day'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'day' => 'Day',
            'registerCount' => 'Register Count',
            'certificateCount' => 'Certificate Count',
            'paidCount' => 'Paid Count',
        ];
    }




}
