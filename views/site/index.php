<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'BKIVGM.com';
$certificateUrl = Url::to(['/certificate/pdf-sample']);
?>
<style>
    p {
        text-align: justify;
    }
</style>
<div class="site-index">

    <div class="row">

        <div class="col-lg-4 pull-right">
            <b>Callcenter:</b>
            <ul>
                <li><b>(024) 7643-3240</b></li>
                <li><b>0822-1111-2958 (sms/telp/wa)</b></li>
                <li><b>0877-7750-3058 (sms/telp/wa)</b></li>
                <li><b>vgm.smc@gmail.com</b></li>
            </ul>

        </div>
        <div class="col-lg-4 pull-left">
            <?php
            if (Yii::$app->user->isGuest == FALSE) {
                echo $this->render('@app/views/widget/debt_alert');
            }
            ?>
        </div>
    </div>

    <div class="jumbotron">
        <h1><b>BKI VGM</b></h1>

        <p class="lead" style="text-align: center;">Verified Gross Mass oleh Biro Klasifikasi Indonesia</p>

        <?php
        if (Yii::$app->user->isGuest) {
            echo Html::a("Daftar Sekarang", ["/user/register"], ['class' => 'btn btn-lg btn-success']);
            echo ' &nbsp; ';
            echo Html::a("Masuk", ["/user/login"], ['class' => 'btn btn-lg btn-info']);
        } else {
            echo Html::a("Container Baru", ["/container/create"], ['class' => 'btn btn-lg btn-success']);
            echo ' &nbsp; ';
            echo Html::a("Semua Container", ["/container/index"], ['class' => 'btn btn-lg btn-info']);
        }
        ?>
    </div>

    <br/>
    <br/>

    <p>
        <b>Pengumuman</b>
    </p>

    <p>
        Pembayaran kontainer melalui transfer ke rekening Mandiri nomor <b>135-00-57000059</b>
        (an. PT Biro Klasifikasi Indonesia - MP VGM).
    </p>

    <p>
        Bukti pembayaran dikirim ke <b>vgm.smc@gmail.com</b> beserta file (excel) rekap kontainer yang dibayar.
        File rekap tersebut dapat didownload pada menu container dengan mengeklik tombol "export".
    </p>

    <p>
        Rekap pembayaran akan dilakukan tiap minggu dengan masa tenggang 3 hari.
        Bagi Customer yang tidak melakukan pembayaran atas kontainer yang didaftarakan
        akan dilakukan pem<b>blokir</b>an dari sistem BKI VGM.
    </p>

    <br/>
    <br/>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Container Belum VGM?</h2>

                <p>
                    Umumnya terjadi karena
                    Truk <b>melewatkan</b> proses <b>penimbangan</b> di <b>Gate-Out</b>.
                    Cek juga data Container di web TPKS, menu "Container Search", apakah statusnya sudah VGM.
                    Jika statusnya sudah VGM maka sudah dapat diterbitkan sertifikat VGM.
                </p>

                <P>
                    Konfirmasi ke sopir truk apakah dia sudah menjalani penimbangan di Gate-Out.
                    Bila timbangan Gate-out masih kosong berarti Truk harus kembali ke Gate-Out untuk
                    <b>ditimbang ulang</b>.
                </P>

                <p>
                    Untuk Fumigasi / Karantina Export yang containernya diangkut oleh truk Kuda Inti
                    dapat menghubungi BKI atau TPKS bila setelah 1 jam masuk CY status container belum VGM.
                </p>

            </div>
            <div class="col-lg-4">
                <h2>Penimbangan Gate-Out</h2>

                <p>
                    Di Gate-Out, operator melakukan input data <b>nomor polisi</b> truk
                    & hasil <b>timbangan</b>.
                    Untuk proses penimbangan (ulang) di Gate-out dapat menggunakan Gate-Ticket
                    atau menggunakan <b>nomor polisi</b> truk
                    (bisa ditulis di kertas sebagai pengganti Gate-Ticket).
                </p>

                <p>
                    Khusus truk Kuda Inti, yang diinput adalah <b>nomor lambung</b>, bukan nomor polisi.
                </p>

            </div>
            <div class="col-lg-4">
                <h2>Container ditolak?</h2>

                <p>
                    <b>BKI tidak</b> dapat <b>memutuskan</b> suatu container akan naik atau ditolak oleh pihak pelayaran.
                    Layanan VGM ini hanya bertujuan mendapatkan timbangan aktual
                    sebelum container dikirimkan pihak pelayaran.
                </p>

                <p>
                    Container dapat ditolak oleh pihak pelayaran bila <b>melebihi</b> batas <b>Payload</b>
                    yang tertera di masing-masing container.
                    Beberapa pelayaran sangat teliti dengan hal ini, bahkan selisih beberapa kwintal dapat menyebabkan
                    container ditolak.
                </p>

                <p>
                    Maka dari itu dihimbau untuk semua exportir untuk memperhatikan bobot container secara keseluruhan.
                    Termasuk berat netto cargo serta alat pengaman lainnya yang masuk ke dalam container.
                </p>
                <p>
                    Disarankan agar tidak stuffing container hingga penuh, mendekati batas payload.
                    Sisakan beban sekitar 1 ton dari batas payload container.
                    Sehingga container tidak ditolak pelayaran hanya karna selisih beberapa kwintal saja.

                </p>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <h2>Container Payload</h2>

                <p>
                    Perhatikan spesifikasi di masing-masing kontainer.
                </p>

                <image src="http://bkivgm.com/image/container-payload.jpg"/>

            </div>
        </div>

    </div>
</div>
