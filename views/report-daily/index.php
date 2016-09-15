<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use jino5577\daterangepicker\DateRangePicker;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\ReportDailySearch $searchModel
 */
if (isset($actionColumnTemplates))
{
    $actionColumnTemplate       = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
}
else
{
    Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> '.'New',
            ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString            = "{view} {update} {delete}";
}
?>
<div class="giiant-crud report-daily-index">

    <?php
    \yii\widgets\Pjax::begin([
        'id'                 => 'pjax-main',
        'enableReplaceState' => false,
        'linkSelector'       => '#pjax-main ul.pagination a, th a',
        'clientOptions'      => ['pjax:success' => 'function(){alert("yo")}'],
    ])
    ?>

    <div class="table-responsive">
        <?=
        \kartik\grid\GridView::widget([
            'id'           => 'kv-grid-demo',
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                //*
                [
                    'attribute' => 'day',
                    'options'   => [],
                    'value'     => function ($model)
                {
                    $day     = $model->day;
                    $date    = date_create_from_format('Y-m-d', $day);
                    $dayNum  = $date->format('w');
                    $dayName = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

                    return $model->day.', '.$dayName[$dayNum];
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
                // */
                //'day',
                'registerCount',
                'certificateCount',
                'paidCount',
            ],
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax'             => true, // pjax is set to always true for this demo
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
                'heading' => 'Daily Report',
            ],
            'persistResize'    => false,
            'exportConfig'     => [
                \kartik\grid\GridView::EXCEL => ['label' => 'Save as EXCEL'],
                \kartik\grid\GridView::PDF   => ['label' => 'Save as PDF'],
                \kartik\grid\GridView::HTML  => ['label' => 'Save as HTML'],
            ],
        ]);
        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


