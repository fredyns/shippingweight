<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\jui\DatePicker;

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
            $form->field($model, 'vgm_date')->widget(DatePicker::classname(), ['dateFormat' => 'yyyy-MM-dd'])
            ?>

            <?php //= $form->field($model, 'vgm_number')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'vgm_gross')->textInput() ?>

            <?= $form->field($model, 'container_number')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'shipper_name')->textInput(['maxlength' => true]) ?>

        </p>
        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget(
            [
                'encodeLabels' => false,
                'items'        => [
                    [
                        'label'   => Yii::t('app', StringHelper::basename('app\models\Certificate')),
                        'content' => $this->blocks['main'],
                        'active'  => true,
                    ],
                ]
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

