<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var app\models\Payment $model
 */
$this->title                   = 'Create';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud payment-create">

    <h1>
        <?= Yii::t('app', 'Payment') ?>
        <small>
            <?= $model->id ?>
        </small>
    </h1>

    <hr />

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=
            Html::a(
                'Cancel', \yii\helpers\Url::previous(), ['class' => 'btn btn-default'])
            ?>
        </div>
    </div>

    <hr />

    <div class="">

        <?php $this->beginBlock('ContainerSearch'); ?>

        <div class="container-search">

            <br/>

            <?php
            $form                          = ActiveForm::begin([
                    'method'                 => 'get',
                    'id'                     => 'PaymentContainer',
                    'layout'                 => 'horizontal',
                    'enableClientValidation' => true,
                    'errorSummaryCssClass'   => 'error-summary alert alert-error'
            ]);
            ?>

            <?= $form->field($containerSearch, 'number')->textarea(['row' => 6]); ?>

            <div class="form-group clearfix crud-navigation">
                <div class="pull-right">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

        <?php $this->endBlock(); ?>

        <?php $this->beginBlock('Payment'); ?>

        <div class="payment-form">

            <?php
            $form                          = ActiveForm::begin([
                    'id'                     => 'Payment',
                    'layout'                 => 'horizontal',
                    'enableClientValidation' => true,
                    'errorSummaryCssClass'   => 'error-summary alert alert-error'
                    ]
            );
            ?>

            <div class="">

                <p>

                    <?=
                        $form
                        ->field($model, 'customer_id')
                        ->widget(Select2::classname(),
                            [
                            'initValueText' => ($model->customer) ? $model->customer->name : '-',
                            'options'       => ['placeholder' => 'Search for a options ...'],
                            'pluginOptions' => [
                                'placeholder'        => 'Select or type option',
                                'multiple'           => FALSE,
                                'tags'               => TRUE,
                                'maximumInputLength' => 255, /* option name maxlength */
                                'allowClear'         => true,
                                'minimumInputLength' => 2,
                                'language'           => [
                                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                ],
                                'ajax'               => [
                                    'url'      => Url::to(['/customer/options']),
                                    'dataType' => 'json',
                                    'data'     => new JsExpression('function(params) { return {term:params.term}; }')
                                ],
                                'escapeMarkup'       => new JsExpression('function (markup) { return markup; }'),
                                'templateResult'     => new JsExpression('function(selection) { return selection.text; }'),
                                'templateSelection'  => new JsExpression('function(selection) { return selection.text; }'),
                            ],
                    ]);
                    ?>

                    <?= $form->field($model, 'customer_address')->textarea(['row' => 2]); ?>

                    <?= $form->field($model, 'customer_phone')->textInput() ?>

                </p>

                <?php
                echo $form->field($model, 'containers')->begin();

                Pjax::begin([
                    'id'                 => 'pjax-Containers',
                    'enableReplaceState' => false,
                    'linkSelector'       => '#pjax-Containers ul.pagination a, th a',
                    'clientOptions'      => ['pjax:success' => 'function(){alert("yo")}'],
                ]);

                echo '<div class="table-responsive">'
                .\yii\grid\GridView::widget([
                    'layout'       => '{summary}{pager}<br/>{items}{pager}',
                    'dataProvider' => $containersData,
                    'pager'        => [
                        'class'          => yii\widgets\LinkPager::className(),
                        'firstPageLabel' => 'First',
                        'lastPageLabel'  => 'Last',
                    ],
                    'columns'      => [
                        [
                            'options' => [],
                            'format'  => 'raw',
                            'value'   => function ($model)
                        {
                            return Html::checkbox(
                                    'PaymentForm[containers][]', TRUE,
                                    [
                                    'value' => $model->id,
                                    'class' => 'paymentcontainers',
                                    ]
                            );
                        },
                        ],
                        'number',
                        'booking_number',
                        [
                            'class'     => yii\grid\DataColumn::className(),
                            'attribute' => 'shipper_id',
                            'options'   => [],
                            'value'     => function ($model)
                        {
                            if ($rel = $model->getShipper()->one())
                            {
                                return $rel->name;
                            }
                            else
                            {
                                return '';
                            }
                        },
                            'format' => 'raw',
                        ],
                        'bill',
                    ]
                ])
                .'</div>';

                Pjax::end();

                echo Html::error($model, 'containers', ['class' => 'help-block']); //error
                echo $form->field($model, 'containers')->end();
                ?>

                <hr/>

                <p>

                    <?= $form->field($model, 'total')->textInput() ?>

                    <?= $form->field($model, 'note')->textarea(['row' => 2]); ?>

                </p>

                <?php echo $form->errorSummary($model); ?>

                <div class="clearfix crud-navigation">
                    <div class="pull-right">
                        <?=
                        Html::submitButton(
                            '<span class="glyphicon glyphicon-check"></span> Confirm Payment',
                            [
                            'id'    => 'save-'.$model->formName(),
                            'class' => 'btn btn-success'
                            ]
                        );
                        ?>

                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>

        </div>

        <?php $this->endBlock(); ?>

        <?php
        $paymentForm = (empty($containerSearch->number) == FALSE);

        echo Tabs::widget([
            'id'           => 'relation-tabs',
            'encodeLabels' => false,
            'items'        => [
                [
                    'label'   => 'Search Container',
                    'content' => $this->blocks['ContainerSearch'],
                    'active'  => ($paymentForm == FALSE),
                ],
                [
                    'label'   => 'Payment Detail',
                    'content' => $this->blocks['Payment'],
                    'active'  => ($paymentForm),
                ],
            ],
        ]);
        ?>
    </div>
</div>

<script>

    function customer_check()
    {
        customerInput = $('#paymentform-customer_id').val();

        if (customerInput && isNaN(customerInput))
        {
            customerDetail_show();
        } else
        {
            customerDetail_hide();
        }
    }

    function customerDetail_show()
    {
        $('.field-paymentform-customer_address').show('blind');
        $('.field-paymentform-customer_phone').show('blind');
    }

    function customerDetail_hide()
    {
        $('.field-paymentform-customer_address').hide('blind');
        $('.field-paymentform-customer_phone').hide('blind');
    }

    function container_count()
    {
        var qty = $('.paymentcontainers:checked').length;
        var total = qty * 60000;

        $('#paymentform-total').val(total);
    }

</script>

<?php
$js = <<<JS

	$(function () {
        $('.field-paymentform-customer_address').hide();
        $('.field-paymentform-customer_phone').hide();
        container_count();

        $('#paymentform-customer_id').on('select2:select', function (evt) {
            customer_check();
        });

        $('.paymentcontainers').on('click', function (evt) {
            container_count();
        });
	});

JS;

$this->registerJs($js, \yii\web\View::POS_READY);
