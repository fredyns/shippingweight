<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\Payment;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\PaymentSearch $searchModel
 */
$this->title                   = Yii::t('app', 'Payments');
$this->params['breadcrumbs'][] = $this->title;

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
<div class="giiant-crud payment-index">

    <?php
    \yii\widgets\Pjax::begin([
        'id'                 => 'pjax-main',
        'enableReplaceState' => false,
        'linkSelector'       => '#pjax-main ul.pagination a, th a',
        'clientOptions'      => ['pjax:success' => 'function(){alert("yo")}'],
    ])
    ?>

    <h1>
        <?= Yii::t('app', 'Payments') ?>
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
        <?=
        GridView::widget([
            'layout'           => '{summary}{pager}{items}{pager}',
            'dataProvider'     => $dataProvider,
            'pager'            => [
                'class'          => yii\widgets\LinkPager::className(),
                'firstPageLabel' => 'First',
                'lastPageLabel'  => 'Last'
            ],
            'filterModel'      => $searchModel,
            'tableOptions'     => ['class' => 'table table-striped table-bordered table-hover'],
            'headerRowOptions' => ['class' => 'x'],
            'columns'          => [
                [
                    'class'     => yii\grid\DataColumn::className(),
                    'attribute' => 'customer_id',
                    'options'   => [],
                    'value'     => function ($model)
                {
                    if ($rel = $model->getCustomer()->one())
                    {
                        return Html::a($rel->name, ['customer/view', 'id' => $rel->id,], ['data-pjax' => 0]);
                    }
                    else
                    {
                        return '';
                    }
                },
                    'format' => 'raw',
                ],
                'total',
                [
                    'attribute' => 'status',
                    'value'     => function ($model)
                    {
                        if ($model->status == Payment::STATUS_BILLED)
                        {
                            return \yii\i18n\Formatter::asDate($model->paid_at, 'php:M jS Y');
                        }

                        return app\models\Payment::getStatusValueLabel($model->status);
                    }
                ],
                'paid_at:date',
                [
                    'class'      => 'yii\grid\ActionColumn',
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
        ]);
        ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


