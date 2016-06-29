<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\widget\ContainerMenu;

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
                    'class'     => yii\grid\DataColumn::className(),
                    'label'     => 'User',
                    'attribute' => 'user_id',
                    'options'   => [],
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
                    'format'  => 'raw',
                    'visible' => Yii::$app->user->identity->isAdmin,
                ],
                'number',
                [
                    'class'     => yii\grid\DataColumn::className(),
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
                [
                    'attribute' => 'status',
                    'format'    => 'html',
                    'value'     => function ($model)
                    {
                        return ContainerMenu::widget(['model' => $model]);
                    }
                    ],
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
