<?php

use dmstr\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
 * @var yii\web\View $this
 * @var app\models\Shipper $model
 */
$copyParams = $model->attributes;

$this->title                   = Yii::t('app', 'Shipper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shippers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string) $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud shipper-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('app', 'Shipper') ?>
        <small>
            <?= $model->name ?>
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

    <?php $this->beginBlock('app\models\Shipper'); ?>


    <?=
    DetailView::widget([
        'model'      => $model,
        'attributes' => [
            [
                'format'    => 'html',
                'attribute' => 'user_id',
                'value'     => ($model->userAccount ? $model->userAccount->username : '<span class="label label-warning">?</span>'),
                'visible'   => (Yii::$app->user->isGuest OR $model->user_id != \Yii::$app->user->id),
            ],
            'name',
            'address:ntext',
            'cp',
            'phone',
            'email:email',
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



    <?php $this->beginBlock('Containers'); ?>
    <div style='position: relative'>
        <div style='position:absolute; right: 0px; top: 0px;'>
            <?=
            Html::a(
                '<span class="glyphicon glyphicon-list"></span> '.'List All'.' Containers', ['container/index'],
                ['class' => 'btn text-muted btn-xs']
            )
            ?>
            <?=
            Html::a(
                '<span class="glyphicon glyphicon-plus"></span> '.'New'.' Container',
                [
                'container/create',
                'Container' => [
                    'shipper_id' => $model->id
                ]
                ], [
                'class' => 'btn btn-success btn-xs'
                ]
            );
            ?>
        </div>
    </div>
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
            'class'          => \yii\widgets\LinkPager::className(),
            'firstPageLabel' => 'First',
            'lastPageLabel'  => 'Last',
        ],
        'columns'      => [
            'number',
            'status',
            'grossmass',
            'weighing_date',
            [
                'class'          => 'yii\grid\ActionColumn',
                'template'       => '{view} {update}',
                'contentOptions' => ['nowrap' => 'nowrap'],
                'urlCreator'     => function ($action, $model, $key, $index)
            {
                // using the column name as key, not mapping to 'id' like the standard generator
                $params    = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                $params[0] = 'container'.'/'.$action;
                return $params;
            },
                'buttons'    => [
                ],
                'controller' => 'container'
            ],
        ]
    ])
    .'</div>'
    ?>
    <?php Pjax::end() ?>
    <?php $this->endBlock() ?>


    <?php $this->beginBlock('ShipperInfo'); ?>


    <?=
    DetailView::widget([
        'model'      => $model,
        'attributes' => [
            [
                'attribute' => 'created_by',
                'visible'   => (Yii::$app->user->identity->isAdmin),
            ],
            [
                'attribute' => 'updated_by',
                'visible'   => (Yii::$app->user->identity->isAdmin),
            ],
            [
                'attribute' => 'created_at',
                'format'    => 'datetime',
                'visible'   => (Yii::$app->user->identity->isAdmin),
            ],
            [
                'attribute' => 'updated_at',
                'format'    => 'datetime',
                'visible'   => (Yii::$app->user->identity->isAdmin),
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


    <?=
    Tabs::widget(
        [
            'id'           => 'relation-tabs',
            'encodeLabels' => false,
            'items'        => [
                [
                    'label'   => '<b class=""># '.$model->id.'</b>',
                    'content' => $this->blocks['app\models\Shipper'],
                    'active'  => true,
                ],
                [
                    'content' => $this->blocks['Containers'],
                    'label'   => '<small>Containers <span class="badge badge-default">'.count($model->getContainers()->asArray()->all()).'</span></small>',
                    'active'  => false,
                ],
                [
                    'content' => $this->blocks['ShipperInfo'],
                    'label'   => '<small>Info</small>',
                    'active'  => false,
                    'visible' => (Yii::$app->user->identity->isAdmin),
                ],
            ]
        ]
    );
    ?>
</div>
