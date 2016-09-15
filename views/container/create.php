<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Container $model
 */
$this->title                   = 'Create';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Containers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
if (Yii::$app->user->isGuest == FALSE)
{
    echo $this->render('@app/views/widget/debt_alert');
}
?>

<div class="giiant-crud container-create">

    <h1>
        New <?= Yii::t('app', 'Container') ?>
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

    <?=
    $this->render('_form', [
        'model' => $model,
    ]);
    ?>

</div>
