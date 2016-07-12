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

        <p class="lead">Verified Gross Mass oleh Badan Klasifikasi Indonesia</p>

    </div>

    <form action="<?= $certificateUrl ?>" method="get">
        <div class="row">
            <div class="col-lg-6 col-md-offset-3">
                <div class="input-group">
                    <input name="container_number" type="text" class="form-control input-lg" placeholder="isikan nomor container">
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-lg" type="submit">
                            <span class="glyphicon glyphicon-scale"></span> Check
                        </button>
                    </span>
                </div><!-- /input-group -->
                <div style="text-align: center; color: gray; ">
                    <i> masa uji coba</i>
                </div>
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
    </form>

    <br/>
    <br/>
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
                <h2>Penerapan</h2>

                <p>
                    <b>Kedepan</b>,
                    proses VGM akan diakomodasi melalui portal ini.
                    Mulai dari pendataan kontainer hingga akses cetak sertifikat secara online.
                    Dengan tidak mengubah proses yang telah berjalan di TPKS.
                </p>

            </div>
        </div>

    </div>
</div>
