<?php

use yii\widgets\DetailView;
?>

<h3>WEIGHT CERTIFICATE</h3>

<p>
    <img src="<?= $model->qrUrl; ?>" />
</p>

<?=
DetailView::widget([
    'model'      => $model,
    'attributes' => [
        //'id',
        //'vgm_number',
        [
            'attribute' => 'vgm_date',
            'format'    => ['date', 'php:d M Y'],
        ],
        'vgm_gross',
        'container_number',
        //'booking_number',
        'shipper_name',
        //'shipper_address:ntext',
        //'stack_at',
        //'download_at',
        //'dwelling_time:datetime',
        //'created_by',
        //'updated_by',
        'created_at:datetime',
    //'updated_at:datetime',
    ],
]);
?>

