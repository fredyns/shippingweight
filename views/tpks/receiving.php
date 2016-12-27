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
$this->title = Yii::t('app', 'Receiving');
$this->params['breadcrumbs'][] = 'TPKS';
$this->params['breadcrumbs'][] = $this->title;

$from_value = $from->format('Y-m-d H:i');
$to_value = $to->format('Y-m-d H:i');
$missed = 0;

if ($autorefresh) {
    $this->title .= ' ['.date('H:i').']';
}

if ($containers) {
    foreach ($containers as $container) {
        $status = ArrayHelper::getValue($container, 'CTR_STATUS');
        $vgm = ArrayHelper::getValue($container, 'IS_GROSS_VERIFIED');

        if ($vgm != 'Y' && $status == 'FCL') {
            $missed++;
        }
    }
}

if ($missed > 0) {
    $this->title = "({$missed})".$this->title;
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
    $form = ActiveForm::begin([
            'action' => ['receiving'],
            'method' => 'get',
    ]);
    ?>

    <div id="receiving-search" class="row">

        <div class="col-sm-3">

            <b>From</b>

            <?=
            DateTimePicker::widget([
                'id' => 'from',
                'name' => 'from',
                'type' => DateTimePicker::TYPE_INLINE,
                'value' => $from_value,
                'pluginOptions' => [
                    'initialDate' => $from_value,
                    'format' => 'yyyy-mm-dd hh:ii',
                    'endDate' => date('Y-m-d H:i'),
                    'startView' => 0,
                ]
            ]);
            ?>

        </div>

        <div class="col-sm-3">

            <b>To</b>

            <?=
            DateTimePicker::widget([
                'id' => 'to',
                'name' => 'to',
                'type' => DateTimePicker::TYPE_INLINE,
                'value' => $to_value,
                'pluginOptions' => [
                    'initialDate' => $to_value,
                    'format' => 'yyyy-mm-dd hh:ii',
                    'endDate' => $now->format('Y-m-d H:i'),
                    'startView' => 0,
                ]
            ]);
            ?>

        </div>

    </div>

    <hr />

    <div class="form-group">

        <?= Html::submitButton('Search', ['class' => 'btn btn-primary btn-lg']) ?>

        &nbsp; &nbsp; &nbsp;

        <?php
        if ($containers) {
            if ($missed == 0) {
                echo 'all containers already Gate-Out.';
            } elseif ($missed == 1) {
                echo '<span class="label label-danger">'.$missed.'</span> container <b>NOT</b> Gate-Out.';
            } else {
                echo '<span class="label label-danger">'.$missed.'</span> containers <b>NOT</b> Gate-Out.';
            }

            if ($autorefresh) {
                echo '&nbsp; Checked '.date('d M Y, H:i');
            }
        }
        ?>

        <?php if ($error) : ?>

            <div class="alert alert-danger alert-dismissible pull-right" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?= $error; ?>
            </div>

        <?php endif; ?>

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
        if ($from->format('d') == $to->format('d')) {
            $day = $from->format('d');
            $time = 'From '.$from->format('H:i').' to '.$to->format('H:i');
        } else {
            $day = $from->format('d').'-'.$to->format('d');
            $time = 'From '.$from->format('d M H:i').' to '.$to->format('d M H:i');
        }

        echo GridView::widget([
            'id' => 'receiving-containers',
            'dataProvider' => new ArrayDataProvider(['allModels' => $containers, 'pagination' => FALSE]),
            'columns' => [
                ['class' => '\kartik\grid\CheckboxColumn'],
                [
                    'label' => 'Container',
                    'attribute' => 'CONTAINER_NO',
                    'options' => [],
                    'format' => 'raw',
                    'value' => function ($model) {
                        $containerNumber = ArrayHelper::getValue($model, 'CONTAINER_NO');
                        $label = '<span style="font-family: monospace; font-weight: bolder;">'.$containerNumber.'</span>';
                        $container = ArrayHelper::getValue($model, 'container');
                        $containers = ArrayHelper::getValue($model, 'containers');
                        $parsed = ArrayHelper::getValue($model, 'parsed');
                        $value = $label;

                        if (empty($container) == FALSE) {
                            $value = Html::a(
                                    $containerNumber, ['/container/view', 'id' => $container->id,],
                                    ['data-pjax' => 0, 'target' => '_blank', 'title' => 'lihat pendaftaran VGM', 'style' => "font-family: monospace; font-weight: bolder;"]
                            );
                        }

                        if (count($containers) > 1) {
                            $value .= ' '.Html::a(
                                    '<span class="glyphicon glyphicon-duplicate" title="registrasi vgm duplikat"></span>',
                                    ['/container', 'ContainerSearch' => ['number' => $containerNumber]],
                                    ['data-pjax' => 0, 'target' => '_blank', 'title' => 'kontainer ganda']
                            );
                        }

                        if ($parsed) {
                            $value .= ' <span class="glyphicon glyphicon-scale" title="data timbangan baru"></span> ';
                        }

                        return $value;
                    }
                ],
                [
                    'label' => 'Gross Ton',
                    'attribute' => 'GROSS_KG',
                    'headerOptions' => [
                        'class' => 'text-right',
                    ],
                    'contentOptions' => function ($model, $key, $index, $column) {
                        $grossmass = ArrayHelper::getValue($model, 'GROSS_KG', 0);
                        $status = ArrayHelper::getValue($model, 'CTR_STATUS');
                        $size = ArrayHelper::getValue($model, 'CTR_SIZE');
                        $type = ArrayHelper::getValue($model, 'CTR_TYPE');
                        $verified = ArrayHelper::getValue($model, 'IS_GROSS_VERIFIED');
                        $minimum = ($size == 40) ? 4000 : 2000;
                        $maximum = ($type == 'DRY') ? 32500 : 35000;

                        if ($verified != 'Y' && $status == 'FCL') {
                            return [
                                'class' => 'text-right label-default',
                                'style' => 'font-weight: bolder; font-family: monospace;',
                            ];
                        }

                        if (($minimum < $grossmass && $grossmass <= $maximum) OR $status == 'MTY') {
                            return [
                                'class' => 'text-right',
                                'style' => 'font-weight: bolder; font-family: monospace;',
                            ];
                        }

                        return [
                            'class' => 'text-right label-warning',
                            'style' => 'font-weight: bolder; font-family: monospace;',
                        ];
                    },
                    'format' => ['integer'],
                ],
                [
                    'attribute' => 'IS_GROSS_VERIFIED',
                    'label' => 'VGM',
                    'format' => 'raw',
                    'headerOptions' => [
                        'style' => 'text-align: center;',
                    ],
                    'contentOptions' => [
                        'style' => 'text-align: center; font-weight: bolder;',
                    ],
                    'value' => function ($model) {
                        $status = ArrayHelper::getValue($model, 'CTR_STATUS');
                        $value = ArrayHelper::getValue($model, 'IS_GROSS_VERIFIED');

                        if ($value == 'Y') {
                            return '<span class="label label-success">'.$value.'</span>';
                        } elseif ($status == 'MTY') {
                            return '<span class="label label-default">'.$value.'</span>';
                        }

                        return '<span class="label label-danger">'.$value.'</span>';
                    }
                ],
                [
                    'attribute' => 'CTR_SIZE',
                    'label' => 'Size',
                    'headerOptions' => [
                        'style' => 'text-align: center;',
                    ],
                    'contentOptions' => [
                        'style' => 'text-align: center;',
                    ],
                ],
                [
                    'label' => 'Truck',
                    'attribute' => 'TRUCK_ID',
                    'format' => 'raw',
                    'contentOptions' => [
                        'style' => 'font-family: monospace;',
                    ],
                ],
                [
                    'label' => 'Gate In',
                    'options' => [],
                    'format' => 'raw',
                    'value' => function ($model) {
                        $value = ArrayHelper::getValue($model, 'GATE_IN_TIME');

                        if ($value) {
                            $date = date_create_from_format('d-m-Y H:i:s', $value);

                            if ($date) {
                                return '<span style="display: none;">'.$date->format('Y-m-d').'</span> '.$date->format('H:i');
                            }
                        }

                        return NULL;
                    }
                ],
                [
                    'label' => 'Gate Out',
                    'options' => [],
                    'format' => 'raw',
                    'value' => function ($model) {
                        $gate_out = ArrayHelper::getValue($model, 'GATE_OUT_TIME');

                        if ($gate_out) {
                            $date_out = date_create_from_format('d-m-Y H:i:s', $gate_out);

                            if ($date_out) {
                                return '<span style="display: none;">'.$date_out->format('Y-m-d').'</span> '.$date_out->format('H:i');
                            }
                        }

                        return NULL;
                    },
                    'contentOptions' => function ($model, $key, $index, $column) {
                        $gate_in = ArrayHelper::getValue($model, 'GATE_IN_TIME');
                        $gate_out = ArrayHelper::getValue($model, 'GATE_OUT_TIME');

                        if ($gate_in && $gate_out) {
                            $max_out = date_create_from_format('d-m-Y H:i:s', $gate_in);
                            $date_out = date_create_from_format('d-m-Y H:i:s', $gate_out);

                            if ($max_out && $date_out) {
                                $max_out->modify("+3 hours");

                                if ($date_out > $max_out) {
                                    return [
                                        'class' => 'label-warning',
                                    ];
                                }
                            }
                        }

                        return [];
                    },
                ],
                [
                    'attribute' => 'WEIGHT_IN_KG',
                    'label' => 'Weight In',
                    'headerOptions' => [
                        'class' => 'text-right',
                    ],
                    'contentOptions' => [
                        'class' => 'text-right',
                    ],
                ],
                [
                    'attribute' => 'WEIGHT_OUT_KG',
                    'label' => 'Weight Out',
                    'headerOptions' => [
                        'class' => 'text-right',
                    ],
                    'contentOptions' => function ($model, $key, $index, $column) {
                        $outmass = ArrayHelper::getValue($model, 'WEIGHT_OUT_KG', 0);
                        $status = ArrayHelper::getValue($model, 'CTR_STATUS');
                        $verified = ArrayHelper::getValue($model, 'IS_GROSS_VERIFIED');

                        if ($verified != 'Y' && $status == 'FCL') {
                            return [
                                'class' => 'text-right label-default',
                            ];
                        }

                        if (6000 < $outmass OR $status == 'MTY') {
                            return [
                                'class' => 'text-right',
                            ];
                        }

                        return [
                            'class' => 'text-right label-warning',
                        ];
                    },
                ],
                [
                    'attribute' => 'CTR_TYPE',
                    'label' => 'Type',
                    'headerOptions' => [
                        'style' => 'text-align: center;',
                    ],
                    'contentOptions' => [
                        'style' => 'text-align: center;',
                    ],
                ],
                [
                    'attribute' => 'CTR_STATUS',
                    'label' => 'Cargo',
                    'headerOptions' => [
                        'style' => 'text-align: center;',
                    ],
                    'contentOptions' => [
                        'style' => 'text-align: center;',
                    ],
                ],
            ],
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => FALSE, // pjax is set to always true for this demo
            // set your toolbar
            'toolbar' => [
                '{export}',
            ],
            // set export properties
            'export' => [
                'icon' => 'export',
                'label' => 'Export',
            ],
            // parameters from the demo form
            'bordered' => true,
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'hover' => true,
            'showPageSummary' => true,
            'panel' => [
                'type' => \kartik\grid\GridView::TYPE_PRIMARY,
                'heading' => 'Receiving '.$day.$from->format(' F Y'),
            ],
            'persistResize' => false,
            'exportConfig' => [
                \kartik\grid\GridView::EXCEL => [
                    'label' => 'Save as EXCEL',
                    'filename' => $from_value,
                ],
                \kartik\grid\GridView::PDF => [
                    'label' => 'Save as PDF',
                    'filename' => $from_value,
                ],
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
            'rowOptions' => function($model, $key, $index, $grid) {
                $status = ArrayHelper::getValue($model, 'CTR_STATUS');
                $vgm = ArrayHelper::getValue($model, 'IS_GROSS_VERIFIED');
                $gatein = ArrayHelper::getValue($model, 'GATE_IN_TIME');
                $now = new \DateTime;

                if ($gatein) {
                    $datein = date_create_from_format('d-m-Y H:i:s', $gatein);

                    if ($datein) {
                        $TRT_interval = $now->diff($datein);
                        $TRT_hour = $TRT_interval->format('%h');
                        $TRT_minute = $TRT_interval->format('%i');

                        if ($vgm != 'Y' && $status != 'MTY' && ($TRT_hour > 1 OR ( $TRT_hour > 0 && $TRT_minute > 30) )) {
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
    if ($autorefresh) {
        echo '<p>Generated: '.date('d F Y, H:i:s').'</p>';
    }
    ?>

</div>

<?php
if ($autorefresh OR $missed > 0) {
    $this->registerJs('setInterval(function(){ location.reload(); }, (1000*60*15));');
}
?>
