<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use jino5577\daterangepicker\DateRangePicker;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\TransferSearch $searchModel
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
<div class="giiant-crud transfer-index">

    <?php
    \yii\widgets\Pjax::begin([
        'id'                 => 'pjax-main',
        'enableReplaceState' => false,
        'linkSelector'       => '#pjax-main ul.pagination a, th a',
        'clientOptions'      => ['pjax:success' => 'function(){alert("yo")}'],
    ])
    ?>

    <h1>
        <?= Yii::t('app', 'Transfers') ?>
        <small>
            List
        </small>
    </h1>
    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=
            Html::a('<span class="glyphicon glyphicon-plus"></span> '.'New', ['create'], ['class' => 'btn btn-success'])
            ?>
        </div>

    </div>

    <hr />

    <div class="table-responsive">
        <?=
        GridView::widget([
            'id'           => 'kv-grid-demo',
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                [
                    'attribute' => 'time',
                    'options'   => [],
                    'value'     => function ($model)
                {
                    if ($model->time)
                    {
                        return substr($model->time, 0, 10);
                    }

                    return '-';
                },
                    'filter'       => DateRangePicker::widget([
                        'model'         => $searchModel,
                        'attribute'     => 'time_at_range',
                        'pluginOptions' => [
                            'format'          => 'm/d/Y',
                            'autoUpdateInput' => false,
                        ],
                    ]),
                ],
                'from',
                'amount',
                [
                    'label'     => 'Quantity',
                    'attribute' => 'containerCount',
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
                'type'    => GridView::TYPE_PRIMARY,
                'heading' => 'Transfer',
            ],
            'persistResize'    => false,
            'exportConfig'     => [
                GridView::EXCEL => ['label' => 'Save as EXCEL'],
                GridView::PDF   => ['label' => 'Save as PDF'],
                GridView::HTML  => ['label' => 'Save as HTML'],
            ],
        ]);
        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


