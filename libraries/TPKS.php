<?php

namespace app\libraries;

use Yii;
use DateTime;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnprocessableEntityHttpException;
use yii\base\UserException;

/**
 * Description of TPKS
 *
 * @author fredy
 */
class TPKS
{
    const URI_CONTAINERLIST = 'http://api.tpks.co.id/api/api/find_data_vgm_by_time';
    const URI_CONTAINER = 'http://api.tpks.co.id/api/api/find_data_vgm_by_container_no/container_no';
    const URI_CUSTOMERLIST = 'http://api.tpks.co.id/api/api/master_customer';
    const URI_CUSTOMER = 'http://api.tpks.co.id/api/api/find_customer/customer_id';

    /**
     * prepare uri parameters
     *
     * @param string $uri
     * @param array $params
     * @return string
     */
    static function composeUri($uri, $params = [])
    {
        $request = [];

        foreach ($params as $key => $value) {
            $request[] = $key.'='.$value;
        }

        return $uri.'?'.implode('&', $request);
    }

    /**
     * calling to TPKS server
     *
     * @param string $uri
     * @return array
     * @throws \Exception
     */
    public static function curl($uri)
    {
        $curl = curl_init();
        $credentials = Yii::$app->params['tpks_username'].':'.Yii::$app->params['tpks_password'];

        curl_setopt($curl, CURLOPT_URL, $uri);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_USERPWD, $credentials); //Your credentials goes here
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //IMP if the url has https and you don't want to verify source certificate

        $rawResponse = curl_exec($curl);

        curl_close($curl);

        if (empty($rawResponse)) {
            throw new ServerErrorHttpException('TPKS server is not responding.');
        }

        if (strpos($rawResponse, 'xml') !== FALSE) {
            $xml = simplexml_load_string($rawResponse);
            $response = json_encode($xml);
        } else {
            $response = json_decode($rawResponse, TRUE);
        }

        if (is_array($response) == FALSE) {
            if (Yii::$app->user->identity->isAdmin) {
                exit('<pre>'.print_r($rawResponse, TRUE).print_r($response, TRUE));
            }

            throw new UnprocessableEntityHttpException('Response error.');
        }

        if (isset($response['status']) == FALSE) {
            throw new UnprocessableEntityHttpException('Response format error.');
        }

        if ($response['status'] == FALSE) {
            $message = ArrayHelper::getValue($response, 'message', 'Data not found.');

            if ($message == 'Data tidak ditemukan') {
                $message = 'Petikemas belum masuk TPKS atau nomor salah.';
            } else {
                $message = 'TPKS: '.ArrayHelper::getValue($response, 'message', 'Data not found.');
            }

            throw new UserException($message);
        }

        return $response;
    }

    /**
     * extract named data
     *
     * @param string $uri
     * @param string $name
     * @param boolean $firstRow
     * @return array
     * @throws NotFoundHttpException
     */
    public static function getData($uri, $name, $firstRow = FALSE)
    {
        // eksekusi
        $response = static::curl($uri);

        // listing
        $list = ArrayHelper::getValue($response, $name);

        // cek listing
        if (empty($list) OR is_array($list) == FALSE) {
            throw new NotFoundHttpException(404, 'Data empty.');
        }

        // returning first row only
        if ($firstRow) {
            return array_shift($list);
        }

        // return all dataset
        return $list;
    }

    /**
     * search container weighing at time interval
     *
     * @param DateTime $from
     * @param DateTime $to
     * @return array
     */
    public static function containerList(DateTime $from, DateTime $to)
    {
        // parameter
        $param = [
            'time_from' => $from->format('YmdHi'),
            'time_to' => $to->format('YmdHi'),
        ];
        $uri = static::composeUri(static::URI_CONTAINERLIST, $param);

        // get all containers
        return static::getData($uri, 'data_vgm');
    }

    /**
     * search by container number
     *
     * @param string $number
     * @return array
     */
    public static function container($number)
    {
        // alamat API
        $number = trim($number);
        $uri = static::URI_CONTAINER.'/'.$number.'?hit='.time();

        // get container
        return static::getData($uri, 'data_vgm', TRUE);
    }

    /**
     * get all customer data
     *
     * @return array
     */
    public static function customerList()
    {
        // get all customers
        return static::getData(static::URI_CUSTOMERLIST, 'data_customer');
    }

    /**
     * get customer's data by its ID
     *
     * @param string $id
     * @return array
     */
    public static function customer($id)
    {
        // alamat API
        $uri = static::URI_CUSTOMER.'/'.$id;

        // get container
        return static::getData($uri, 'data_customer', TRUE);
    }

    /**
     * search gate in receiving at time interval
     *
     * @param DateTime $from
     * @param DateTime $to
     * @return array
     */
    public static function gateIn(DateTime $from, DateTime $to)
    {
        // parameter
        $uri = 'http://api.tpks.co.id/api/api/find_data_vgm_by_gate_in_time/time_from/'.$from->format('YmdHi').'/time_to/'.$to->format('YmdHi');

        // get all containers
        return static::getData($uri, 'data_vgm');
    }
}