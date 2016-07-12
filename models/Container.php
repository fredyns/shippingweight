<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\base\Container as BaseContainer;
use app\models\Weighing;
use app\models\CertificateCounter;
use app\libraries\TPKS;

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
            'number'           => 'Container Number',
            'booking_number'   => 'Job Order',
            'status'           => 'Status',
            'bill'             => 'Bill',
            'grossmass'        => 'Grossmass',
            'weighing_date'    => 'Weighing Date',
            'certificate_file' => 'Certificate File',
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

    public function checkVGM()
    {
        // init transaction
        $transaction = Yii::$app->db->beginTransaction();

        try
        {
            // tarik data
            $vgm     = TPKS::container($this->number);
            $vgmTime = ArrayHelper::getValue($vgm, 'GROSS_VERIFIED_TIME');
            $vgmDate = ($vgmTime) ? date_create_from_format('d-m-Y H:i:s', $vgmTime) : null;

            // simpan data penimbangan
            $weighing = new Weighing([
                'container_number'  => $this->number,
                'container_id'      => $this->id,
                'grossmass'         => ArrayHelper::getValue($vgm, 'GROSS_KG'),
                'job_order'         => ArrayHelper::getValue($vgm, 'JOB_ORDER_NO'),
                'stack_datetime'    => ($vgmDate ? $vgmDate->format('Y-m-d H:i:s') : null),
                'emkl_id'           => ArrayHelper::getValue($vgm, 'CUSTOMER_ID'),
                'gatein_grossmass'  => ArrayHelper::getValue($vgm, 'WEIGHT_IN_KG'),
                'gateout_grossmass' => ArrayHelper::getValue($vgm, 'WEIGHT_OUT_KG'),
            ]);
            $weighing->save(FALSE);

            // simpan hasil timbangan ke data kontainer
            $this->grossmass     = $weighing->grossmass;
            $this->weighing_date = ($vgmDate ? $vgmDate->format('Y-m-d') : null);
            $this->checked_by    = Yii::$app->user->id;
            $this->checked_at    = time();

            if ($this->status == static::STATUS_READY)
            {
                $this->status               = static::STATUS_VERIFIED;
                $this->certificate_sequence = CertificateCounter::newSequence();
                $this->certificate_number   = CertificateCounter::newNumber($this->certificate_sequence);
                $this->verified_by          = Yii::$app->user->id;
                $this->verified_at          = time();
            }

            $this->save(FALSE);

            // commit data processing
            $transaction->commit();

            return TRUE;
        }
        catch (\Exception $e)
        {
            // cancel all processed data
            $transaction->rollback();

            $this->checked_by = Yii::$app->user->id;
            $this->checked_at = time();

            $this->save(FALSE);

            return FALSE;
        }
    }

}