<?php 
use yii\helpers\Html;
use backend\models\Agent;
?>
<div class="list-group clicker">
  <div href="#" class="list-group-item">
    <h4 class="list-group-item-heading">Договор <?=($model->connection_id)?'тройственный':'основной'?> №<?=$model->number_contract?> от <?=$model->date_contract?></h4>
    <div class="list-group-item-text description_contract toggle-visible">
        <div><span class="label label-info">Площадь:</span><?=$model->agent_area?>м<sup>2</sup></div>
        <div><span class="label label-info">Площадь мест общего пользования:</span><?=$model->common_area?>м<sup>2</sup></div>
        <?php 
         if(Agent::findOne($agent_id)->type===2 ){
            echo Html::tag ('span', 'Cобственник помещений: ');
            echo Html::a(Agent::findone($model->connection_id)->name,['/agent/view', 'id' => $model->connection_id]);
         }
         else if($model->connection_id)
         {
            echo Html::tag ('span', 'Арендатор помещений: ');
            echo Html::a($model->agent->name,['/agent/view', 'id' => $model->agent_id]);
        }
        ?>
        <div>
        <?= Html::a('Редактировать', ['/contract/update', 'id' => $model->id,'agent_id'=>$model->agent_id], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('Удалить', ['/contract/delete', 'id' => $model->id,'agent_id'=>$model->agent_id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        </div>
    </div>
  </div>
</div>
<?php
$this->registerJsFile('/js/_contract.js');
?>

