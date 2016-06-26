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
        'date',
        'job_order',
        'grossmass',
        'container_number',
    ],
]);
?>

