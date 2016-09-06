<?php

use dmstr\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
use app\widget\ContainerMenu;
use jino5577\daterangepicker\DateRangePicker;

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
    <?=
    '<div class="table-responsive">'
    .\yii\grid\GridView::widget([
        'layout'       => '{summary}{pager}<br/>{items}{pager}',
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query'      => $model->getContainers()->orderBy(['number' => SORT_ASC]),
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
        ]
    ])
    .'</div>'
    ?>
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
