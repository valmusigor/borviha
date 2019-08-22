<?php
/* @var $this yii\web\View */
/* @var $model backend\models\Agent */
use kartik\date\DatePicker;
use backend\models\Agent;
use yii\helpers\ArrayHelper;

?>
<div class="row">
        <div class="col-md-3 col-sm-12">
            <?=(Yii::$app->controller->action->id==='update' && Yii::$app->controller->id==='agent')?$form->field($model, "[$model->id]number_contract")->textInput()
            :$form->field($model, 'number_contract')->textInput() ?>
        </div>
        <div class="col-md-3 col-sm-12">
            <?=(Yii::$app->controller->action->id==='update' && Yii::$app->controller->id==='agent')
            ?$form->field($model, "[$model->id]date_contract")->widget(DatePicker::className(),[
            'name' => 'date_contract',
            'type' => DatePicker::TYPE_INPUT,
            'options' => ['placeholder' => 'Выберите дату заключения договора',
                ],
            'convertFormat' => true,
            'pluginOptions' => [
                'format' => 'dd.M.yyyy',
                'autoclose'=>true,
                'weekStart'=>1, //неделя начинается с понедельника
                'startDate' => '01.08.2014', //самая ранняя возможная дата
            ]
            ])
            :$form->field($model, 'date_contract')->widget(DatePicker::className(),[
            'name' => 'date_contract',
            'type' => DatePicker::TYPE_INPUT,
            'options' => ['placeholder' => 'Выберите дату заключения договора',
                ],
            'convertFormat' => true,
            'pluginOptions' => [
                'format' => 'dd.M.yyyy',
                'autoclose'=>true,
                'weekStart'=>1, //неделя начинается с понедельника
                'startDate' => '01.08.2014', //самая ранняя возможная дата
            ]
            ]);?>
        </div>
        <div class="col-md-3 col-sm-12">
           <?=(Yii::$app->controller->action->id==='update' && Yii::$app->controller->id==='agent')?$form->field($model, "[$model->id]agent_area")->textInput()
           :$form->field($model, 'agent_area')->textInput() ?> 
        </div> 
        <div class="col-md-3 col-sm-12">
           <?=(Yii::$app->controller->action->id==='update' && Yii::$app->controller->id==='agent')?$form->field($model, "[$model->id]common_area")->textInput()
                    :$form->field($model, 'common_area')->textInput() ?> 
        </div>  
    </div>
    <div class="<?=(Yii::$app->controller->id==='contract' && Agent::findOne($agent_id)->type=== Agent::AGENT_RENTER)?"connection_agent":"connection_agent toggle-visible"?>"> 
     <?php
        if(($agents=Agent::find()->where(['type'=>1])->all())){
        echo (Yii::$app->controller->action->id==='update' && Yii::$app->controller->id==='agent')?$form->field($model, "[$model->id]connection_id")->dropDownList(ArrayHelper::merge([0=>NULL],ArrayHelper::map($agents, 'id', 'name')), ['id' => 'connection_agent'])
            :$form->field($model, 'connection_id')->dropDownList(ArrayHelper::merge([0=>NULL],ArrayHelper::map($agents, 'id', 'name')), ['id' => 'connection_agent']);} 
     ?>
    </div>


