<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Container $model
 */
$this->title                   = Yii::t('app', 'Container').$model->id.', '.'Edit';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Containers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string) $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud container-update">

    <h1>
        <?= Yii::t('app', 'Container') ?>
        <small>
            <?= $model->number ?>
        </small>
    </h1>

    <hr />

    <div class="crud-navigation">
        <?=
        Html::a('<span class="glyphicon glyphicon-eye-open"></span> '.'View', ['view', 'id' => $model->id],
            ['class' => 'btn btn-default'])
        ?>
    </div>

    <hr />

    <?php
    echo $this->render('_form', [
        'model' => $model,
    ]);
    ?>

</div>
