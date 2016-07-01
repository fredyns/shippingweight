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

            <?= $form->field($model, 'shipper_address')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'shipper_email')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'booking_number')->textInput(['maxlength' => true]) ?>

        </p>
        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items'        => [
                [
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
        $('.field-containerform-shipper_email').show('blind');
    }

    function shipperDetail_hide()
    {
        $('.field-containerform-shipper_address').hide('blind');
        $('.field-containerform-shipper_email').hide('blind');
    }

</script>

<?php
$js = <<<JS

	$(function () {
        $('.field-containerform-shipper_address').hide();
        $('.field-containerform-shipper_email').hide();

        $('select').on('select2:select', function (evt) {
            shipper_check();
        });
	});

JS;

$this->registerJs($js, \yii\web\View::POS_READY);
