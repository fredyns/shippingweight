<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use app\models\search\ContainerSearch;

/**
 * @var yii\web\View $this
 * @var app\models\Container $model
 */
$this->title                   = 'Create';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Containers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
if (Yii::$app->user->isGuest == FALSE)
{
    //echo $this->render('@app/views/widget/debt_alert');
}
?>

<div class="giiant-crud container-create">

    <h1>
        New <?= Yii::t('app', 'Container') ?>
    </h1>

    <hr />

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=
            Html::a(
                'Cancel', \yii\helpers\Url::previous(), ['class' => 'btn btn-default'])
            ?>
        </div>
    </div>

    <hr />

    <?=
    $this->render('_form', [
        'model' => $model,
    ]);
    ?>

</div>

<?php if (Yii::$app->user->isGuest == FALSE) : ?>

    <?php $debt = ContainerSearch::debt('1 months ago'); ?>

    <?php if ($debt['quantity'] > 0) : ?>
        <?php
        Modal::begin([
            'header'       => '<h2>Peringatan</h2>',
            'toggleButton' => FALSE,
            'options'      => [
                'class' => 'alert alert-danger',
            ],
            'id'           => 'debt-alert',
        ]);
        ?>

        Anda memiliki <b><?= $debt['quantity'] ?></b> kontainer yang belum terbayar.<br/>
        Segera konfirmasikan pembayaran Anda dengan bagian keuangan BKI.<br/>
        Jangan lupa sertakan rekap kontainer (excel) saat melakukan pembayaran.<br/>
        <?= $debt['range']; ?>

        <?php Modal::end(); ?>

        <?php $this->registerJs("$('#debt-alert').modal('show')", \yii\web\VIEW::POS_READY); ?>

    <?php endif; ?>

<?php endif; ?>

