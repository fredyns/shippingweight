<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\base\Container as BaseContainer;
use app\models\Weighing;
use app\models\CertificateCounter;
use app\libraries\TPKS;

/**
 * This is the model class for table "container".
 *
 * @property \app\models\Weighing $weighing
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
            'booking_number'   => 'Booking Number',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWeighing()
    {
        return $this->hasOne(\app\models\Weighing::className(), ['container_id' => 'id'])->orderBy(['id' => SORT_DESC]);
    }

    public function checkVGM()
    {
        // init transaction
        $transaction = Yii::$app->db->beginTransaction();

        try
        {
            // tarik data
            $vgm      = TPKS::container($this->number);
            $verified = (ArrayHelper::getValue($vgm, 'IS_GROSS_VERIFIED') == 'Y');
            $vgmTime  = ArrayHelper::getValue($vgm, 'GROSS_VERIFIED_TIME');
            $inTime   = ArrayHelper::getValue($vgm, 'GATE_IN_TIME');
            $outTime  = ArrayHelper::getValue($vgm, 'GATE_OUT_TIME');
            $vgmDate  = ($vgmTime) ? date_create_from_format('d-m-Y H:i:s', $vgmTime) : null;
            $inDate   = ($inTime) ? date_create_from_format('d-m-Y H:i:s', $inTime) : null;
            $outDate  = ($outTime) ? date_create_from_format('d-m-Y H:i:s', $outTime) : null;

            // simpan data penimbangan
            $weighing = new Weighing([
                'container_number'   => $this->number,
                'container_id'       => $this->id,
                'grossmass'          => ArrayHelper::getValue($vgm, 'GROSS_KG'),
                'job_order'          => ArrayHelper::getValue($vgm, 'JOB_ORDER_NO'),
                'stack_datetime'     => ($vgmDate ? $vgmDate->format('Y-m-d H:i:s') : null),
                'gatein_datetime'    => ($inDate ? $inDate->format('Y-m-d H:i:s') : null),
                'gateout_datetime'   => ($outDate ? $outDate->format('Y-m-d H:i:s') : null),
                'emkl_id'            => ArrayHelper::getValue($vgm, 'CUSTOMER_ID'),
                'gatein_grossmass'   => ArrayHelper::getValue($vgm, 'WEIGHT_IN_KG'),
                'gateout_grossmass'  => ArrayHelper::getValue($vgm, 'WEIGHT_OUT_KG'),
                'gatein_tracknumber' => ArrayHelper::getValue($vgm, 'TRUCK_ID'),
            ]);
            $weighing->save(FALSE);

            // simpan hasil timbangan ke data kontainer
            $this->grossmass     = $weighing->grossmass;
            $this->weighing_date = ($vgmDate ? $vgmDate->format('Y-m-d H:i:s') : null);
            $this->checked_by    = Yii::$app->user->id;
            $this->checked_at    = time();

            if ($this->status == static::STATUS_READY && $verified)
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

            return $weighing->grossmass;
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

    public static function debt()
    {
        $start     = new \DateTime('2016-08-01 00:00:00');
        $datelimit = new \DateTime;

        $datelimit->modify('-7 days');
        $datelimit->setTime(0, 0, 0);

        $user_id    = Yii::$app->user->id;
        $stampstart = $start->getTimestamp();
        $stamplimit = $datelimit->getTimestamp();
        $timelimit  = $datelimit->format('Y-m-d H:i:s');
        $query      = new Query;


        $query
            ->select('count(*) quantity, min(created_at) created_min, max(created_at) created_max, min(weighing_date) weighing_min, max(weighing_date) weighing_max')
            ->from('container')
            ->andWhere(['transfer_id' => null])
            ->andWhere("(created_at <= {$stamplimit} OR weighing_date <= '{$timelimit}')")
            ->andWhere("(weighing_date >= '2016-08-01' OR (weighing_date is null and created_at >= {$stampstart}))");

        if (Yii::$app->user->identity->isAdmin == FALSE)
        {
            $query->andWhere(['created_by' => $user_id]);
        }

        return $query->createCommand()->queryOne();
    }

    public static function debtUntil($limit = '1 month ago 23:59')
    {
        $user_id    = Yii::$app->user->id;
        $timeOffset = '2016-08-01 00:00:00';
        $dtoLimit   = new \DateTime($limit);

        $timeLimit = $dtoLimit->format('Y-m-d H:i:s');
        $query     = new Query;

        // base query

        $query
            ->select([
                'quantity'     => 'count(*)',
                'weighing_min' => 'min(weighing_date)',
                'weighing_max' => 'max(weighing_date)',
            ])
            ->from('container')
            ->andWhere(['transfer_id' => null]);

        // user filter

        if (Yii::$app->user->identity->isAdmin == FALSE)
        {
            $query->andWhere(['created_by' => $user_id]);
        }

        // time offset

        $query->andWhere("weighing_date >= '{$timeOffset}'");

        // time limit

        $query->andWhere("weighing_date <= '{$timeLimit}'");

        // debt

        $debt = $query->createCommand()->queryOne();

        // olah data

        $weighing_min      = ArrayHelper::getValue($debt, 'weighing_min');
        $weighing_max      = ArrayHelper::getValue($debt, 'weighing_max');
        $debt['dtoVgmMin'] = ($weighing_min) ? date_create($weighing_min) : null;
        $debt['dtoVgmMax'] = ($weighing_max) ? date_create($weighing_max) : null;
        $debt['dayVgmMin'] = ($debt['dtoVgmMin']) ? $debt['dtoVgmMin']->format('d M') : null;
        $debt['dayVgmMax'] = ($debt['dtoVgmMax']) ? $debt['dtoVgmMax']->format('d M') : null;

        $url = [
            '/container',
            'ContainerSearch' => [
                'verified_at_range' => $debt['dtoVgmMin']->format('m/d/Y').' - '.$debt['dtoVgmMax']->format('m/d/Y'),
                'paid'              => 0,
            ],
        ];

        $debt['range'] = 'Terhitung  sejak '.$debt['dayVgmMin'].' hingga '.$debt['dayVgmMax'].'.<br/>'
            .Html::a('daftar kontainer', $url, ['target' => '_blank', 'title' => 'lihat container']).'<br/>';

        return $debt;
    }

}