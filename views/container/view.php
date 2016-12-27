<?php

use dmstr\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
use app\widget\ContainerMenu;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var app\models\Container $model
 */
$copyParams = $model->attributes;

$this->title = Yii::t('app', 'Container');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Containers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string) $model->number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud container-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </div>
    <?php endif; ?>

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('error') !== null) : ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <?= implode('<br/>', Yii::$app->session->getFlash('error')) ?>
        </div>
    <?php endif; ?>

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('info') !== null) : ?>
        <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <?= implode('<br/>', Yii::$app->session->getFlash('info')) ?>
        </div>
    <?php endif; ?>

    <h1>
        <?= Yii::t('app', 'Container') ?>
        <small>
            <?= $model->number ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?=
            Html::a(
                '<span class="glyphicon glyphicon-pencil"></span> '.'Edit', ['update', 'id' => $model->id],
                ['class' => 'btn btn-info'])
            ?>

            <?=
            Html::a(
                '<span class="glyphicon glyphicon-copy"></span> '.'Copy',
                ['create', 'id' => $model->id, 'ContainerForm' => $copyParams], ['class' => 'btn btn-success'])
            ?>

            <?= ContainerMenu::widget(['model' => $model]); ?>

        </div>

        <div class="pull-right">
            <?=
            Html::a('<span class="glyphicon glyphicon-list"></span> '
                .'Full list', ['index'], ['class' => 'btn btn-default'])
            ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('app\models\Container'); ?>


    <?php
    $grossmass = ArrayHelper::getValue($model, 'grossmass');
    $in_mass = ArrayHelper::getValue($model, 'weighing.gatein_grossmass');
    $out_mass = ArrayHelper::getValue($model, 'weighing.gateout_grossmass');

    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
                [
                'format' => 'html',
                'attribute' => 'shipper_id',
                'value' => ($model->getShipper()->one() ? Html::a($model->getShipper()->one()->name,
                        ['shipper/view', 'id' => $model->getShipper()->one()->id,]) : '<span class="label label-warning">?</span>'),
            ],
            'booking_number',
            'number',
                [
                'attribute' => 'status',
                'visible' => (Yii::$app->user->identity->isAdmin),
                'value' => app\models\Container::getStatusValueLabel($model->status),
            ],
                [
                'label' => 'Grossmass',
                'value' => ($grossmass ? $grossmass.' KG' : ''),
            ],
                [
                'label' => 'Gate In Time',
                'attribute' => 'weighing.gatein_datetime',
                'format' => [
                    'date',
                    'dateFormat' => 'php:d M Y, H:i',
                ],
            ],
                [
                'label' => 'Gate In Weight',
                'value' => ($in_mass ? $in_mass.' KG' : ''),
            ],
                [
                'label' => 'Gate Out Time',
                'attribute' => 'weighing_date',
                'format' => [
                    'date',
                    'dateFormat' => 'php:d M Y, H:i',
                ],
            ],
                [
                'label' => 'Gate Out Weight',
                'value' => ($out_mass ? $out_mass.' KG' : ''),
            ],
        ],
    ]);
    ?>


    <hr/>

    <?=
    Html::a('<span class="glyphicon glyphicon-trash"></span> '.'Delete', ['delete', 'id' => $model->id],
        [
        'class' => 'btn btn-danger',
        'data-confirm' => ''.'Are you sure to delete this item?'.'',
        'data-method' => 'post',
    ]);
    ?>

    <?php $this->endBlock(); ?>

    <?php $this->beginBlock('ContainerInfo'); ?>


    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
                [
                'label' => 'Username',
                'value' => ArrayHelper::getValue($model, 'shipper.userAccount.username', '-'),
            ],
                [
                'label' => 'Email',
                'value' => ArrayHelper::getValue($model, 'shipper.userAccount.email', '-'),
            ],
                [
                'attribute' => 'created_by',
                'visible' => (Yii::$app->user->identity->isAdmin),
            ],
                [
                'attribute' => 'updated_by',
                'visible' => (Yii::$app->user->identity->isAdmin),
            ],
                [
                'attribute' => 'billed_by',
                'visible' => (Yii::$app->user->identity->isAdmin),
            ],
                [
                'attribute' => 'checked_by',
                'visible' => (Yii::$app->user->identity->isAdmin),
            ],
                [
                'attribute' => 'verified_by',
                'visible' => (Yii::$app->user->identity->isAdmin),
            ],
                [
                'attribute' => 'sentOwner_by',
                'visible' => (Yii::$app->user->identity->isAdmin),
            ],
                [
                'attribute' => 'sentShipper_by',
                'visible' => (Yii::$app->user->identity->isAdmin),
            ],
                [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'visible' => (Yii::$app->user->identity->isAdmin),
            ],
                [
                'attribute' => 'updated_at',
                'format' => 'datetime',
                'visible' => (Yii::$app->user->identity->isAdmin),
            ],
                [
                'attribute' => 'billed_at',
                'format' => 'datetime',
                'visible' => (Yii::$app->user->identity->isAdmin),
            ],
                [
                'attribute' => 'checked_at',
                'format' => 'datetime',
                'visible' => (Yii::$app->user->identity->isAdmin),
            ],
                [
                'attribute' => 'verified_at',
                'format' => 'datetime',
                'visible' => (Yii::$app->user->identity->isAdmin),
            ],
                [
                'attribute' => 'sentOwner_at',
                'format' => 'datetime',
                'visible' => (Yii::$app->user->identity->isAdmin),
            ],
                [
                'attribute' => 'sentShipper_at',
                'format' => 'datetime',
                'visible' => (Yii::$app->user->identity->isAdmin),
            ],
        ],
    ]);
    ?>


    <hr/>

    <?php $this->endBlock(); ?>




    <?=
    Tabs::widget([
        'id' => 'relation-tabs',
        'encodeLabels' => false,
        'items' => [
                [
                'label' => '<b class=""># '.$model->id.'</b>',
                'content' => $this->blocks['app\models\Container'],
                'active' => true,
            ],
                [
                'label' => '<small>Info</small>',
                'content' => $this->blocks['ContainerInfo'],
                'active' => false,
                'visible' => (Yii::$app->user->identity->isAdmin),
            ],
        ],
    ]);
    ?>
</div>
