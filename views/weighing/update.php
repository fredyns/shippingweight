<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Weighing $model
 */
$this->title                   = Yii::t('app', 'Weighing').$model->id.', '.'Edit';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Weighings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string) $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud weighing-update">

    <h1>
        <?= Yii::t('app', 'Weighing') ?>
        <small>
            <?= $model->id ?>
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
