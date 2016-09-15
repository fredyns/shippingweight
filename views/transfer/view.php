<?php

use dmstr\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
use app\widget\ContainerMenu;

/**
 * @var yii\web\View $this
 * @var app\models\Transfer $model
 */
$copyParams = $model->attributes;

$this->title                   = Yii::t('app', 'Transfer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transfers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string) $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud transfer-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('error') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('error') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('app', 'Transfer') ?>
        <small>
            #<?= $model->id ?>
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

        <div class="pull-right">
            <?=
            Html::a('<span class="glyphicon glyphicon-list"></span> '
                .'Full list', ['index'], ['class' => 'btn btn-default'])
            ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('app\models\Transfer'); ?>


    <?=
    DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'time',
            'from',
            'amount',
            'containerCount',
            'containerList_all:ntext',
            'note:ntext',
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

    <?php $this->beginBlock('info'); ?>


    <?=
    DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'containerList_confirmed:ntext',
            'containerList_missed:ntext',
            'created_by',
            'updated_by',
            'created_at:datetime',
            'updated_at:datetime',
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
    <div class="table-responsive">

        <?=
        GridView::widget([
            'id'           => 'kv-grid-container',
            'dataProvider' => new \yii\data\ActiveDataProvider([
                'query'      => $model->getContainers()->orderBy(['number' => SORT_ASC]),
                'pagination' => [
                    'pageSize'  => 20,
                    'pageParam' => 'page-containers',
                ],
                ]),
            'columns'      => [
                [
                    'label'     => 'User',
                    'attribute' => 'user_id',
                    'options'   => [],
                    'visible'   => Yii::$app->user->identity->isAdmin,
                    'value'     => function ($model)
                {
                    if ($model->shipper)
                    {
                        if ($model->shipper->userAccount)
                        {
                            return $model->shipper->userAccount->username;
                        }
                    }

                    return '';
                },
                ],
                [
                    'attribute' => 'booking_number',
                    'label'     => 'Booking',
                ],
                [
                    'attribute' => 'number',
                    'label'     => 'Container',
                ],
                [
                    'attribute' => 'shipper_id',
                    'options'   => [],
                    'format'    => 'raw',
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
                ],
                'grossmass',
                // created
                [
                    'attribute' => 'created_at',
                    'label'     => 'Registered',
                    'options'   => [],
                    'value'     => function ($model)
                {
                    return date('Y-m-d', $model->created_at);
                },
                ],
                // verified
                [
                    'attribute' => 'weighing_date',
                    'label'     => 'Verified',
                    'options'   => [],
                    'value'     => function ($model)
                {
                    if ($model->weighing_date)
                    {
                        return substr($model->weighing_date, 0, 10);
                    }

                    return '-';
                },
                ],
                [
                    'attribute' => 'status',
                    'options'   => [],
                    'format'    => 'html',
                    'value'     => function ($model)
                {
                    return ContainerMenu::widget(['model' => $model]);
                }
                ],
                [
                    'class'      => 'kartik\grid\ActionColumn',
                    'options'    => [],
                    'template'   => "{view} {update} {delete}",
                    'urlCreator' => function($action, $model, $key, $index)
                {
                    // using the column name as key, not mapping to 'id' like the standard generator
                    $params    = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                    $params[0] = 'container'.'/'.$action;
                    return Url::toRoute($params);
                },
                    'contentOptions' => ['nowrap' => 'nowrap']
                ],
            ],
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax'             => FALSE, // pjax is set to always true for this demo
            // set your toolbar
            'toolbar'          => [
                [
                    'content' => Html::a(
                        '<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'],
                        ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Reset Grid']
                    ),
                ],
                '{export}',
                '{toggleData}',
            ],
            // set export properties
            'export'           => [
                'icon'  => 'export',
                'label' => 'Export',
            ],
            // parameters from the demo form
            'bordered'         => true,
            'striped'          => true,
            'condensed'        => true,
            'responsive'       => true,
            'hover'            => true,
            'showPageSummary'  => true,
            'panel'            => [
                'type'    => GridView::TYPE_PRIMARY,
                'heading' => 'Containers',
            ],
            'persistResize'    => false,
            'exportConfig'     => [
                GridView::EXCEL => ['label' => 'Save as EXCEL'],
            ],
        ]);
        ?>
    </div>

    <?php Pjax::end() ?>
    <?php $this->endBlock() ?>


    <?=
    Tabs::widget(
        [
            'id'           => 'relation-tabs',
            'encodeLabels' => false,
            'items'        => [
                [
                    'label'   => '<b class=""># '.$model->id.'</b>',
                    'content' => $this->blocks['app\models\Transfer'],
                    'active'  => true,
                ],
                [
                    'content' => $this->blocks['Containers'],
                    'label'   => '<small>Containers <span class="badge badge-default">'.count($model->getContainers()->asArray()->all()).'</span></small>',
                    'active'  => false,
                ],
                [
                    'label'   => 'info',
                    'content' => $this->blocks['info'],
                    'active'  => false,
                ],
            ]
        ]
    );
    ?>
</div>
