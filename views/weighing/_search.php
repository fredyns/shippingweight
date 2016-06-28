<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\WeighingSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="weighing-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'container_number') ?>

		<?= $form->field($model, 'date') ?>

		<?= $form->field($model, 'grossmass') ?>

		<?= $form->field($model, 'job_order') ?>

		<?php // echo $form->field($model, 'emkl_name') ?>

		<?php // echo $form->field($model, 'emkl_email') ?>

		<?php // echo $form->field($model, 'gatein_grossmass') ?>

		<?php // echo $form->field($model, 'gatein_trackNumber') ?>

		<?php // echo $form->field($model, 'gateout_grossmass') ?>

		<?php // echo $form->field($model, 'gateout_trackNumber') ?>

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
