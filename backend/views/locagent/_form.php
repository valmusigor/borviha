<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Locagent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="locagent-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'number_floor')->textInput() ?>

    <?= $form->field($model, 'square')->textInput() ?>

    <?= $form->field($model, 'contract_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
