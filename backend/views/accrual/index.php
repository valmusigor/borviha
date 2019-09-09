<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\models\Invoices;
use backend\assets\AccrualAsset;
AccrualAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AccrualSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
   $sum=0;
   $vat=0;
   $sum_with_vat=0;
$this->title = 'Начисления по счету №'.((($invoice= Invoices::findOne($invoice_id)))?$invoice->number_invoice:'');
$this->params['breadcrumbs'][] = ['label' => 'Счета', 'url' => ['/invoice/index']];
$this->params['breadcrumbs'][] = $this->title;
if($invoice){
            foreach ($invoice->accruals as $accrual)
            {
                $sum+=$accrual->sum;
                $vat+=$accrual->vat;
                $sum_with_vat+=$accrual->sum_with_vat;
            }
        }
?>
<div class="accrual-index">

    
    <p>
        <?= Html::a('Создать вручную', ['/accrual/create?invoice_id='.$invoice_id], ['class' => 'btn btn-info']) ?>
    </p>

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter'=>true,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
                'footer' => Html::tag('span', 'ИТОГО:', ['class'=>'label-info'])
            ],
             [ 
               'attribute' => 'units',
                'format' => 'raw',
                'filter' => backend\models\Accrual::UNITS_MAPPING,
                'value' => function ($model, $key, $index, $column) {
                    return \yii\helpers\Html::tag(
                        'span',
                        backend\models\Accrual::UNITS_MAPPING[$model->name_accrual]
                    );
                },
            ],
            'quantity',
            'price',
            [
            'attribute' => 'sum',
            'value' => function ($model, $key, $index, $widget) {
              return $model->sum;
              },
            'footer' =>$sum,
            ],
            [
            'attribute' => 'vat',
            'value' => function ($model, $key, $index, $widget) {
              return $model->vat;
              },
            'footer' =>$vat,
            ],
            [
            'attribute' => 'sum_with_vat',
            'value' => function ($model, $key, $index, $widget) {
              return $model->sum_with_vat;
              },
            'footer' =>$sum_with_vat,
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
