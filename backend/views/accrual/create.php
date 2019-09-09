<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Accrual */

$this->title = 'Создать начисление';
$this->params['breadcrumbs'][] = ['label' => 'Все начисления', 'url' => ['index','invoice_id'=>$invoice_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accrual-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
