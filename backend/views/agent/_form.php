<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\Agent */
/* @var $form yii\widgets\ActiveForm */
use kartik\date\DatePicker;
use backend\assets\CommonAsset;
CommonAsset::register($this);
use yii\widgets\Pjax;
use yii\web\View;
use backend\models\forms\AddJur;
?>

<div class="agent-form">

    <?php
    $form = ActiveForm::begin(); ?>
    
    <?/* $form->field($model, 'person_org')
    ->radioList([
        1 => 'Юр.лицо',
        2 => 'Физ.лицо',
    ],['id' => 'person_org'])->label('');*/ ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'post_address')->textInput(['maxlength' => true,'id'=>'post_address']) ?>
    
    <?php //Pjax::begin(['id' => 'view-original-data']); ?>
        <?php 
          if(Yii::$app->controller->action->id==='create-jur' || Yii::$app->controller->action->id==='create-fiz')
            foreach ($model->personal_settings as $setting){
                if(explode('_', $setting)[0]==='date'){
                  echo $form->field($model, $setting)->widget(DatePicker::className(),[
                   'name' => $setting,
                   'type' => DatePicker::TYPE_INPUT,
                   'convertFormat' => true,
                    'pluginOptions' => [
                        'format' => 'dd.M.yyyy',
                        'autoclose'=>true,
                        'weekStart'=>1, 
                    ]
                    ]);
                }
                else if(explode('_', $setting)[0]==='equal'){
                   echo $form->field($model, $setting)->checkbox(['checked'=>true,'id' => $setting]);
                }
                else  echo $form->field($model, $setting)->textInput(['maxlength' => true,'id' => $setting]); 
                
            } 
            elseif (Yii::$app->controller->action->id==='update')
            { 
                if($model->person_org=== backend\models\Agent::AGENT_JUR){
                    foreach (backend\models\Agent::AGENT_JUR_PERSONAL_SETTINGS as $setting)
                    {    if(explode('_', $setting)[0]==='equal')
                   echo $form->field(new AddJur(), $setting)->checkbox(['checked'=>true,'id' => $setting]);
                else echo $form->field($model->legals, $setting)->textInput(['maxlength' => true,'id' => $setting]); 
                    }
                }
                else if($model->person_org=== backend\models\Agent::AGENT_FIZ){
                    foreach (backend\models\Agent::AGENT_FIZ_PERSONAL_SETTINGS as $setting)
                    {if(explode('_', $setting)[0]==='date')
                  echo $form->field($model->passports, $setting)->widget(DatePicker::className(),[
                   'name' => $setting,
                   'type' => DatePicker::TYPE_INPUT,
                   'convertFormat' => true,
                    'pluginOptions' => [
                        'format' => 'dd.M.yyyy',
                        'autoclose'=>true,
                        'weekStart'=>1, 
                    ]
                    ]);
                 echo $form->field($model->passports, $setting)->textInput(['maxlength' => true,'id' => $setting]); 
                    }
                }
            }
        ?>
    <?php //Pjax::end(); ?>
   
    
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([
        backend\models\Agent::AGENT_OWNER=>"Собственник",
        backend\models\Agent::AGENT_RENTER=>"Арендатор",
    ], ['id' => 'type']) ?>
    
    <?php  if(Yii::$app->controller->action->id==='create-jur' || Yii::$app->controller->action->id==='create-fiz')
           echo $this->render('_add_contract_form', ['model'=>$model,'form'=>$form]);
            else if (Yii::$app->controller->action->id==='update')
            { 
                foreach ($model->contracts as $index => $setting) {
                echo $this->render('_add_contract_form', ['model'=>$setting,'form'=>$form,'index'=>$index]);
                }
       
            }
    ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php
 if(Yii::$app->controller->action->id==='create-jur' || (Yii::$app->controller->action->id==='update' && $model->person_org===1))
$this->registerJsFile('/js/loadBankData.js');
?>
