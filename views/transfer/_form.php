<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use kartik\datetime\DateTimePicker;

/**
 * @var yii\web\View $this
 * @var app\models\Transfer $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="transfer-form">

    <?php
    $form = ActiveForm::begin([
            'id'                     => 'Transfer',
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
                $form->field($model, 'time')
                ->widget(DateTimePicker::classname(),
                    [
                    'type'          => DateTimePicker::TYPE_COMPONENT_APPEND,
                    'options'       => ['placeholder' => 'Enter time ...'],
                    'pluginOptions' => [
                        'autoclose' => true
                    ],
            ]);
            ?>
            <?= $form->field($model, 'from')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'amount')->textInput() ?>
            <?= $form->field($model, 'containerList_all')->textarea(['rows' => 10])->label('Container List')->hint('nomor kontainer dipisahkan tanda koma atau spasi.') ?>
            <?= $form->field($model, 'note')->textarea(['rows' => 4]) ?>

        </p>
        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget(
            [
                'encodeLabels' => false,
                'items'        => [
                    [
                        'label'   => Yii::t('app', StringHelper::basename('app\models\Transfer')),
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

