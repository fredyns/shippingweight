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

		<?= $form->field($model, 'vgm_number') ?>

		<?= $form->field($model, 'vgm_date') ?>

		<?= $form->field($model, 'vgm_gross') ?>

		<?= $form->field($model, 'container_number') ?>

		<?php // echo $form->field($model, 'booking_number') ?>

		<?php // echo $form->field($model, 'shipper_name') ?>

		<?php // echo $form->field($model, 'shipper_address') ?>

		<?php // echo $form->field($model, 'stack_at') ?>

		<?php // echo $form->field($model, 'download_at') ?>

		<?php // echo $form->field($model, 'dwelling_time') ?>

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
