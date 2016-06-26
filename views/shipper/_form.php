<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var app\models\Shipper $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="shipper-form">

    <?php
    $form = ActiveForm::begin([
            'id'                     => 'Shipper',
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
            $form->field($model, 'user_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(app\models\Profile::find()->all(), 'user_id', 'name'),
                ['prompt' => 'Select']
            );
            ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'cp')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        </p>
        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget(
            [
                'encodeLabels' => false,
                'items'        => [ [
                        'label'   => Yii::t('app', StringHelper::basename('app\models\Shipper')),
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

