<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\file\FileInput;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\models\Accrual;
use jino5577\daterangepicker\DateRangePicker;
use yii\widgets\ActiveForm;
use backend\assets\AccrualAsset;
AccrualAsset::register($this);

$this->title = 'Invoices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accrual-index">
    
<div class="btn-group" role="group" aria-label="...">
        
        <?= Html::a('Создать вручную', ['create'], ['class' => 'btn btn-info']) ?>
        
        <?php 
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
        <?= Html::button('<i class="far fa-file-pdf">Отправка выбранных счетов</i>', ['class' => 'btn btn-danger','onclick' => 'js:sendMail()']) ?>
        <?//Html::a('<i class="far fa-file-pdf">Подготовка рассылки</i>', ['prepare-mail'], ['class' => 'btn btn-danger']) ?>
</div>

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
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
                       
            ],
            [
			// the attribute
			'attribute' => 'date_invoice',
			// format the value
//			'value' => function ($model) {
//				if (extension_loaded('intl')) {
//					return Yii::t('app', '{0, date, MMMM dd, YYYY HH:mm}', [$model->date_invoice]);
//				} else {
//					return date('Y-m-d G:i:s', $model->date_invoice);
//				}
//			},
			// some styling? 
			'headerOptions' => [
				'class' => 'col-md-2'
			],
			// here we render the widget
			'filter' => DateRangePicker::widget([
				'model' => $searchModel,
				'attribute' => 'created_at_range',
				'pluginOptions' => [
				'format' => 'd-m-Y',
				'autoUpdateInput' => false
			]
			])
		],
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
                    return \yii\helpers\ Html::a((($model->contract->agent)?$model->contract->agent->name:''),(($model->contract->agent)?'/agent/view?id='.$model->contract->agent->id:'/agent/index'));
                   
                },
            ],
            ['class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => ['onclick' => 'js:addItems(this.value, this.checked)']
                ],
            ['class' => 'yii\grid\ActionColumn',
              'template' => '{update} {delete} {view} {create-pdf} {send-email}',
                'buttons'=>[
                        'create-pdf' => function ($url,$model,$key) {
                            return Html::a(Html::tag('i','',['class' => 'far fa-file-pdf']), $url, ['class' => 'btn btn-primary btn-xs']);
                        },
                        'send-email' => function ($url,$model,$key) {
                            return Html::a(Html::tag('i','',['class' => 'fas fa-at']), $url, ['class' => 'btn btn-primary btn-xs']);
                        },
                       
                 ],],
        ],
    ]); ?>
    <?php 
     if($exist_result){
         Pjax::begin();
         Modal::begin([
            'header'=>($exist_result['status']==true)?'Файл успешно обработан'
             :'Загружаемый счет №'.$exist_result['number_invoice'].' от '.$exist_result['date_invoice'].' существует',
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
     }
    ?>
</div>

<? $this->registerJsFile('/js/prepare_email.js'); ?>