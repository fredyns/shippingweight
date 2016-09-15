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
            'id'     => 'Api',
            'method' => 'POST',
            'action' => ['certification'],
            ]
    );
    ?>

    <div class="">

        <p>
            IS_GROSS_VERIFIED:<br/>
            <?= Html::textInput('containers[C1][IS_GROSS_VERIFIED]'); ?>
        </p>

        <p>
            GROSS_VERIFIED_TIME:<br/>
            <?= Html::textInput('containers[C1][GROSS_VERIFIED_TIME]'); ?>
        </p>

        <p>
            GROSS_KG:<br/>
            <?= Html::textInput('containers[C1][GROSS_KG]'); ?>
        </p>

        <p>
            JOB_ORDER_NO:<br/>
            <?= Html::textInput('containers[C1][JOB_ORDER_NO]'); ?>
        </p>

        <p>
            CUSTOMER_ID:<br/>
            <?= Html::textInput('containers[C1][CUSTOMER_ID]'); ?>
        </p>

        <p>
            WEIGHT_IN_KG:<br/>
            <?= Html::textInput('containers[C1][WEIGHT_IN_KG]'); ?>
        </p>

        <p>
            WEIGHT_OUT_KG:<br/>
            <?= Html::textInput('containers[C1][WEIGHT_OUT_KG]'); ?>
        </p>

        <p>
            TRUCK_ID:<br/>
            <?= Html::textInput('containers[C1][TRUCK_ID]'); ?>
        </p>

        <?=
        Html::submitButton('<span class="glyphicon glyphicon-check"></span> POSST', [ 'class' => 'btn btn-success']);
        ?>

        <?php ActiveForm::end(); ?>

    </div>

    <br/>
    <hr/>
    <br/>

    <pre>
        <?= print_r(Yii::$app->request->post(), TRUE); ?>
    </pre>

</div>

