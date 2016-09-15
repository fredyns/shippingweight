<?php

use DateTime;
use yii\helpers\ArrayHelper;
use app\models\Container;

date_default_timezone_set("Asia/Jakarta");

$debt        = Container::debt();
$quantity    = ArrayHelper::getValue($debt, 'quantity', 0);
$created_min = ArrayHelper::getValue($debt, 'created_min', 0);
$created_max = ArrayHelper::getValue($debt, 'created_max', 0);
$date_min    = ($created_min) ? new DateTime('@'.$created_min) : null;
$date_max    = ($created_max) ? date_create('@'.$created_max) : null;
$day_min     = ($date_min) ? $date_min->format('d M') : null;
$day_max     = ($date_max) ? $date_max->format('d M') : null;
$rentang     = 'Terhitung '.(($day_min) ? ' sejak '.$day_min : null).(($day_max) ? ' hingga '.$day_max : null).'.<br/>';
?>


<?php if ($quantity > 0) : ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        Anda memiliki <b><?= $quantity ?></b> kontainer yang belum terbayar.<br/>
        <?= $rentang; ?>
        Segera koordinasikan pembayaran Anda dengan bagian keuangan BKI.<br/>
        Jangan lupa sertakan rekap kontainer (excel) saat melakukan pembayaran.
    </div>
<?php endif; ?>



