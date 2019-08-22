<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AccrualSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accrual-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date_accrual') ?>

    <?= $form->field($model, 'number_invoice') ?>

    <?= $form->field($model, 'contract_id') ?>

    <?= $form->field($model, 'name_accrual') ?>

    <?php // echo $form->field($model, 'units') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'sum') ?>

    <?php // echo $form->field($model, 'vat') ?>

    <?php // echo $form->field($model, 'sum_with_vat') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
