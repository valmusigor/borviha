<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\AgentViewAsset;
AgentViewAsset::register($this);
use backend\models\Agent;
if(Yii::$app->controller->action->id==='create'){
    $this->title = 'Create Contract ';
    $this->params['breadcrumbs'][] = ['label' => Agent::findOne($agent_id)->name, 'url' => ['/agent/view?id='.$agent_id]];
    $this->params['breadcrumbs'][] = 'Create new contract';
}
else if(Yii::$app->controller->action->id==='update'){
    $this->title = 'Update Contract: ' . $model->id;
    $this->params['breadcrumbs'][] = ['label' => Agent::findOne($model->agent_id)->name, 'url' => ['/agent/view?id='.$model->agent_id]];
   $this->params['breadcrumbs'][] = 'Update contract:'.$model->id;
}
?>
<div class="contract-update">

    <?php $form = ActiveForm::begin(); ?>
    <?= $this->render('/agent/_add_contract_form', [
        'model' => $model,'form'=>$form,'agent_id'=>$agent_id
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>