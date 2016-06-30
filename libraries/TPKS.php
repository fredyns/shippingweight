<?php

namespace app\libraries;

use yii\helpers\ArrayHelper;
use yii\web\HttpException;

/**
 * Description of TPKS
 *
 * @author fredy
 */
class TPKS
{
    const URI_CONTAINERLIST = 'http://api.tpks.co.id/api/api/container_data_ksop_xml';
    const URI_CONTAINER     = 'http://api.tpks.co.id/api/api/detail_petikemas/container_no';
    const URI_EMKL          = 'http://api.tpks.co.id/api/api/emkl'; // belum ada

    static function composeUri($uri, $params = [])
    {
        $request = [];

        foreach ($params as $key => $value)
        {
            $request[] = $key.'='.$value;
        }

        return $uri.'?'.implode('&', $request);
    }

    static function curlExec($uri)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $uri);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        if (empty($result))
        {
            throw new HttpException(404, 'Weighing server is not responding.');
        }

        if (strpos($result, 'xml') !== FALSE)
        {
            $xml    = simplexml_load_string($result);
            $result = json_encode($xml);
        }

        $result = json_decode($result, TRUE);

        if (is_array($result) == FALSE)
        {
            throw new HttpException(404, 'Response error.');
        }

        if (isset($result['status']) == FALSE)
        {
            throw new HttpException(404, 'Response format error.');
        }

        return $result;
    }

    static function container($number)
    {
        // alamat API
        $uri = static::URI_CONTAINER.'/'.$number;

        // eksekusi
        $response = static::curlExec($uri);

        // cek status
        if ($response['status'] == 0)
        {
            $message = ArrayHelper::getValue($response, 'msg', 'Data not found.');

            throw new HttpException(404, $message);
        }

        // listing
        $list = ArrayHelper::getValue($response, 'data_last_detail_container');

        // cek listing
        if (!$list OR is_array($list) == FALSE OR count($list) == 0)
        {
            throw new HttpException(404, 'Data empty.');
        }

        // ambil data container yg dimaksud
        $container = array_shift($list);

        // hasil
        return $container;
    }

}