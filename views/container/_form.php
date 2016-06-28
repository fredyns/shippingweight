<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\Container $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="container-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Container',
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
			<?= // generated by schmunk42\giiant\generators\crud\providers\RelationProvider::activeField
$form->field($model, 'shipper_id')->dropDownList(
    \yii\helpers\ArrayHelper::map(app\models\Shipper::find()->all(), 'id', 'name'),
    ['prompt' => 'Select']
); ?>
			<?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
			<?=                         $form->field($model, 'status')->dropDownList(
                            app\models\Container::optsstatus()
                        ); ?>
			<?= $form->field($model, 'bill')->textInput() ?>
			<?= $form->field($model, 'grossmass')->textInput() ?>
			<?= $form->field($model, 'weighing_date')->textInput() ?>
			<?= $form->field($model, 'certificate_file')->textarea(['rows' => 6]) ?>
			<?= $form->field($model, 'payment_by')->textInput() ?>
			<?= $form->field($model, 'created_by')->textInput() ?>
			<?= $form->field($model, 'updated_by')->textInput() ?>
			<?= $form->field($model, 'billed_by')->textInput() ?>
			<?= $form->field($model, 'verified_by')->textInput() ?>
			<?= $form->field($model, 'checked_by')->textInput() ?>
			<?= $form->field($model, 'sentOwner_by')->textInput() ?>
			<?= $form->field($model, 'sentShipper_by')->textInput() ?>
			<?= $form->field($model, 'created_at')->textInput() ?>
			<?= $form->field($model, 'updated_at')->textInput() ?>
			<?= $form->field($model, 'billed_at')->textInput() ?>
			<?= $form->field($model, 'checked_at')->textInput() ?>
			<?= $form->field($model, 'verified_at')->textInput() ?>
			<?= $form->field($model, 'sentOwner_at')->textInput() ?>
			<?= $form->field($model, 'sentShipper_at')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                   'encodeLabels' => false,
                     'items' => [ [
    'label'   => Yii::t('app', StringHelper::basename('app\models\Container')),
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
