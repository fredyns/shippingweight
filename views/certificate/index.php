<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\CertificateSearch $searchModel
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
<div class="giiant-crud certificate-index">

    <?php
    \yii\widgets\Pjax::begin([
        'id'                 => 'pjax-main',
        'enableReplaceState' => false,
        'linkSelector'       => '#pjax-main ul.pagination a, th a',
        'clientOptions'      => ['pjax:success' => 'function(){alert("yo")}'],
    ])
    ?>

    <h1>
        <?= Yii::t('app', 'Certificates') ?>
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
            'layout'           => '{summary}{pager}{items}{pager}',
            'dataProvider'     => $dataProvider,
            'pager'            => [
                'class'          => yii\widgets\LinkPager::className(),
                'firstPageLabel' => 'First',
                'lastPageLabel'  => 'Last',
            ],
            'filterModel'      => $searchModel,
            'tableOptions'     => ['class' => 'table table-striped table-bordered table-hover'],
            'headerRowOptions' => ['class' => 'x'],
            'columns'          => [
                [
                    'class'      => 'yii\grid\ActionColumn',
                    'template'   => $actionColumnTemplateString,
                    'options'    => [],
                    'urlCreator' => function($action, $model, $key, $index)
                {
                    // using the column name as key, not mapping to 'id' like the standard generator
                    $params    = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                    $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id.'/'.$action : $action;
                    return Url::toRoute($params);
                },
                    'contentOptions' => ['nowrap' => 'nowrap']
                ],
                'vgm_number',
                'container_number',
                'vgm_gross',
                'vgm_date:date',
                'shipper_name',
            //'stack_at',
            //'download_at',
            //'shipper_address:ntext',
            /* 'dwelling_time:datetime', */
            /* 'booking_number', */
            ],
        ]);
        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


