<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Locagent;
/* @var $this yii\web\View */
/* @var $model backend\models\Coord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="coord-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'point')->textInput(['maxlength' => true,'id' => 'point']) ?>

    <?= $form->field($model, 'floor')->textInput() ?>

    <?= $form->field($model, 'number_office')->textInput(['maxlength' => true]) ?>
   
   <?= $form->field($locagent, 'square')->textInput() ?>

   <?= $form->field($locagent, 'agent_name')->textInput(['id' => 'loc_agent_name']) ?>
   
   <?= $form->field($locagent, 'number_contract')->textInput(['id' => 'loc_number_contract']) ?>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
