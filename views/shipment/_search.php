<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\ShipmentSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="shipment-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'shipper_id') ?>

		<?= $form->field($model, 'container_number') ?>

		<?= $form->field($model, 'container_status') ?>

		<?= $form->field($model, 'payment_status') ?>

		<?php // echo $form->field($model, 'payment_bill') ?>

		<?php // echo $form->field($model, 'payment_date') ?>

		<?php // echo $form->field($model, 'payment_by') ?>

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
