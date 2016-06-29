<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Weighing $model
 */
$this->title                   = 'Create';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Weighings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud weighing-create">

    <h1>
        <?= Yii::t('app', 'Weighing') ?>
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

    <?=
    $this->render('_form', [
        'model' => $model,
    ]);
    ?>

</div>
