<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use app\models\Shipper;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\web\JsExpression;

/**
 * @var yii\web\View $this
 * @var app\models\Container $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="container-form">

    <?php
    $form = ActiveForm::begin([
            'id'                     => 'Container',
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
            // input untuk admin
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

                echo $form
                    ->field($model, 'shipper_id')
                    ->widget(DepDrop::classname(),
                        [
                        'data'           => [],
                        'type'           => DepDrop::TYPE_SELECT2,
                        'select2Options' => [
                            'pluginOptions' => [
                                'multiple'           => FALSE,
                                'allowClear'         => TRUE,
                                'tags'               => TRUE,
                                'maximumInputLength' => 255, /* shipper name maxlength */
                            ],
                        ],
                        'pluginOptions'  => [
                            'initialize'  => TRUE,
                            'placeholder' => 'Select or type options',
                            'depends'     => ['containerform-user_id'],
                            'url'         => Url::to([
                                '/shipper/depdrop-options',
                                'selected' => $model->shipper_id,
                            ]),
                            'loadingText' => 'Loading options ...',
                        ],
                ]);
            }
            // input untuk user EMKL
            else
            {
                echo $form
                    ->field($model, 'shipper_id')
                    ->widget(Select2::classname(),
                        [
                        'data'          => Shipper::options(),
                        'pluginOptions' =>
                        [
                            'placeholder'        => 'Select or type option',
                            'multiple'           => FALSE,
                            'allowClear'         => TRUE,
                            'tags'               => TRUE,
                            'maximumInputLength' => 255, /* option name maxlength */
                        ],
                ]);
            }
            ?>

            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

        </p>
        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items'        => [ [
                    'label'   => Yii::t('app', StringHelper::basename('app\models\Container')),
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

