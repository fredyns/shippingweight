<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\widget\ContainerMenu;
use jino5577\daterangepicker\DateRangePicker;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\ContainerSearch $searchModel
 */
$this->title                   = Yii::t('app', 'Containers');
$this->params['breadcrumbs'][] = $this->title;



if (isset($actionColumnTemplates))
{
    $actionColumnTemplate       = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
}
else
{
    Yii::$app->view->params['pageButtons'] = Html::a(
            '<span class="glyphicon glyphicon-plus"></span> '.'New', ['create'], ['class' => 'btn btn-success']
    );
    $actionColumnTemplateString            = "{view} {update} {delete}";
}

$admin = FALSE;

if (Yii::$app->user->isGuest == FALSE)
{
    if (Yii::$app->user->identity->isAdmin)
    {
        $admin = TRUE;
    }
}
?>

<div class="giiant-crud container-index">

    <?php
    \yii\widgets\Pjax::begin([
        'id'                 => 'pjax-main',
        'enableReplaceState' => false,
        'linkSelector'       => '#pjax-main ul.pagination a, th a',
        'clientOptions'      => ['pjax:success' => 'function(){alert("yo")}'],
    ])
    ?>

    <h1>
        <?= Yii::t('app', 'Containers') ?>
        <small>
            List
        </small>
    </h1>

    <br/>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=
            Html::a('<span class="glyphicon glyphicon-plus"></span> '.'New', ['create'], ['class' => 'btn btn-success'])
            ?>
        </div>

    </div>

    <hr />

    <div class="table-responsive">

        <?php
        echo \kartik\grid\GridView::widget([
            'id'           => 'kv-grid-demo',
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
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
                    'options'   => [],
                    'format'    => 'raw',
                    'value'     => function ($model)
                {
                    $out = $model->number;

                    if ($model->transfer_id > 0)
                    {
                        $out .= ' <b class="text-success">&check;</b>';
                    }

                    return $out;
                },
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
                    'filter' => DateRangePicker::widget([
                        'model'         => $searchModel,
                        'attribute'     => 'created_at_range',
                        'pluginOptions' => [
                            'format'          => 'm/d/Y',
                            'autoUpdateInput' => false,
                        ],
                    ]),
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
                    'filter' => DateRangePicker::widget([
                        'model'         => $searchModel,
                        'attribute'     => 'verified_at_range',
                        'pluginOptions' => [
                            'format'          => 'm/d/Y',
                            'autoUpdateInput' => false,
                        ],
                    ]),
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
                    'template'   => $actionColumnTemplateString,
                    'urlCreator' => function($action, $model, $key, $index)
                {
                    // using the column name as key, not mapping to 'id' like the standard generator
                    $params    = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                    $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id.'/'.$action : $action;
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
                'type'    => \kartik\grid\GridView::TYPE_PRIMARY,
                'heading' => 'Containers',
            ],
            'persistResize'    => false,
            'exportConfig'     => [
                \kartik\grid\GridView::EXCEL => ['label' => 'Save as EXCEL'],
            //\kartik\grid\GridView::PDF   => ['label' => 'Save as PDF'],
            //\kartik\grid\GridView::HTML  => ['label' => 'Save as HTML'],
            ],
        ]);
        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>
