<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\ContainerSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="container-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'shipper_id') ?>

		<?= $form->field($model, 'number') ?>

		<?= $form->field($model, 'status') ?>

		<?= $form->field($model, 'bill') ?>

		<?php // echo $form->field($model, 'grossmass') ?>

		<?php // echo $form->field($model, 'weighing_date') ?>

		<?php // echo $form->field($model, 'certificate_file') ?>

		<?php // echo $form->field($model, 'payment_by') ?>

		<?php // echo $form->field($model, 'created_by') ?>

		<?php // echo $form->field($model, 'updated_by') ?>

		<?php // echo $form->field($model, 'billed_by') ?>

		<?php // echo $form->field($model, 'verified_by') ?>

		<?php // echo $form->field($model, 'checked_by') ?>

		<?php // echo $form->field($model, 'sentOwner_by') ?>

		<?php // echo $form->field($model, 'sentShipper_by') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

		<?php // echo $form->field($model, 'billed_at') ?>

		<?php // echo $form->field($model, 'checked_at') ?>

		<?php // echo $form->field($model, 'verified_at') ?>

		<?php // echo $form->field($model, 'sentOwner_at') ?>

		<?php // echo $form->field($model, 'sentShipper_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
