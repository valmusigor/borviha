<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Accrual */

$this->title = 'Редактировать начисление: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Все начисления', 'url' => ['index', 'invoice_id' => $model->invoice_id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="accrual-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
