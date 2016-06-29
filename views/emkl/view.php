<?php

use dmstr\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
 * @var yii\web\View $this
 * @var app\models\Emkl $model
 */
$copyParams = $model->attributes;

$this->title                   = Yii::t('app', 'EMKL');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'EMKL'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string) $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud emkl-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('app', 'EMKL') ?>
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
                '<span class="glyphicon glyphicon-copy"></span> '.'Copy',
                ['create', 'id' => $model->id, 'Emkl' => $copyParams], ['class' => 'btn btn-success'])
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

    <?php $this->beginBlock('app\models\Emkl'); ?>


    <?=
    DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'name',
            'address:ntext',
            'phone',
            'npwp',
            'email:email',
            'created_by',
            'updated_by',
            'created_at:datetime',
            'updated_at:datetime',
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
    Tabs::widget([
        'id'           => 'relation-tabs',
        'encodeLabels' => false,
        'items'        => [
            [
                'label'   => '<b class=""># '.$model->id.'</b>',
                'content' => $this->blocks['app\models\Emkl'],
                'active'  => true,
            ],
        ],
    ]);
    ?>
</div>
