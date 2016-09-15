<?php

use app\models\search\ContainerSearch;

$debt = ContainerSearch::debt('7 days ago');
?>

<?php if ($debt['quantity'] > 0) : ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        Anda memiliki <b><?= $debt['quantity'] ?></b> kontainer yang belum terbayar.<br/>
        Segera konfirmasikan pembayaran Anda dengan bagian keuangan BKI.<br/>
        Jangan lupa sertakan rekap kontainer (excel) saat melakukan pembayaran.<br/>
        <?= $debt['range']; ?>
    </div>
<?php endif; ?>
