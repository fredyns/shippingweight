<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\Certificate $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="certificate-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Certificate',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            
			<?= $form->field($model, 'id')->textInput() ?>
			<?= $form->field($model, 'vgm_number')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'vgm_date')->textInput() ?>
			<?= $form->field($model, 'vgm_gross')->textInput() ?>
			<?= $form->field($model, 'container_number')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'booking_number')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'shipper_name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'shipper_address')->textarea(['rows' => 6]) ?>
			<?= $form->field($model, 'stack_at')->textInput() ?>
			<?= $form->field($model, 'download_at')->textInput() ?>
			<?= $form->field($model, 'dwelling_time')->textInput() ?>
			<?= $form->field($model, 'created_by')->textInput() ?>
			<?= $form->field($model, 'updated_by')->textInput() ?>
			<?= $form->field($model, 'created_at')->textInput() ?>
			<?= $form->field($model, 'updated_at')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                   'encodeLabels' => false,
                     'items' => [ [
    'label'   => Yii::t('app', StringHelper::basename('app\models\Certificate')),
    'content' => $this->blocks['main'],
    'active'  => true,
], ]
                 ]
    );
    ?>
        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? 'Create' : 'Save'),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

