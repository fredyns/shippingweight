<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\web\JsExpression;

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

            <?php
            if (Yii::$app->user->identity->isAdmin == FALSE)
            {
                echo $form
                    ->field($model, 'user_id')
                    ->widget(Select2::classname(),
                        [
                        'initValueText' => ($model->userAccount) ? $model->userAccount->username : '-',
                        'options'       => ['placeholder' => 'Search for a options ...'],
                        'pluginOptions' => [
                            'allowClear'         => true,
                            'minimumInputLength' => 2,
                            'language'           => [
                                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                            ],
                            'ajax'               => [
                                'url'      => Url::to(['/user-account/options']),
                                'dataType' => 'json',
                                'data'     => new JsExpression('function(params) { return {term:params.term}; }')
                            ],
                            'escapeMarkup'       => new JsExpression('function (markup) { return markup; }'),
                            'templateResult'     => new JsExpression('function(selection) { return selection.text; }'),
                            'templateSelection'  => new JsExpression('function(selection) { return selection.text; }'),
                        ],
                ]);
            }
            ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'cp')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        </p>
        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items'        => [
                [
                    'label'   => Yii::t('app', StringHelper::basename('app\models\Shipper')),
                    'content' => $this->blocks['main'],
                    'active'  => true,
                ],
            ]
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

