<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use kartik\datetime\DateTimePicker;
use app\models\Container;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\ContainerSearch $searchModel
 */
$this->title                   = Yii::t('app', 'Receiving');
$this->params['breadcrumbs'][] = 'TPKS';
$this->params['breadcrumbs'][] = $this->title;

$from_value = $from->format('Y-m-d H:i');
$to_value   = $to->format('Y-m-d H:i');

if ($autorefresh)
{
    $this->title .= ' - '.date('H:i');
}
?>

<div class="giiant-crud tpks-receiving">

    <h1>
        <?= Yii::t('app', 'TPKS') ?>
        <small>
            Gate In Receiving
        </small>
    </h1>

    <br/>

    <hr />

    <?php
    $form   = ActiveForm::begin([
            'action' => ['receiving'],
            'method' => 'get',
    ]);
    ?>

    <div id="receiving-search" class="row">

        <div class="col-sm-3">

            <b>From</b>

            <?=
            DateTimePicker::widget([
                'id'            => 'from',
                'name'          => 'from',
                'type'          => DateTimePicker::TYPE_INLINE,
                'value'         => $from_value,
                'pluginOptions' => [
                    'initialDate' => $from_value,
                    'format'      => 'yyyy-mm-dd hh:ii',
                    'endDate'     => date('Y-m-d H:i'),
                    'startView'   => 0,
                ]
            ]);
            ?>

        </div>

        <div class="col-sm-3">

            <b>To</b>

            <?=
            DateTimePicker::widget([
                'id'            => 'to',
                'name'          => 'to',
                'type'          => DateTimePicker::TYPE_INLINE,
                'value'         => $to_value,
                'pluginOptions' => [
                    'initialDate' => $to_value,
                    'format'      => 'yyyy-mm-dd hh:ii',
                    'endDate'     => date('Y-m-d H:i'),
                    'startView'   => 0,
                ]
            ]);
            ?>

        </div>

    </div>

    <hr />

    <div class="form-group">

        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>

        <?php
        $missed = 0;

        foreach ($containers as $container)
        {
            $status = ArrayHelper::getValue($container, 'CTR_STATUS');
            $vgm    = ArrayHelper::getValue($container, 'IS_GROSS_VERIFIED');

            if ($vgm != 'Y' && $status == 'FCL')
            {
                $missed++;
            }
        }

        if ($missed == 0)
        {
            echo '&nbsp; &nbsp; &nbsp; all containers already Gate-Out.';
        }
        elseif ($missed == 1)
        {
            echo '&nbsp; &nbsp; &nbsp; <span class="label label-danger">'.$missed.'</span> container <b>NOT</b> Gate-Out.';
        }
        else
        {
            echo '&nbsp; &nbsp; &nbsp; <span class="label label-danger">'.$missed.'</span> containers <b>NOT</b> Gate-Out.';
        }

        if ($autorefresh)
        {
            echo '&nbsp; Checked '.date('d M Y, H:i');
        }
        ?>

    </div>

    <?php ActiveForm::end(); ?>

    <hr />

    <style>
        @media screen and (min-width: 480px) {
            .text-right {
                text-align: right;
            }
        }
    </style>

    <div class="table-responsive">

        <?php
        if ($from->format('d') == $to->format('d'))
        {
            $day  = $from->format('d');
            $time = 'From '.$from->format('H:i').' to '.$to->format('H:i');
        }
        else
        {
            $day  = $from->format('d').'-'.$to->format('d');
            $time = 'From '.$from->format('d M H:i').' to '.$to->format('d M H:i');
        }

        echo GridView::widget([
            'id'           => 'receiving-containers',
            'dataProvider' => new ArrayDataProvider(['allModels' => $containers, 'pagination' => FALSE]),
            'columns'      => [
                [
                    'class' => '\kartik\grid\SerialColumn'
                ],
                [
                    'label'     => 'Container',
                    'attribute' => 'CONTAINER_NO',
                    'format'    => 'raw',
                    'value'     => function ($model)
                    {
                        $containerNumber = ArrayHelper::getValue($model, 'CONTAINER_NO');
                        $label           = '<span style="font-family: monospace; font-weight: bolder;">'.$containerNumber.'</span>';
                        $container       = ArrayHelper::getValue($model, 'container');
                        $containers      = ArrayHelper::getValue($model, 'containers');
                        $parsed          = ArrayHelper::getValue($model, 'parsed');
                        $value           = $label;

                        if (empty($container) == FALSE)
                        {
                            $value = Html::a(
                                    $containerNumber, ['/container/view', 'id' => $container->id,],
                                    ['data-pjax' => 0, 'target' => '_blank', 'title' => 'lihat pendaftaran VGM', 'style' => "font-family: monospace; font-weight: bolder;"]
                            );
                        }

                        if (count($containers) > 1)
                        {
                            $value .= '&nbsp; '.Html::a(
                                    '<span class="glyphicon glyphicon-exclamation-sign"></span>',
                                    ['/container', 'ContainerSearch' => ['number' => $containerNumber]],
                                    ['data-pjax' => 0, 'target' => '_blank', 'title' => 'kontainer ganda']
                            );
                        }

                        if ($parsed)
                        {
                            $value .= ' &check; ';
                        }

                        return $value;
                    }
                    ],
                    [
                        'label'          => 'Gross Ton',
                        'attribute'      => 'GROSS_KG',
                        'headerOptions'  => [
                            'class' => 'text-right',
                        ],
                        'contentOptions' => [
                            'class' => 'text-right',
                            'style' => 'font-weight: bolder; font-family: monospace;',
                        ],
                        'format'         => ['integer'],
                    ],
                    [
                        'attribute'      => 'IS_GROSS_VERIFIED',
                        'label'          => 'VGM',
                        'format'         => 'raw',
                        'headerOptions'  => [
                            'style' => 'text-align: center;',
                        ],
                        'contentOptions' => [
                            'style' => 'text-align: center; font-weight: bolder;',
                        ],
                        'value'          => function ($model)
                    {
                        $status = ArrayHelper::getValue($model, 'CTR_STATUS');
                        $value  = ArrayHelper::getValue($model, 'IS_GROSS_VERIFIED');

                        if ($value == 'Y')
                        {
                            return '<span class="label label-success">'.$value.'</span>';
                        }
                        elseif ($status == 'MTY')
                        {
                            return '<span class="label label-default">'.$value.'</span>';
                        }

                        return '<span class="label label-danger">'.$value.'</span>';
                    }
                    ],
                    [
                        'attribute'      => 'CTR_SIZE',
                        'label'          => 'Size',
                        'headerOptions'  => [
                            'style' => 'text-align: center;',
                        ],
                        'contentOptions' => [
                            'style' => 'text-align: center;',
                        ],
                    ],
                    [
                        'attribute'      => 'CTR_STATUS',
                        'label'          => 'Status',
                        'headerOptions'  => [
                            'style' => 'text-align: center;',
                        ],
                        'contentOptions' => [
                            'style' => 'text-align: center;',
                        ],
                    ],
                    [
                        'label'          => 'Truck',
                        'attribute'      => 'TRUCK_ID',
                        'format'         => 'raw',
                        'contentOptions' => [
                            'style' => 'font-family: monospace;',
                        ],
                    ],
                    [
                        'label'   => 'Gate In',
                        'options' => [],
                        'format'  => 'raw',
                        'value'   => function ($model)
                    {
                        $value = ArrayHelper::getValue($model, 'GATE_IN_TIME');

                        if ($value)
                        {
                            $date = date_create_from_format('d-m-Y H:i:s', $value);

                            if ($date)
                            {
                                return '<span style="display: none;">'.$date->format('Y-m-d').'</span> '.$date->format('H:i');
                            }
                        }

                        return NULL;
                    }
                    ],
                    [
                        'label'   => 'Gate Out',
                        'options' => [],
                        'format'  => 'raw',
                        'value'   => function ($model)
                    {
                        $value = ArrayHelper::getValue($model, 'GATE_OUT_TIME');

                        if ($value)
                        {
                            $date = date_create_from_format('d-m-Y H:i:s', $value);

                            if ($date)
                            {
                                return '<span style="display: none;">'.$date->format('Y-m-d').'</span> '.$date->format('H:i');
                            }
                        }

                        return NULL;
                    }
                    ],
                    [
                        'attribute'      => 'WEIGHT_IN_KG',
                        'label'          => 'Weight In',
                        'headerOptions'  => [
                            'class' => 'text-right',
                        ],
                        'contentOptions' => [
                            'class' => 'text-right',
                        ],
                    ],
                    [
                        'attribute'      => 'WEIGHT_OUT_KG',
                        'label'          => 'Weight Out',
                        'headerOptions'  => [
                            'class' => 'text-right',
                        ],
                        'contentOptions' => [
                            'class' => 'text-right',
                        ],
                    ],
                ],
                'containerOptions'    => ['style' => 'overflow: auto'], // only set when $responsive = false
                'headerRowOptions'    => ['class' => 'kartik-sheet-style'],
                'filterRowOptions'    => ['class' => 'kartik-sheet-style'],
                'pjax'                => FALSE, // pjax is set to always true for this demo
                // set your toolbar
                'toolbar'             => [
                    '{export}',
                ],
                // set export properties
                'export'              => [
                    'icon'  => 'export',
                    'label' => 'Export',
                ],
                // parameters from the demo form
                'bordered'            => true,
                'striped'             => true,
                'condensed'           => true,
                'responsive'          => true,
                'hover'               => true,
                'showPageSummary'     => true,
                'panel'               => [
                    'type'    => \kartik\grid\GridView::TYPE_PRIMARY,
                    'heading' => 'Receiving '.$day.$from->format(' F Y'),
                ],
                'persistResize'       => false,
                'exportConfig'        => [
                    \kartik\grid\GridView::EXCEL => ['label' => 'Save as EXCEL'],
                ],
                'panelBeforeTemplate' => $time.'

                <div class="pull-right">
                    <div class="btn-toolbar kv-grid-toolbar" role="toolbar">
                        {toolbar}
                    </div>
                </div>
                {before}
                <div class="clearfix"></div>
            ',
                //'floatHeader'         => true,
                'rowOptions'          => function($model, $key, $index, $grid)
            {
                $status = ArrayHelper::getValue($model, 'CTR_STATUS');
                $vgm    = ArrayHelper::getValue($model, 'IS_GROSS_VERIFIED');
                $gatein = ArrayHelper::getValue($model, 'GATE_IN_TIME');
                $now    = new \DateTime;

                if ($gatein)
                {
                    $datein = date_create_from_format('d-m-Y H:i:s', $gatein);

                    if ($datein)
                    {
                        $TRT_interval = $now->diff($datein);
                        $TRT_hour     = $TRT_interval->format('%h');
                        $TRT_minute   = $TRT_interval->format('%i');

                        if ($vgm != 'Y' && $status != 'MTY' && ($TRT_hour > 1 OR ( $TRT_hour > 0 && $TRT_minute > 30) ))
                        {
                            return ['class' => GridView::TYPE_DANGER];
                        }
                    }
                }


                return [];
            },
            ]);
            ?>

        </div>

        <?php
        if ($autorefresh)
        {
            echo '<p>Generated: '.date('d F Y, H:i:s').'</p>';
        }
        ?>

    </div>

    <?php
    $script = <<< JS
    setInterval(function(){ location.reload(); }, (1000*60*15));
JS;

    if ($autorefresh)
    {
        $this->registerJs($script);
    }
    ?>
