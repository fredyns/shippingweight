<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var app\models\Payment $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="payment-form">

    <?php
    $form = ActiveForm::begin([
            'id'                     => 'Payment',
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
            $form->field($model, 'customer_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(app\models\Customer::find()->all(), 'id', 'name'), ['prompt' => 'Select']
            );
            ?>
            <?= $form->field($model, 'total')->textInput() ?>
            <?=
            $form->field($model, 'status')->dropDownList(
                app\models\Payment::optsstatus()
            );
            ?>
        </p>
        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget(
            [
                'encodeLabels' => false,
                'items'        => [ [
                        'label'   => Yii::t('app', StringHelper::basename('app\models\Payment')),
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

