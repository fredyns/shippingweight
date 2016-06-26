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

    <?php
    $form = ActiveForm::begin([
            'id'                     => 'Certificate',
            'layout'                 => 'horizontal',
            'enableClientValidation' => true,
            'errorSummaryCssClass'   => 'error-summary alert alert-error'
            ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>

            <?=
            $form->field($model, 'shipper_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(app\models\Shipper::find()->all(), 'id', 'name'), ['prompt' => 'Select']
            );
            ?>

            <?=
            $form->field($model, 'shipment_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(app\models\Shipment::find()->all(), 'id', 'id'), ['prompt' => 'Select']
            );
            ?>

            <?=
            $form->field($model, 'weighing_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(app\models\Weighing::find()->all(), 'id', 'id'), ['prompt' => 'Select']
            );
            ?>

            <?= $form->field($model, 'date')->textInput() ?>

            <?= $form->field($model, 'job_order')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'grossmass')->textInput() ?>

            <?= $form->field($model, 'container_number')->textInput(['maxlength' => true]) ?>


        </p>
        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget(
            [
                'encodeLabels' => false,
                'items'        => [ [
                        'label'   => Yii::t('app', StringHelper::basename('app\models\Certificate')),
                        'content' => $this->blocks['main'],
                        'active'  => true,
                    ],]
            ]
        );
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

