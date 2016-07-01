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
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var app\models\Container $model
 */
$this->title                   = Yii::t('app', 'Container').' '.$model->id.', '.'Payment';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Containers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string) $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Payment';
?>
<div class="giiant-crud container-update">

    <h1>
        <?= Yii::t('app', 'Container') ?>
        <small>
            Payment
        </small>
    </h1>

    <hr />

    <div class="crud-navigation">
        <?=
        Html::a('<span class="glyphicon glyphicon-eye-open"></span> '.'View', ['view', 'id' => $model->id],
            ['class' => 'btn btn-default'])
        ?>
    </div>

    <hr />

    <?=
    DetailView::widget([
        'model'      => $model,
        'attributes' => [
            [
                'format'    => 'html',
                'attribute' => 'shipper_id',
                'value'     => ($model->getShipper()->one() ? Html::a($model->getShipper()->one()->name,
                        ['shipper/view', 'id' => $model->getShipper()->one()->id,]) : '<span class="label label-warning">?</span>'),
            ],
            'number',
            'status',
        ],
    ]);
    ?>


    <hr/>

    <div class="container-form">

        <?php
        $form                          = ActiveForm::begin([
                'id'                     => 'Container',
                'layout'                 => 'horizontal',
                'enableClientValidation' => true,
                'errorSummaryCssClass'   => 'error-summary alert alert-error'
                ]
        );
        ?>

        <div class="">

            <p>

                <?= $form->field($model, 'bill')->textInput(['maxlength' => true]) ?>

            </p>

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

</div>
