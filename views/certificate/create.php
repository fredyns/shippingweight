<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Certificate $model
 */
$this->title                   = 'Create';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Certificates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if (empty($model->vgm_date))
{
    $model->vgm_date = date('Y-m-d');
}
?>
<div class="giiant-crud certificate-create">

    <h1>
        <?= Yii::t('app', 'Certificate') ?>
        <small>
            <?= $model->id ?>
        </small>
    </h1>

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
