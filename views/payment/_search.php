<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\PaymentSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="payment-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'customer_id') ?>

		<?= $form->field($model, 'container_list') ?>

		<?= $form->field($model, 'note') ?>

		<?= $form->field($model, 'subtotal') ?>

		<?php // echo $form->field($model, 'discount') ?>

		<?php // echo $form->field($model, 'total') ?>

		<?php // echo $form->field($model, 'status') ?>

		<?php // echo $form->field($model, 'created_by') ?>

		<?php // echo $form->field($model, 'updated_by') ?>

		<?php // echo $form->field($model, 'paid_by') ?>

		<?php // echo $form->field($model, 'cancel_by') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

		<?php // echo $form->field($model, 'paid_at') ?>

		<?php // echo $form->field($model, 'cancel_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
