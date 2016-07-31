<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\ReportDaily $model
*/

$this->title = Yii::t('app', 'ReportDaily') . $model->day . ', ' . 'Edit';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ReportDailies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->day, 'url' => ['view', 'day' => $model->day]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud report-daily-update">

    <h1>
        <?= Yii::t('app', 'ReportDaily') ?>
        <small>
                        <?= $model->day ?>        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> ' . 'View', ['view', 'day' => $model->day], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
