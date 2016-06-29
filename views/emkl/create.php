<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Emkl $model
 */
$this->title                   = 'Create';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'EMKL'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud emkl-create">

    <h1>
        <?= Yii::t('app', 'EMKL') ?>
        <small>
            <?= $model->name ?>
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
