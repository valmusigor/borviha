<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\assets\CommonAsset;
CommonAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AccrualSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accruals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accrual-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        
        <?= Html::a('Создать вручную', ['create'], ['class' => 'btn btn-info']) ?>
        
        <?php //echo '<label class="control-label">Add Attachments</label>';
            Modal::begin([
            'header'=>'Выберите exel файл для конфигурации счетов',
            'toggleButton' => [
                'label'=>'<i class="fas fa-file-excel">Загрузить конфигурацию</i>', 'class'=>'btn btn-primary btn-success'
            ],
          ]);
            $form = ActiveForm::begin([
             'options'=>['enctype'=>'multipart/form-data'] // important
            ]);
        echo $form->field($model, 'upload_name')->widget(FileInput::classname(),[
            'pluginOptions' => [
            'dropZoneEnabled'=>false,
            'showCaption' => false,
           // 'uploadUrl' => Url::to(['/accrual/upload-exel']),
            'browseClass' => 'btn btn-primary btn-success',
            'browseIcon' => '<i class="fas fa-file-excel"></i>',
            'browseLabel' =>  'Выберите файл'
        ],
            'options' => ['multiple' => false]
        ]);
        ActiveForm::end();
        Modal::end();
        
        ?>
        <?//= Html::a('Выгрузить из exel', ['uploadExel'], ['class' => 'btn btn-success']) ?>
        <?php /*
        $form= ActiveForm::begin([
            'id'=>'fileUploadForm',
            'method'=>'POST',
            'options'=>['enctype'=>'multipart/form-data'],]); ?>
         <?=$form->field($model, 'upload_name')->fileInput();?>
         <?=Html::submitButton('UPLOAD', ['class'=>'btn btn-primary']); ?>
        <? ActiveForm::end(); */?>
    </p>

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'number_invoice',
            'date_accrual',
            
            [ 
                'attribute' => 'contract.number_contract',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return \yii\helpers\Html::tag(
                        'span',
                        ($model->contract)?$model->contract->number_contract:''
                    );
                },
            ],
            [ 
               'attribute' => 'contract.agent.name',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return \yii\helpers\Html::tag(
                        'span',
                        ($model->contract->agent)?$model->contract->agent->name:''
                    );
                },
            ],
            'name_accrual',
            //'units',
            //'quantity',
            //'price',
            //'sum',
            //'vat',
            'sum_with_vat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
