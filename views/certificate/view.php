<?php

use dmstr\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
 * @var yii\web\View $this
 * @var app\models\Certificate $model
 */
$copyParams = $model->attributes;

$this->title                   = Yii::t('app', 'Certificate');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Certificates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string) $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud certificate-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('app', 'Certificate') ?>        <small>
            <?= $model->id ?>        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?=
            Html::a(
                '<span class="glyphicon glyphicon-pencil"></span> '.'Edit', [ 'update', 'id' => $model->id],
                ['class' => 'btn btn-info'])
            ?>

            <?=
            Html::a(
                '<span class="glyphicon glyphicon-copy"></span> '.'Copy',
                ['create', 'id' => $model->id, 'Certificate' => $copyParams], ['class' => 'btn btn-success'])
            ?>

            <?=
            Html::a(
                '<span class="glyphicon glyphicon-plus"></span> '.'New', ['create'], ['class' => 'btn btn-success'])
            ?>
        </div>

        <div class="pull-right">
            <?=
            Html::a('<span class="glyphicon glyphicon-list"></span> '
                .'Full list', ['index'], ['class' => 'btn btn-default'])
            ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('app\models\Certificate'); ?>


    <?=
    DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            [
                'format'    => 'html',
                'attribute' => 'shipper_id',
                'value'     => ($model->getShipper()->one() ? Html::a($model->getShipper()->one()->name,
                        ['shipper/view', 'id' => $model->getShipper()->one()->id,]) : '<span class="label label-warning">?</span>'),
            ],
            [
                'format'    => 'html',
                'attribute' => 'shipment_id',
                'value'     => ($model->getShipment()->one() ? Html::a($model->getShipment()->one()->id,
                        ['shipment/view', 'id' => $model->getShipment()->one()->id,]) : '<span class="label label-warning">?</span>'),
            ],
            [
                'format'    => 'html',
                'attribute' => 'weighing_id',
                'value'     => ($model->getWeighing()->one() ? Html::a($model->getWeighing()->one()->id,
                        ['weighing/view', 'id' => $model->getWeighing()->one()->id,]) : '<span class="label label-warning">?</span>'),
            ],
            'date',
            'job_order',
            'grossmass',
            'container_number',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]);
    ?>


    <hr/>

    <?=
    Html::a('<span class="glyphicon glyphicon-trash"></span> '.'Delete', ['delete', 'id' => $model->id],
        [
        'class'        => 'btn btn-danger',
        'data-confirm' => ''.'Are you sure to delete this item?'.'',
        'data-method'  => 'post',
    ]);
    ?>
    <?php $this->endBlock(); ?>



    <?=
    Tabs::widget(
        [
            'id'           => 'relation-tabs',
            'encodeLabels' => false,
            'items'        => [ [
                    'label'   => '<b class=""># '.$model->id.'</b>',
                    'content' => $this->blocks['app\models\Certificate'],
                    'active'  => true,
                ],]
        ]
    );
    ?>
</div>