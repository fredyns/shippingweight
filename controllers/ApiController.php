<?php

namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use app\models\Container;
use app\models\Weighing;
use app\models\CertificateCounter;

/**
 * Description of ApiController
 *
 * @author Fredy Nurman Saleh <email@fredyns.net>
 */
class ApiController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionVerify($container_number = null, $job_order = null, $grossmass = null, $verified_time = null,
                                 $gatein = null, $gateout = null, $token = null)
    {
        // setup

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $response = [
            'status'  => null,
            'message' => null,
        ];

        // security parameter

        if (empty($container_number) OR empty($job_order) OR empty($token))
        {
            $response['status']  = FALSE;
            $response['message'] = 'Parameter invalid.';

            return $response;
        }

        $croscheck = md5($container_number.'/'.$job_order);

        if ($croscheck != $token)
        {
            $response['status']  = FALSE;
            $response['message'] = 'Token invalid.';

            return $response;
        }

        // check parameter

        if (empty($container_number) OR empty($grossmass))
        {
            $response['status']  = FALSE;
            $response['message'] = 'Parameter kontainer dan grossmass harus diisi.';

            return $response;
        }

        // vars

        $submission = [
            'container_number'  => $container_number,
            'grossmass'         => $grossmass,
            'job_order'         => $job_order,
            'stack_datetime'    => $verified_time,
            'gatein_grossmass'  => $gatein,
            'gateout_grossmass' => $gateout,
        ];

        // find container

        $container = Container::find()
            ->where(['container_number' => $container_number, 'status' => [Container::STATUS_REGISTERED, Container::STATUS_READY]])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        if (empty($container))
        {
            $response['status']  = FALSE;
            $response['message'] = 'Kontainer tidak ditemukan.';

            return $response;
        }

        // save weighing

        $weighing = new Weighing($submission);

        $weighing->container_id = $container->id;

        if (!$weighing->save())
        {
            $response['status']  = FALSE;
            $response['message'] = $weighing->getErrors();

            return $response;
        }

        // put weighing result into container

        $container->grossmass            = $weighing->grossmass;
        $container->weighing_date        = $weighing->stack_datetime;
        $container->checked_by           = 0;
        $container->checked_at           = time();
        $container->status               = static::STATUS_VERIFIED;
        $container->certificate_sequence = CertificateCounter::newSequence();
        $container->certificate_number   = CertificateCounter::newNumber($container->certificate_sequence);
        $container->verified_by          = 0;
        $container->verified_at          = time();

        $container->save(FALSE);

        // result

        $response['status']      = TRUE;
        $response['certificate'] = [
            'number'           => $container->certificate_sequence,
            'serial'           => $container->certificate_number,
            'container_number' => $container->container_number,
            'grossmass'        => $container->grossmass,
            'pic'              => 'Yohanis',
        ];

        return $response;
    }

    public function actionCertification($token = null, $containers = null)
    {
        // setup
        $token                       = Yii::$app->request->post('token');
        $containers                  = Yii::$app->request->post('containers');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $response = [
            'status'   => null,
            'messages' => [],
        ];

        // pepare params

        try
        {
            $containers = $this->prepareParams($token, $containers);
        }
        catch (Exception $exc)
        {
            $response['status']     = FALSE;
            $response['messages'][] = $exc->getTraceAsString();

            return $response;
        }

        // check parameter

        if (empty($containers))
        {
            $response['status']     = FALSE;
            $response['messages'][] = 'Parameter empty.';

            return $response;
        }

        // parse weighings

        $freshContainers    = $this->parseWeighing($containers);
        $archivedContainers = $this->searchContainers($containers);

        $response['status'] = TRUE;
        $response['vgm']    = $this->certificationList($freshContainers, $archivedContainers);

        return $response;
    }

    /**
     * check token & prepare parameters
     *
     * @param string $token
     * @param string $containers
     * @return array
     * @throws ForbiddenHttpException
     */
    public function prepareParams($token, $containers)
    {
        $today  = date('Y-m-d');
        $secret = md5($today);

        if ($token != $secret)
        {
            throw new ForbiddenHttpException('Token invalid.');
        }

        if (is_array($containers))
        {
            return $containers;
        }

        $json = json_decode($containers, TRUE);

        if ($json)
        {
            return $json;
        }

        if (is_string($containers))
        {
            return [trim($containers)];
        }

        return [];
    }

    public function parseWeighing($params)
    {
        $weighingFeeds = array_filter($params, 'is_array');

        if (empty($weighingFeeds))
        {
            return [];
        }

        $containerNumbers = array_keys($weighingFeeds);
        $containers       = Container::find()
            ->where(['number' => $containerNumbers])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        if (empty($containers))
        {
            return [];
        }

        foreach ($containers as $container)
        {
            $weighingFeed = ArrayHelper::getValue($weighingFeeds, $container->number);

            if (empty($weighingFeed)OR is_array($weighingFeed) == FALSE)
            {
                continue;
            }

            $verified = (ArrayHelper::getValue($weighingFeed, 'IS_GROSS_VERIFIED') == 'Y');
            $vgmTime  = ArrayHelper::getValue($weighingFeed, 'GROSS_VERIFIED_TIME');
            $vgmDate  = ($vgmTime) ? date_create_from_format('d-m-Y H:i:s', $vgmTime) : null;

            // simpan data penimbangan
            $weighing = new Weighing([
                'container_number'   => $container->number,
                'container_id'       => $container->id,
                'grossmass'          => ArrayHelper::getValue($weighingFeed, 'GROSS_KG'),
                'job_order'          => ArrayHelper::getValue($weighingFeed, 'JOB_ORDER_NO'),
                'stack_datetime'     => ($vgmDate ? $vgmDate->format('Y-m-d H:i:s') : null),
                'emkl_id'            => ArrayHelper::getValue($weighingFeed, 'CUSTOMER_ID'),
                'gatein_grossmass'   => ArrayHelper::getValue($weighingFeed, 'WEIGHT_IN_KG'),
                'gateout_grossmass'  => ArrayHelper::getValue($weighingFeed, 'WEIGHT_OUT_KG'),
                'gatein_tracknumber' => ArrayHelper::getValue($weighingFeed, 'TRUCK_ID'),
            ]);
            $weighing->save(FALSE);

            // simpan hasil timbangan ke data kontainer

            $container->grossmass     = $weighing->grossmass;
            $container->weighing_date = ($vgmDate ? $vgmDate->format('Y-m-d H:i:s') : null);
            $container->checked_by    = 0;
            $container->checked_at    = time();

            if ($container->status == Container::STATUS_READY && $verified)
            {
                $container->status               = Container::STATUS_VERIFIED;
                $container->certificate_sequence = CertificateCounter::newSequence();
                $container->certificate_number   = CertificateCounter::newNumber($container->certificate_sequence);
                $container->verified_by          = 0;
                $container->verified_at          = time();
            }

            $container->save(FALSE);
        }

        return $containers;
    }

    public function searchContainers($containers)
    {
        $containers = array_filter($containers, 'is_string');

        if (empty($containers))
        {
            return [];
        }

        return Container::find()
                ->where(['number' => $containers, 'status' => Container::STATUS_VERIFIED])
                ->orderBy(['id' => SORT_DESC])
                ->all();
    }

    public function certificationList($freshContainers, $archivedContainers)
    {
        $certificates = [];

        if ($freshContainers)
        {
            foreach ($freshContainers as $container)
            {
                $certificates[$container->number] = [
                    'number'             => $container->number,
                    'grossmass'          => $container->grossmass,
                    'vgm_date'           => $container->weighing_date,
                    'certificate_number' => $container->certificate_number,
                    'payment'            => ($container->transfer_id > 0) ? 'settled' : 'debt',
                ];
            }
        }

        if ($archivedContainers)
        {
            foreach ($archivedContainers as $container)
            {
                $certificates[$container->number] = [
                    'number'             => $container->number,
                    'grossmass'          => $container->grossmass,
                    'vgm_date'           => $container->weighing_date,
                    'certificate_number' => $container->certificate_number,
                    'payment'            => ($container->transfer_id > 0) ? 'settled' : 'debt',
                ];
            }
        }

        return $certificates;
    }

}