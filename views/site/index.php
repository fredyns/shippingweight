<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title    = 'BKIVGM.com';
$certificateUrl = Url::to(['/certificate/pdf-sample']);
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><b>BKI VGM</b></h1>

        <p class="lead">Verified Gross Mass oleh Biro Klasifikasi Indonesia</p>

        <?php
        if (Yii::$app->user->isGuest)
        {
            echo Html::a("Daftar Sekarang", ["/user/register"], ['class' => 'btn btn-lg btn-success']);
            echo ' &nbsp; ';
            echo Html::a("Masuk", ["/user/login"], ['class' => 'btn btn-lg btn-info']);
        }
        else
        {
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
        <b>Besok</b> adalah batas akhir pembayaran untuk layanan VGM periode tanggal 1 sampai 7 Agustus.
    </p>

    <p>
        Pembayaran kontainer melalui transfer ke rekening Mandiri nomor <b>135-00-57000059</b>
        (an. PT Biro Klasifikasi Indonesia - MP VGM).
    </p>

    <p>
        Bukti pembayaran dikirim ke <b>vgm.smc@gmail.com</b> beserta jumlah kontainer yang dibayar.
        Lampirkan juga alamat email/username yg digunakan untuk registrasi VGM
        (bila email yg digunakan berbeda).
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
                <h2>Verified Gross Mass</h2>

                <p>
                    Adalah pemberlakuan verifikasi berat kotor kontainer ekspor demi keamanan dan keselamatan.
                    Sebagaimana yang tertera pada Safety of Life at Sea (SOLAS) Convention.
                </p>

                <p>
                    Setiap kontainer akan diverifikasi massa aktualnya sebelum naik ke kapal.
                    Dengan VGM akan mempermudah pengaturan kontainer diatas kapal (stowage plan).
                    Sekaligus meningkatkan keamanan kapal.
                </p>

            </div>
            <div class="col-lg-4">
                <h2>Trial &amp; Peralihan</h2>

                <p>
                    Penerapan VGM akan dilakukan bertahap.
                    Selama belum diterapkan Sertifikasi VGM dari BKI,
                    maka proses loading barang akan menggunakan timbangan TPKS sebagai VGM.
                </p>

                <p>
                    <b>
                        Pada masa transisi proses loading kontainer akan dilakukan seperti biasa.
                    </b>
                    Pada saat kendaraan pengangkut keluar dari terminal akan dilakukan penimbangan
                    agar didapat massa kontainer aktual.
                </p>

                <p>
                    Selain itu akan dilakukan sosialisasi &amp; training kepada semua pihak sebelum penerapan VGM sepenuhnya.
                </p>


            </div>
            <div class="col-lg-4">
                <h2>Call Center</h2>

                <p>
                    Jika ada pertanyaan/permasalahan dapat menghubungi Call Center kami.

                <ul>
                    <li><b>(024) 7643-3240</b></li>
                    <li><b>0822-1111-2958 (sms/telp/wa)</b></li>
                    <li><b>0877-7750-3058 (sms/telp/wa)</b></li>
                    <li><b>vgm.smc@gmail.com</b></li>
                </ul>

                </p>

                <p>
                    Kantor Biro Klasifikasi Indonesia Cabang Semarang<br/>
                    Jl. Pamularsih No. 12 Semarang<br/>
                    (samping SD Al-Azhar)
                </p>

            </div>
        </div>

    </div>
</div>
