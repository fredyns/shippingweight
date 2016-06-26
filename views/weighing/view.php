<?php

use dmstr\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\Weighing $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('app', 'Weighing');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Weighings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud weighing-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('app', 'Weighing') ?>        <small>
            <?= $model->id ?>        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'id' => $model->id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'id' => $model->id, 'Weighing'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . 'New',
            ['create'],
            ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . 'Full list', ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('app\models\Weighing'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'id',
        'job_order',
        'container_number',
            [
                'attribute'=>'measurement_method',
                'value'=>app\models\Weighing::getMeasurementMethodValueLabel($model->measurement_method),
            ],
        'measured_at',
        'grossmass',
        'gatein_grossmass',
        'gatein_trackNumber',
        'gateout_grossmass',
        'gateout_trackNumber',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'id' => $model->id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . 'Are you sure to delete this item?' . '',
    'data-method' => 'post',
    ]); ?>
    <?php $this->endBlock(); ?>


    
<?php $this->beginBlock('Certificates'); ?>
<div style='position: relative'><div style='position:absolute; right: 0px; top: 0px;'>
  <?= Html::a(
            '<span class="glyphicon glyphicon-list"></span> ' . 'List All' . ' Certificates',
            ['certificate/index'],
            ['class'=>'btn text-muted btn-xs']
        ) ?>
  <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . 'New' . ' Certificate',
            ['certificate/create', 'Certificate' => ['weighing_id' => $model->id]],
            ['class'=>'btn btn-success btn-xs']
        ); ?>
</div></div>�PNG

   IHDR   o   o   �#   PLTE���   U��~   	pHYs  �  ��+  #IDAT8���1�� ��P��H��\i���r%:�A���b��M|�Y�v	���q̓ϰ�9��a�eB�,T歄��sW2�\��(��nd�.���w�E���s]�_̏�Y)�q;��b����yP�����=�g��=�qܽY[&_B�9������`u��'+ye�U���=:@���qH�w���1D�<[��ޏ���҇:%��mW�j�g��N:�r]��Y�tl���4-TJ���w�{�u���#�h�tT�80Z(�-��uP��?��H�G�xLN:�o����n%"    IEND�B`��PNG

   IHDR   o   o   �#   PLTE���   U��~   	pHYs  �  ��+  #IDAT8���1�� ��P��H��\i���r%:�A���b��M|�Y�v	���q̓ϰ�9��a�eB�,T歄��sW2�\��(��nd�.���w�E���s]�_̏�Y)�q;��b����yP�����=�g��=�qܽY[&_B�9������`u��'+ye�U���=:@���qH�w���1D�<[��ޏ���҇:%��mW�j�g��N:�r]��Y�tl���4-TJ���w�{�u���#�h�tT�80Z(�-��uP��?��H�G�xLN:�o����n%"    IEND�B`��PNG

   IHDR   o   o   �#   PLTE���   U��~   	pHYs  �  ��+  #IDAT8���1�� ��P��H��\i���r%:�A���b��M|�Y�v	���q̓ϰ�9��a�eB�,T歄��sW2�\��(��nd�.���w�E���s]�_̏�Y)�q;��b����yP�����=�g��=�qܽY[&_B�9������`u��'+ye�U���=:@���qH�w���1D�<[��ޏ���҇:%��mW�j�g��N:�r]��Y�tl���4-TJ���w�{�u���#�h�tT�80Z(�-��uP��?��H�G�xLN:�o����n%"    IEND�B`��PNG

   IHDR   o   o   �#   PLTE���   U��~   	pHYs  �  ��+  #IDAT8���1�� ��P��H��\i���r%:�A���b��M|�Y�v	���q̓ϰ�9��a�eB�,T歄��sW2�\��(��nd�.���w�E���s]�_̏�Y)�q;��b����yP�����=�g��=�qܽY[&_B�9������`u��'+ye�U���=:@���qH�w���1D�<[��ޏ���҇:%��mW�j�g��N:�r]��Y�tl���4-TJ���w�{�u���#�h�tT�80Z(�-��uP��?��H�G�xLN:�o����n%"    IEND�B`��PNG

   IHDR   o   o   �#   PLTE���   U��~   	pHYs  �  ��+  #IDAT8���1�� ��P��H��\i���r%:�A���b��M|�Y�v	���q̓ϰ�9��a�eB�,T歄��sW2�\��(��nd�.���w�E���s]�_̏�Y)�q;��b����yP�����=�g��=�qܽY[&_B�9������`u��'+ye�U���=:@���qH�w���1D�<[��ޏ���҇:%��mW�j�g��N:�r]��Y�tl���4-TJ���w�{�u���#�h�tT�80Z(�-��uP��?��H�G�xLN:�o����n%"    IEND�B`��PNG

   IHDR   o   o   �#   PLTE���   U��~   	pHYs  �  ��+  #IDAT8���1�� ��P��H��\i���r%:�A���b��M|�Y�v	���q̓ϰ�9��a�eB�,T歄��sW2�\��(��nd�.���w�E���s]�_̏�Y)�q;��b����yP�����=�g��=�qܽY[&_B�9������`u��'+ye�U���=:@���qH�w���1D�<[��ޏ���҇:%��mW�j�g��N:�r]��Y�tl���4-TJ���w�{�u���#�h�tT�80Z(�-��uP��?��H�G�xLN:�o����n%"    IEND�B`��PNG

   IHDR   o   o   �#   PLTE���   U��~   	pHYs  �  ��+  #IDAT8���1�� ��P��H��\i���r%:�A���b��M|�Y�v	���q̓ϰ�9��a�eB�,T歄��sW2�\��(��nd�.���w�E���s]�_̏�Y)�q;��b����yP�����=�g��=�qܽY[&_B�9������`u��'+ye�U���=:@���qH�w���1D�<[��ޏ���҇:%��mW�j�g��N:�r]��Y�tl���4-TJ���w�{�u���#�h�tT�80Z(�-��uP��?��H�G�xLN:�o����n%"    IEND�B`��PNG

   IHDR   o   o   �#   PLTE���   U��~   	pHYs  �  ��+  #IDAT8���1�� ��P��H��\i���r%:�A���b��M|�Y�v	���q̓ϰ�9��a�eB�,T歄��sW2�\��(��nd�.���w�E���s]�_̏�Y)�q;��b����yP�����=�g��=�qܽY[&_B�9������`u��'+ye�U���=:@���qH�w���1D�<[��ޏ���҇:%��mW�j�g��N:�r]��Y�tl���4-TJ���w�{�u���#�h�tT�80Z(�-��uP��?��H�G�xLN:�o����n%"    IEND�B`��PNG

   IHDR   o   o   �#   PLTE���   U��~   	pHYs  �  ��+  #IDAT8���1�� ��P��H��\i���r%:�A���b��M|�Y�v	���q̓ϰ�9��a�eB�,T歄��sW2�\��(��nd�.���w�E���s]�_̏�Y)�q;��b����yP�����=�g��=�qܽY[&_B�9������`u��'+ye�U���=:@���qH�w���1D�<[��ޏ���҇:%��mW�j�g��N:�r]��Y�tl���4-TJ���w�{�u���#�h�tT�80Z(�-��uP��?��H�G�xLN:�o����n%"    IEND�B`�<?php Pjax::begin(['id'=>'pjax-Certificates', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-Certificates ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>
<?= '<div class="table-responsive">' . \yii\grid\GridView::widget([
    'layout' => '{summary}{pager}<br/>{items}{pager}',
    'dataProvider' => new \yii\data\ActiveDataProvider(['query' => $model->getCertificates(), 'pagination' => ['pageSize' => 20, 'pageParam'=>'page-certificates']]),
    'pager'        => [
        'class'          => yii\widgets\LinkPager::className(),
        'firstPageLabel' => 'First',
        'lastPageLabel'  => 'Last'
    ],
    'columns' => [[
    'class'      => 'yii\grid\ActionColumn',
    'template'   => '{view} {update}',
    'contentOptions' => ['nowrap'=>'nowrap'],
    'urlCreator' => function ($action, $model, $key, $index) {
        // using the column name as key, not mapping to 'id' like the standard generator
        $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
        $params[0] = 'certificate' . '/' . $action;
        return $params;
    },
    'buttons'    => [
        
    ],
    'controller' => 'certificate'
],
        'id',
// generated by schmunk42\giiant\generators\crud\providers\RelationProvider::columnFormat
[
    'class' => yii\grid\DataColumn::className(),
    'attribute' => 'shipper_id',
    'value' => function ($model) {
        if ($rel = $model->getShipper()->one()) {
            return Html::a($rel->name, ['shipper/view', 'id' => $rel->id,], ['data-pjax' => 0]);
        } else {
            return '';
        }
    },
    'format' => 'raw',
],
// generated by schmunk42\giiant\generators\crud\providers\RelationProvider::columnFormat
[
    'class' => yii\grid\DataColumn::className(),
    'attribute' => 'shipment_id',
    'value' => function ($model) {
        if ($rel = $model->getShipment()->one()) {
            return Html::a($rel->id, ['shipment/view', 'id' => $rel->id,], ['data-pjax' => 0]);
        } else {
            return '';
        }
    },
    'format' => 'raw',
],
        'date',
        'job_order',
        'grossmass',
        'container_number',
        'created_by',
        'updated_by',
]
]) . '</div>' ?>
<?php Pjax::end() ?>
<?php $this->endBlock() ?>


    <?= Tabs::widget(
                 [
                     'id' => 'relation-tabs',
                     'encodeLabels' => false,
                     'items' => [ [
    'label'   => '<b class=""># '.$model->id.'</b>',
    'content' => $this->blocks['app\models\Weighing'],
    'active'  => true,
],[
    'content' => $this->blocks['Certificates'],
    'label'   => '<small>Certificates <span class="badge badge-default">'.count($model->getCertificates()->asArray()->all()).'</span></small>',
    'active'  => false,
], ]
                 ]
    );
    ?>
</div>
