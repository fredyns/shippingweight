<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use app\models\Shipper;
use yii\helpers\Url;
use kartik\widgets\Select2;
use kartik\depdrop\DepDrop;
use yii\web\JsExpression;
use app\models\Container;

/**
 * @var yii\web\View $this
 * @var app\models\Container $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<style>
    .greynote {
        color: grey;
    }
</style>

<div class="container-form">

    <?php
    $form = ActiveForm::begin([
            'id'                     => 'Container',
            'options'                => ['class' => 'form-horizontal'],
            'fieldConfig'            => [
                'template'     => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                'labelOptions' => ['class' => 'col-lg-3 control-label'],
                'hintOptions'  => ['class' => 'col-lg-9'],
            ],
            'layout'                 => 'horizontal',
            'enableClientValidation' => true,
            'errorSummaryCssClass'   => 'error-summary alert alert-error'
            ]
    );
    ?>

    <div class="">

        <?php $this->beginBlock('shipper'); ?>

        <p>

            <?php
            if (Yii::$app->user->identity->isAdmin)
            {
                $userName = '-';

                if ($model->isNewRecord)
                {
                    $userName = Yii::$app->user->identity->username;
                }
                elseif ($model->shipper)
                {
                    if ($model->shipper->userAccount)
                    {
                        $userName = $model->shipper->userAccount->username;
                    }
                }

                echo <<<HTML
            <div class="form-group field-containerform-user">
                <label class="control-label col-sm-3" for="containerform-user">
                    User Name
                </label>
                <div class="col-sm-6">
                    <input value="{$userName}" type="text" id="user" class="form-control" name="user" readonly="readonly" disabled="disabled">
                </div>
            </div>
HTML;
            }
            ?>

            <?php
            $userScope_id = ($model->isNewRecord) ? Yii::$app->user->id : $model->created_by;

            echo $form
                ->field($model, 'shipper_id')
                ->widget(Select2::classname(),
                    [
                    'data'          => Shipper::options($userScope_id),
                    'pluginOptions' =>
                    [
                        'placeholder'        => 'Select or type option',
                        'multiple'           => FALSE,
                        'allowClear'         => TRUE,
                        'tags'               => TRUE,
                        'maximumInputLength' => 255, /* option name maxlength */
                    ],
            ]);
            ?>

            <?=
                $form
                ->field($model, 'shipper_address')
                ->textarea(['rows' => 6])
                ->hint('<i class="greynote">*sesuai yang tertera di NPWP</i>')
            ?>

            <?= $form->field($model, 'shipper_npwp')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'shipper_cp')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'shipper_phone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'shipper_email')->textInput(['maxlength' => true]) ?>

        </p>
        <?php $this->endBlock(); ?>

        <?php $this->beginBlock('container'); ?>

        <p>

            <?= $form->field($model, 'booking_number')->textInput(['maxlength' => true]) ?>

            <?php
            if ($model->status == Container::STATUS_VERIFIED)
            {
                echo $form
                    ->field($model, 'number')
                    ->textInput([
                        'maxlength' => true,
                        'readonly'  => 'readonly',
                        'disabled'  => 'disabled',
                    ])
                    ->hint('<i>Sudah ter-sertifikasi, tidak dapat diubah.</i>');
            }
            else
            {
                echo $form->field($model, 'number')->textInput(['maxlength' => true]);
            }
            ?>

        </p>
        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items'        => [
                [
                    'label'   => 'Container',
                    'content' => $this->blocks['container'],
                    'active'  => true,
                ],
            ],
        ]);
        ?>
        <hr/>

        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items'        => [
                [
                    'label'   => 'Shipper',
                    'content' => $this->blocks['shipper'],
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

<script>

    function shipper_check()
    {
        shipperInput = $('#containerform-shipper_id').val();

        if (shipperInput && isNaN(shipperInput))
        {
            shipperDetail_show();
        } else
        {
            shipperDetail_hide();
        }
    }

    function shipperDetail_show()
    {
        $('.field-containerform-shipper_address').show('blind');
        $('.field-containerform-shipper_npwp').show('blind');
        $('.field-containerform-shipper_cp').show('blind');
        $('.field-containerform-shipper_phone').show('blind');
        $('.field-containerform-shipper_email').show('blind');
    }

    function shipperDetail_hide()
    {
        $('.field-containerform-shipper_address').hide('blind');
        $('.field-containerform-shipper_npwp').hide('blind');
        $('.field-containerform-shipper_cp').hide('blind');
        $('.field-containerform-shipper_phone').hide('blind');
        $('.field-containerform-shipper_email').hide('blind');
    }

</script>

<?php
$js = <<<JS

	$(function () {
        $('.field-containerform-shipper_address').hide();
        $('.field-containerform-shipper_npwp').hide();
        $('.field-containerform-shipper_cp').hide();
        $('.field-containerform-shipper_phone').hide();
        $('.field-containerform-shipper_email').hide();

        $('select').on('select2:select', function (evt) {
            shipper_check();
        });
	});

JS;

$this->registerJs($js, \yii\web\View::POS_READY);
