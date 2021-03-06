<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var app\models\Weighing $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="weighing-form">

    <?php
    $form = ActiveForm::begin([
            'id'                     => 'Weighing',
            'layout'                 => 'horizontal',
            'enableClientValidation' => true,
            'errorSummaryCssClass'   => 'error-summary alert alert-error'
            ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>

            <?= $form->field($model, 'job_order')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'container_number')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'grossmass')->textInput() ?>

            <?= $form->field($model, 'stack_datetime')->textInput() ?>

            <?= $form->field($model, 'gatein_grossmass')->textInput() ?>

            <?= $form->field($model, 'gatein_tracknumber')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'gateout_grossmass')->textInput() ?>

            <?= $form->field($model, 'gateout_tracknumber')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'emkl_id')->textInput() ?>

            <?= $form->field($model, 'container_id')->textInput() ?>

        </p>
        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items'        => [
                [
                    'label'   => Yii::t('app', StringHelper::basename('app\models\Weighing')),
                    'content' => $this->blocks['main'],
                    'active'  => true,
                ],
            ],
        ]);
        ?>
        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?=
        Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> '.
            ($model->isNewRecord ? 'Create' : 'Save'),
            [
            'id'    => 'save-'.$model->formName(),
            'class' => 'btn btn-success'
            ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

