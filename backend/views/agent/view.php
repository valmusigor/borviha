<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $model backend\models\Agent */
use backend\assets\AgentViewAsset;
AgentViewAsset::register($this);
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Собственники/Арендаторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//\yii\web\YiiAsset::register($this);

?>
<div class="agent-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить запись?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Добавить договор', ['/contract/create', 'agent_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="row">
        <div class="col-md-6 col-sm-12">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => ($model->person_org===1)?$model->setDetalViewJur():$model->setDetalViewFiz(),
    ]) ?>
    </div>
        <div class="col-md-6 col-sm-12">
                <?= ListView::widget([
                 'dataProvider' => $dataProvider,
                 'itemOptions' => ['class' => 'item'],
                 'itemView' => '_contract',
                 'summary'=>'',
                 'viewParams' => [
                        'agent_id'=>$model->id,
                  ],
             ]) ?>
            <?php
            if($model->type===1)
            echo ListView::widget([
                 'dataProvider' => $dataProvider_contract_renter,
                 'itemOptions' => ['class' => 'item'],
                 'itemView' => '_contract',
                 'summary'=>'',
                 'viewParams' => [
                        'agent_id'=>$model->id,
                  ],
             ]) ?>
            
            
        </div>
  </div>
</div>
