<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Accrual;
/* @var $this yii\web\View */
/* @var $model backend\models\Accrual */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accrual-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'name_accrual')->
            dropDownList(Accrual::NAMES_ACCRUAL, ['id' => 'name_accrual']) ?>

    <?= $form->field($model, 'units')->dropDownList(Accrual::UNITS_MAPPING, ['id' => 'units']) ?> 

    <?= $form->field($model, 'quantity')->textInput(['id' => 'quantity']) ?>

    <?= $form->field($model, 'price')->textInput(['id' => 'price']) ?>

    <?= $form->field($model, 'sum')->textInput(['id' => 'sum']) ?>

    <?= $form->field($model, 'vat')->textInput(['id' => 'vat']) ?>

    <?= $form->field($model, 'sum_with_vat')->textInput(['id' => 'sum_with_vat']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php  $this->registerJsFile('/js/depend_name_accrual_units.js')?>
</div>
