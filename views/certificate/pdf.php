<?php

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Certificate;

$headerImageUrl = Url::to(['/image/bki-logo-sm.jpg']);
?>

<div id="page-1">

    <div id="qrcode">
        <img src="<?= $model->qrUrl; ?>" width="135px"/>
    </div>

    <div class="header">

        <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td>
                    <img id="header-logo" src="<?= $headerImageUrl; ?>" width="40px"/>
                </td>
                <td>
                    <div id="header-title" style="">
                        PT. BIRO KLASIFIKASI INDONESIA (Persero)
                    </div>
                </td>
            </tr>
        </table>

    </div>

    <div class="body">

        <br/>
        <br/>

        <div id="title">
            DECLARATION OF WEIGHT
        </div>
        <div id="certificate_number">
            <?= ($model->status == Certificate::STATUS_VERIFIED) ? $model->certificate_number : '<i>Pending</i>'; ?>
        </div>

        <br/>
        <br/>

        <div id="detail">

            <table border="0" cellspacing="5" cellpadding="3">
                <tr>
                    <td>
                        Booking Number
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        <?= $model->booking_number; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Container Number
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        <b><?= $model->number; ?></b>
                    </td>
                </tr>
                <tr>
                    <td>
                        Port of Loading
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        Terminal Petikemas Semarang, Indonesia
                    </td>
                </tr>
                <tr>
                    <td>
                        Weight Calculation
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        Method 2
                    </td>
                </tr>
                <tr>
                    <td>
                        Verified Gross Weight
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        <?php
                        if ($model->status == Certificate::STATUS_VERIFIED)
                        {
                            echo '<b>'.$model->grossmass.'</b> KGM';
                        }
                        elseif ($model->grossmass)
                        {
                            echo '<i>pending</i>';
                        }
                        else
                        {
                            echo '<i>unverified</i>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Date Verified
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        <?php
                        if ($model->status == Certificate::STATUS_VERIFIED)
                        {
                            if ($model->weighing_date)
                            {
                                $date = DateTime::createFromFormat('Y-m-d', $model->weighing_date);

                                echo $date->format('F yS, Y');
                            }
                        }
                        else
                        {
                            echo '<i>unverified</i>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="=3">
                        <div class="detail-title">
                            DECLARANT DETAILS
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Shipper
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        <?= ArrayHelper::getValue($model, 'shipper.name', '-'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Address
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        <?= ArrayHelper::getValue($model, 'shipper.address', '-'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        E-mail
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        <?= ArrayHelper::getValue($model, 'shipper.email', '-'); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="=3">
                        <div class="detail-title">
                            WEIGHT CERTIFICATE DETAILS
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Name of Issuer
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        Badan Klasifikasi Indonesia
                    </td>
                </tr>
                <tr>
                    <td>
                        Street
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        12 Jl. Pamularsih
                    </td>
                </tr>
                <tr>
                    <td>
                        City
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        Semarang, Central Java
                    </td>
                </tr>
                <tr>
                    <td>
                        Country
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        Indonesia
                    </td>
                </tr>
            </table>

        </div>

        <br/>

        <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td width="70%">
                    &nbsp;
                </td>
                <td width="30%" align="center">
                    <p align="center">
                        Inspector
                    </p>
                    <br/>
                    <br/>
                    <br/>
                    <p align="center">
                        <u>Y o h a n i s</u>
                        <br/>
                        NIP: 69408-KI
                    </p>
                </td>
            </tr>
        </table>

        <br/>
        <br/>


        <div id="disclaimer">
            Disclaimer :
            <ol>
                <li>
                    BKI is not responsible for the cargo of the container
                </li>
                <li>
                    BKI shall be free from all risk and responsibilities
                    including but not limited, the status/legality, condition and
                    quality of the cargo inside the container
                </li>
                <li>
                    The gross mass declared on this document is
                    the “Verified Gross Mass” as obtained by using method 2
                </li>
            </ol>
        </div>

    </div>

</div>

<htmlpagefooter name="footer_container">
    <div id="footer" class="footer">
        <span id="footer-title">BKI KOMERSIL SEMARANG</span><br/>
        <span class="footer-detail">Jl. Pamularsih  No.12, SEMARANG - 50148</span><br/>
        <span class="footer-detail">Phone : (62-024) 7610744, Fax (62-024) 76670354</span><br/>
        <span class="footer-detail">e-mail : <a href="mailto: smc@bki.co.id">smc@bki.co.id</a></span><br/>
        <span class="footer-detail">ISO 9001 : 2008 CERTIFIED COMPANY</span><br/>
        <br/>
    </div>
</htmlpagefooter>
