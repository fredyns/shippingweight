<?php

namespace app\controllers;

use DateTime;
use Yii;
use yii\helpers\ArrayHelper;
use app\models\Container;
use app\models\Weighing;
use app\models\CertificateCounter;
use app\libraries\TPKS;

/**
 * Description of TpksController
 *
 * @author Fredy Nurman Saleh <email@fredyns.net>
 */
class TpksController extends \app\controllers\base\ContainerController
{

    public function actionReceiving($from = null, $to = null)
    {
        // init var

        date_default_timezone_set("Asia/Jakarta");

        // format: Y-m-d H:i

        $now         = new DateTime();
        $minute      = $now->format('i');
        $modMinute   = $minute % 5;
        $autorefresh = (empty($from) && empty($to));

        if ($modMinute > 0)
        {
            $now->modify("+".(5 - $modMinute)." minutes");
        }

        if (empty($from) == FALSE)
        {
            $from = new DateTime($from);
        }

        if (empty($to) == FALSE)
        {
            $to = new DateTime($to);
        }

        // default value from

        if (empty($from))
        {
            $from = clone $now;

            $from->modify('-4 hours');
        }

        // default value to

        if (empty($to))
        {
            $to = clone $now;

            //$to->modify('-1 hour');
        }

        // ensure not overlaping

        if ($from > $to)
        {
            $dto_tmp = clone $to;
            $to      = clone $from;
            $from    = clone $dto_tmp;
        }

        // ensure not more than 1 day

        $max_to = clone $from;
        $max_to->modify('+1 day');

        if ($to > $max_to)
        {
            $to = $max_to;
        }

        try
        {
            // gate in data

            $containers = $this->gateInData($from, $to);
            $error      = null;

            // certify

            $this->parseGatein($containers);
        }
        catch (\Exception $e)
        {
            $containers = [];
            $error      = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
        }

        // view

        return $this->render('receiving',
                [
                'now'         => $now,
                'from'        => $from,
                'to'          => $to,
                'containers'  => $containers,
                'autorefresh' => $autorefresh,
                'error'       => $error,
        ]);
    }

    public function gateInData($from, $to)
    {
        $feeds      = TPKS::gateIn($from, $to);
        $containers = [];

        foreach ($feeds as $feed)
        {
            $containerNumber = ArrayHelper::getValue($feed, 'CONTAINER_NO');
            $containerNumber = trim($containerNumber);

            if ($containerNumber)
            {
                $containers[$containerNumber] = $feed;
            }
        }

        return $containers;
    }

    public function parseGatein(&$feeds)
    {
        $containerNumbers = array_keys($feeds);
        $containers       = Container::findAll(['number' => $containerNumbers]);

        foreach ($containers as $container)
        {
            $number                         = $container->number;
            $feeds[$number]['container']    = $container;
            $feeds[$number]['containers'][] = $container;
            $verified                       = (ArrayHelper::getValue($feeds[$number], 'IS_GROSS_VERIFIED') == 'Y');

            // olah

            if ($container->status == Container::STATUS_READY && $verified)
            {
                $this->parseWeighing($container, $feeds[$number]);

                $feeds[$number]['parsed'] = TRUE;
            }
            else
            {
                $feeds[$number]['parsed'] = FALSE;
            }
        }
    }

    public function parseWeighing($container, $vgm)
    {
        $vgmTime = ArrayHelper::getValue($vgm, 'GROSS_VERIFIED_TIME');
        $inTime  = ArrayHelper::getValue($vgm, 'GATE_IN_TIME');
        $outTime = ArrayHelper::getValue($vgm, 'GATE_OUT_TIME');
        $vgmDate = ($vgmTime) ? date_create_from_format('d-m-Y H:i:s', $vgmTime) : null;
        $inDate  = ($inTime) ? date_create_from_format('d-m-Y H:i:s', $inTime) : null;
        $outDate = ($outTime) ? date_create_from_format('d-m-Y H:i:s', $outTime) : null;

        // simpan data penimbangan
        $weighing = new Weighing([
            'container_number'   => $container->number,
            'container_id'       => $container->id,
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
        $container->grossmass     = $weighing->grossmass;
        $container->weighing_date = ($vgmDate ? $vgmDate->format('Y-m-d H:i:s') : null);
        $container->checked_by    = Yii::$app->user->id;
        $container->checked_at    = time();

        $container->status               = Container::STATUS_VERIFIED;
        $container->certificate_sequence = CertificateCounter::newSequence();
        $container->certificate_number   = CertificateCounter::newNumber($container->certificate_sequence);
        $container->verified_by          = Yii::$app->user->id;
        $container->verified_at          = time();

        $container->save(FALSE);
    }

}