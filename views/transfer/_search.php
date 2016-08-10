<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\TransferSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="transfer-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'time') ?>

		<?= $form->field($model, 'from') ?>

		<?= $form->field($model, 'amount') ?>

		<?= $form->field($model, 'containerCount') ?>

		<?php // echo $form->field($model, 'containerList_all') ?>

		<?php // echo $form->field($model, 'containerList_confirmed') ?>

		<?php // echo $form->field($model, 'containerList_missed') ?>

		<?php // echo $form->field($model, 'note') ?>

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
