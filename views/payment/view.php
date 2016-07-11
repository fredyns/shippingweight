<?php

use dmstr\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
 * @var yii\web\View $this
 * @var app\models\Payment $model
 */
$copyParams = $model->attributes;

$this->title                   = Yii::t('app', 'Payment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string) $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud payment-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('app', 'Payment') ?>
        <small>
            <?= $model->id ?>
        </small>
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
                '<span class="glyphicon glyphicon-plus"></span> '.'New', ['create'], ['class' => 'btn btn-success'])
            ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('app\models\Payment'); ?>


    <?=
    DetailView::widget([
        'model'      => $model,
        'attributes' => [
            [
                'format'    => 'html',
                'attribute' => 'customer_id',
                'value'     => ($model->getCustomer()->one() ? Html::a($model->getCustomer()->one()->name,
                        ['customer/view', 'id' => $model->getCustomer()->one()->id,]) : '<span class="label label-warning">?</span>'),
            ],
            'note',
            'total',
            [
                'attribute' => 'status',
                'value'     => app\models\Payment::getStatusValueLabel($model->status),
            ],
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

    <?php $this->beginBlock('PaymentInfo'); ?>


    <?=
    DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'created_by',
            'updated_by',
            'paid_by',
            'cancel_by',
            'created_at:datetime',
            'updated_at:datetime',
            'paid_at:datetime',
            'cancel_at:datetime',
        ],
    ]);
    ?>
    <?php $this->endBlock(); ?>



    <?php $this->beginBlock('Containers'); ?>
    <?php
    Pjax::begin([
        'id'                 => 'pjax-Containers',
        'enableReplaceState' => false,
        'linkSelector'       => '#pjax-Containers ul.pagination a, th a',
        'clientOptions'      => ['pjax:success' => 'function(){alert("yo")}'],
    ])
    ?>
    <?=
    '<div class="table-responsive">'
    .\yii\grid\GridView::widget([
        'layout'       => '{summary}{pager}<br/>{items}{pager}',
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query'      => $model->getContainers(),
            'pagination' => [
                'pageSize'  => 20,
                'pageParam' => 'page-containers',
            ],
            ]),
        'pager'        => [
            'class'          => yii\widgets\LinkPager::className(),
            'firstPageLabel' => 'First',
            'lastPageLabel'  => 'Last',
        ],
        'columns'      => [
            [
                'class'     => yii\grid\DataColumn::className(),
                'attribute' => 'shipper_id',
                'options'   => [],
                'value'     => function ($model)
            {
                if ($rel = $model->getShipper()->one())
                {
                    return Html::a($rel->name, ['shipper/view', 'id' => $rel->id,], ['data-pjax' => 0]);
                }
                else
                {
                    return '';
                }
            },
                'format' => 'raw',
            ],
            'number',
            'booking_number',
            'bill',
        ]
    ]).'</div>'
    ?>
    <?php Pjax::end() ?>
    <?php $this->endBlock() ?>


    <?=
    Tabs::widget([
        'id'           => 'relation-tabs',
        'encodeLabels' => false,
        'items'        => [
            [
                'label'   => '<b class=""># '.$model->id.'</b>',
                'content' => $this->blocks['app\models\Payment'],
                'active'  => true,
            ],
            [
                'content' => $this->blocks['PaymentInfo'],
                'label'   => '<small>Info</small>',
                'active'  => false,
            ],
            [
                'content' => $this->blocks['Containers'],
                'label'   => '<small>Containers <span class="badge badge-default">'.count($model->getContainers()->asArray()->all()).'</span></small>',
                'active'  => false,
            ],
        ],
    ]);
    ?>
</div>
