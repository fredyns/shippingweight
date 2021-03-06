<?php

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Certificate;

$headerImageUrl  = Url::to(['/image/bki-logo-sm.jpg']);
$headerQrcodeUrl = Url::to([
        '/certificate/qrcode',
        'id'               => ArrayHelper::getValue($model, 'id', '0'),
        'container_number' => ArrayHelper::getValue($model, 'number', 'xxxxx'),
    ]);
?>

<div id="page-1">

    <div id="qrcode">
        <img src="<?= $headerQrcodeUrl; ?>" width="120px"/>
    </div>

    <div class="header">

        <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td>
                    <img id="header-logo" src="<?= $headerImageUrl; ?>" width="40px"/>
                </td>
                <td>
                    <div id="header-title" style="">
                        <b>
                            PT. BIRO KLASIFIKASI INDONESIA (Persero)
                        </b>
                    </div>
                </td>
            </tr>
        </table>

    </div>

    <div class="body">

        <br/>
        <br/>

        <div id="title">
            <b>
                DECLARATION OF WEIGHT
            </b>
        </div>
        <div id="certificate_number">
            ( S A M P L E &nbsp; &nbsp; D O C U M E N T )
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
                        <?= ArrayHelper::getValue($model, 'booking_number', '............'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Container Number
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        <b><?= ArrayHelper::getValue($model, 'number', '............'); ?></b>
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
                        Method 1
                    </td>
                </tr>
                <tr>
                    <td>
                        Verified Gross Weight
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        <?php
                        if ($model instanceof Certificate)
                        {
                            if ($model->status == Certificate::STATUS_VERIFIED)
                            {
                                echo '<b>'.($model->grossmass * 1000).'</b> Kgm';
                            }
                            else
                            {
                                echo '<i>unverified</i>';
                            }
                        }
                        else
                        {
                            echo ArrayHelper::getValue($model, 'grossmass', '............');
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
                        <?= ArrayHelper::getValue($model, 'weighing_date', '............'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        References
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        - IMO SOLAS 1972 Regulation VI/2<br/>
                        - Directorate General of Sea Transportation Ind., Reg. Hk.103/2/4/DJPL_16
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
                        <?= ArrayHelper::getValue($model, 'shipper.name', '............'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Address
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        <?= ArrayHelper::getValue($model, 'shipper.address', '............'); ?>
                    </td>
                </tr>
                <!--
                <tr>
                    <td>
                        E-mail
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                <?= ArrayHelper::getValue($model, 'shipper.email', '............'); ?>
                    </td>
                </tr>
                -->
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
                        Biro Klasifikasi Indonesia
                    </td>
                </tr>
                <tr>
                    <td>
                        Street
                    </td>
                    <td>: &nbsp;</td>
                    <td>
                        Jl. Pamularsih No.12
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
                        NUP: 69408-KI
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
                    the “Verified Gross Mass” as obtained by using method 1
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
