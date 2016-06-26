<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use dosamigos\qrcode\QrCode;

class CertificateController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $xml = <<< XML
<xml>
<status>1</status>
<jumlah_item>30</jumlah_item>
<data_container>
<item>
<NOMOR_CONTAINER>KKFU7775322</NOMOR_CONTAINER>
<WAKTU_STACK>05-12-2014 22:43:56</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>567 hari</DWELLING_TIME>
<GROSS>28.5</GROSS>
<LENGTH>40</LENGTH>
<HEIGHT>9.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>SINAR KARUNIA MULIA T.PT</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>TCNU8556809</NOMOR_CONTAINER>
<WAKTU_STACK>05-12-2014 22:43:56</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>567 hari</DWELLING_TIME>
<GROSS>28.5</GROSS>
<LENGTH>40</LENGTH>
<HEIGHT>9.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>SINAR KARUNIA MULIA T.PT</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>TCNU9173640</NOMOR_CONTAINER>
<WAKTU_STACK>05-12-2014 22:43:56</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>567 hari</DWELLING_TIME>
<GROSS>28.5</GROSS>
<LENGTH>40</LENGTH>
<HEIGHT>9.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>SINAR KARUNIA MULIA T.PT</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>MRLU2105232</NOMOR_CONTAINER>
<WAKTU_STACK>30-11-2014 20:59:06</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>573 hari</DWELLING_TIME>
<GROSS>25</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>Belum ada pengurusan</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>MRTU2105232</NOMOR_CONTAINER>
<WAKTU_STACK>30-11-2014 20:17:41</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>573 hari</DWELLING_TIME>
<GROSS>25</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>Belum ada pengurusan</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>MRLU2363650</NOMOR_CONTAINER>
<WAKTU_STACK>30-11-2014 20:17:01</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>573 hari</DWELLING_TIME>
<GROSS>25</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>Belum ada pengurusan</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>GESU2203573</NOMOR_CONTAINER>
<WAKTU_STACK>30-11-2014 20:16:28</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>573 hari</DWELLING_TIME>
<GROSS>25</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>Belum ada pengurusan</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>CRXU3401577</NOMOR_CONTAINER>
<WAKTU_STACK>30-11-2014 20:15:55</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>573 hari</DWELLING_TIME>
<GROSS>25</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>Belum ada pengurusan</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>CRXU3187629</NOMOR_CONTAINER>
<WAKTU_STACK>30-11-2014 20:15:19</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>573 hari</DWELLING_TIME>
<GROSS>25</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>Belum ada pengurusan</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>CRXU3005914</NOMOR_CONTAINER>
<WAKTU_STACK>30-11-2014 20:14:35</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>573 hari</DWELLING_TIME>
<GROSS>25</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>Belum ada pengurusan</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>APZU3194280</NOMOR_CONTAINER>
<WAKTU_STACK>06-09-2013 16:21:00</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1023 hari</DWELLING_TIME>
<GROSS>24</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>Belum ada pengurusan</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>TPKS2013</NOMOR_CONTAINER>
<WAKTU_STACK>22-06-2013 10:24:50</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1099 hari</DWELLING_TIME>
<GROSS>8</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>Belum ada pengurusan</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>GATU84791120</NOMOR_CONTAINER>
<WAKTU_STACK>12-10-2012 15:49:18</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1352 hari</DWELLING_TIME>
<GROSS>20</GROSS>
<LENGTH>40</LENGTH>
<HEIGHT>9.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>Belum ada pengurusan</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>TEXU5175417</NOMOR_CONTAINER>
<WAKTU_STACK>12-10-2012 15:44:26</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1352 hari</DWELLING_TIME>
<GROSS>20</GROSS>
<LENGTH>40</LENGTH>
<HEIGHT>9.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>Belum ada pengurusan</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>HLXU4361256</NOMOR_CONTAINER>
<WAKTU_STACK>12-10-2012 15:35:35</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1352 hari</DWELLING_TIME>
<GROSS>20</GROSS>
<LENGTH>40</LENGTH>
<HEIGHT>9.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>Belum ada pengurusan</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>MCLU2882540</NOMOR_CONTAINER>
<WAKTU_STACK>12-10-2012 15:32:47</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1352 hari</DWELLING_TIME>
<GROSS>10</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>Belum ada pengurusan</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>TRLU2144616</NOMOR_CONTAINER>
<WAKTU_STACK>12-10-2012 15:14:01</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1352 hari</DWELLING_TIME>
<GROSS>10</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>Belum ada pengurusan</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>CMUU4603120</NOMOR_CONTAINER>
<WAKTU_STACK>04-05-2012 13:41:22</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1513 hari</DWELLING_TIME>
<GROSS>15</GROSS>
<LENGTH>40</LENGTH>
<HEIGHT>8.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>PATAYA RAYA, PT</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>GSTU8698254</NOMOR_CONTAINER>
<WAKTU_STACK>04-05-2012 13:40:31</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1513 hari</DWELLING_TIME>
<GROSS>15</GROSS>
<LENGTH>40</LENGTH>
<HEIGHT>8.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>PATAYA RAYA, PT</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>CRXU3131342</NOMOR_CONTAINER>
<WAKTU_STACK>28-01-2012 22:48:00</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1609 hari</DWELLING_TIME>
<GROSS>25.3</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>DHANA PERSADA MANUNGGAL, PT</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>CMAU0270675</NOMOR_CONTAINER>
<WAKTU_STACK>28-01-2012 22:48:00</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1609 hari</DWELLING_TIME>
<GROSS>25.3</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>DHANA PERSADA MANUNGGAL, PT</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>FCIU3735030</NOMOR_CONTAINER>
<WAKTU_STACK>28-01-2012 22:48:00</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1609 hari</DWELLING_TIME>
<GROSS>25.4</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>DHANA PERSADA MANUNGGAL, PT</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>TGHU0306195</NOMOR_CONTAINER>
<WAKTU_STACK>28-01-2012 22:48:00</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1609 hari</DWELLING_TIME>
<GROSS>26.4</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>DHANA PERSADA MANUNGGAL, PT</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>TGHU3539668</NOMOR_CONTAINER>
<WAKTU_STACK>28-01-2012 22:48:00</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1609 hari</DWELLING_TIME>
<GROSS>28</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>DHANA PERSADA MANUNGGAL, PT</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>FCIU2971962</NOMOR_CONTAINER>
<WAKTU_STACK>28-01-2012 22:48:00</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1609 hari</DWELLING_TIME>
<GROSS>24.5</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>DHANA PERSADA MANUNGGAL, PT</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>CMAU2083971</NOMOR_CONTAINER>
<WAKTU_STACK>28-01-2012 22:48:00</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1609 hari</DWELLING_TIME>
<GROSS>24.5</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>DHANA PERSADA MANUNGGAL, PT</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>ECMU1843394</NOMOR_CONTAINER>
<WAKTU_STACK>28-01-2012 22:48:00</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1609 hari</DWELLING_TIME>
<GROSS>22.7</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>DHANA PERSADA MANUNGGAL, PT</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>DVRU1560281</NOMOR_CONTAINER>
<WAKTU_STACK>28-01-2012 22:48:00</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1609 hari</DWELLING_TIME>
<GROSS>24.1</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>DHANA PERSADA MANUNGGAL, PT</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>TCKU2713660</NOMOR_CONTAINER>
<WAKTU_STACK>28-01-2012 22:48:00</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1609 hari</DWELLING_TIME>
<GROSS>25.6</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>DHANA PERSADA MANUNGGAL, PT</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
<item>
<NOMOR_CONTAINER>CRXU3430600</NOMOR_CONTAINER>
<WAKTU_STACK>28-01-2012 22:48:00</WAKTU_STACK>
<WAKTU_DOWNLOAD_DATA>24-06-2016 21:05:05</WAKTU_DOWNLOAD_DATA>
<DWELLING_TIME>1609 hari</DWELLING_TIME>
<GROSS>22</GROSS>
<LENGTH>20</LENGTH>
<HEIGHT>8.6</HEIGHT>
<STATUS>FCL</STATUS>
<PEMILIK_BARANG>DHANA PERSADA MANUNGGAL, PT</PEMILIK_BARANG>
<ITEM_CLASS>I</ITEM_CLASS>
</item>
</data_container>
</xml>
XML;
        $xml = simplexml_load_string($xml);
        return '<pre><img src="'.Url::to(['certificate/qrcode']).'" />'.print_r($xml, TRUE).'</pre>';
    }

    public function actionQrcode()
    {
        header('Content-Type: image/png');
        return QrCode::png("http://fredyns.net/");
    }

}