<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Payment $model
 */
$this->title                   = 'Create';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud payment-create">

    <h1>
        <?= Yii::t('app', 'Payment') ?>
        <small>
            <?= $model->id ?>
        </small>
    </h1>

    <hr />

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=
            Html::a(
                'Cancel', \yii\helpers\Url::previous(), ['class' => 'btn btn-default'])
            ?>
        </div>
    </div>

    <hr />

    <?=
    $this->render('_form', [
        'model' => $model,
    ]);
    ?>

</div>
