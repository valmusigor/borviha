<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\file\FileInput;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\models\Accrual;
use yii\widgets\ActiveForm;
use backend\assets\AccrualAsset;
AccrualAsset::register($this);
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
            
            [ 
                'attribute' => 'number_invoice',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return \yii\helpers\Html::tag(
                        'span',
                        ($model->number_invoice)?$model->number_invoice:''
                    );
                },
                       // 'group' => true, 
            ],
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
                        [ 
               'attribute' => 'name_accrual',
                'format' => 'raw',
                'filter' => backend\models\Accrual::NAMES_ACCRUAL,
                'value' => function ($model, $key, $index, $column) {
                    return \yii\helpers\Html::tag(
                        'span',
                        backend\models\Accrual::NAMES_ACCRUAL[$model->name_accrual]
                    );
                },
            ],
            
            //'units',
            //'quantity',
            //'price',
            //'sum',
            //'vat',
            'sum_with_vat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php 
     if($exist_result){
         Pjax::begin();
         Modal::begin([
            'header'=>($exist_result['status']==true)?'Файл успешно обработан'
             :'Загружаемый счет №'.$exist_result['number_invoice'].' от '.$exist_result['date_accrual'].' существует',
             'id' => 'exist',
             'clientOptions' => ['show' => true],
          ]);?>
        <div class="modal-content">
        <?php
        if($exist_result['status']!==true){
        echo Html::a('Заменить', ['continue-unloading?choose_action=replace&line='.$exist_result['exist'].'&id='.$model->id], ['class' => 'btn btn-warning']);
        echo Html::a('Заменить все', ['continue-unloading?choose_action=replaceall&line='.$exist_result['exist'].'&id='.$model->id], ['class' => 'btn btn-warning']);
        echo Html::a('Пропустить', ['continue-unloading?choose_action=skip&line='.$exist_result['exist'].'&id='.$model->id], ['class' => 'btn btn-warning']);
        echo Html::a('Пропустить все', ['continue-unloading?choose_action=skipall&line='.$exist_result['exist'].'&id='.$model->id], ['class' => 'btn btn-warning']);

        }
        else
        echo Html::a('Закрыть', ['index'], ['class' => 'btn btn-danger','data-pjax'=>0]);
       ?>
        </div>
     <?php   
     Modal::end();
      Pjax::end();
//     $this->registerJs('
//                    jQuery("#exist").modal("show":true});
//          ');
     }
    ?>


</div>
