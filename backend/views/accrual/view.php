<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Accrual;
/* @var $this yii\web\View */
/* @var $model backend\models\Accrual */

$this->title = 'Начисление по счету №'.$model->invoice->number_invoice.' от '.$model->invoice->date_invoice;
$this->params['breadcrumbs'][] = ['label' => 'Счета', 'url' => ['/invoice/index']];
$this->params['breadcrumbs'][] = ['label' => 'Все начисления', 'url' => ['index','invoice_id'=>$model->invoice_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="accrual-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите снесни начисление',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
//            'contract_id',
 
            [ 
               'attribute' => 'name_accrual',
                'format' => 'raw',
                'value' => function ($data) {
                    return \yii\helpers\Html::tag(
                        'span', Accrual::NAMES_ACCRUAL[$data->name_accrual]
                    );
                },
            ],
            'units',
            'quantity',
            'price',
            'sum',
            'vat',
            'sum_with_vat',
        ],
    ]) ?>

</div>
