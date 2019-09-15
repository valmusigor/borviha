<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use backend\assets\CoordAsset;
CoordAsset::register($this);
use backend\models\Locagent;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\LocagentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Поэтажное расположение';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="locagent-index">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?= Html::a('Create Locagent', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
   
   
    <?php    Pjax::begin() ?>
    <div id="coordinate-map" class="row">
        <?php if(Yii::$app->controller->action->id==='edit'):?>
        <div id="coord-create" class="col-md-3">

        <h3><?= Html::encode($models[0]->floor).'этаж' ?></h3>

        <?= $this->render('_form', [
            'model' => $edit_model,
            'locagent'=>$locagent,
        ]) ?>
        </div>
        <?php endif;?>
    <div id="title" class="<?php (Yii::$app->controller->action->id==='edit')?"col-md-9":""?>" style="text-align:center;">
      <div> 
        <?php 
          $item=[];
          for($i=1;$i<12;$i++)
            $item[$i]=$i. ' этаж';
          echo Html::dropDownList('floor', 11, $item,['id' => 'floor']);
        ?>
      </div>
        <canvas id='myCanvas'></canvas>
        <img id="floor-image" src="<?php echo '/templates/floor'.$models[0]->floor.'.png' ?>"alt="Навигация по этажу" usemap="#Locationagent" />
    </div>
    <p>
      <map id="Locationagent" name="Locationagent">
         <?php foreach($models as $model)
             echo Html::tag('area', '', ['shape'=>'poly','class'=>'area_click','coords'=>$model->point,'href'=>'/coord/edit?id='.$model->id,'data-pjax'=>1,
                 'title'=>($loc=Locagent::findOne(['number_office'=>$model->number_office]))?$loc->contract->agent->name:'']);
         ?>      
      </map>
    </p>
   </div>
    <?php Pjax::end(); ?>
</div>
<?php $this->registerJsFile('/js/coordinator.js', ['depends' => [yii\web\JqueryAsset::className()]]);?>