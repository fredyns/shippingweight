<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\CertificateSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="certificate-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'shipper_id') ?>

		<?= $form->field($model, 'shipment_id') ?>

		<?= $form->field($model, 'weighing_id') ?>

		<?= $form->field($model, 'date') ?>

		<?php // echo $form->field($model, 'job_order') ?>

		<?php // echo $form->field($model, 'grossmass') ?>

		<?php // echo $form->field($model, 'container_number') ?>

		<?php // echo $form->field($model, 'created_by') ?>

		<?php // echo $form->field($model, 'updated_by') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
