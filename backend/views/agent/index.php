<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cобственники/Арендаторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-index">

    <p>
        <?= Html::a('Добавить юр.лицо', ['create-jur'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Добавить физ.лицо', ['create-fiz'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'filterModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'post_address',
             [ 
               'attribute' => 'legals.unp',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return \yii\helpers\Html::tag(
                        'span',
                        ($model->legals)?$model->legals->unp:''
                    );
                },
            ],
            [ 
               'attribute' => 'passports.serial_number_passport',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return \yii\helpers\Html::tag(
                        'span',
                        ($model->passports)?$model->passports->serial_number_passport:''
                    );
                },
            ],
            [ 
               'attribute' => 'type',
                'format' => 'raw',
                'filter' => ['1' => 'Собственник', '2' => 'Арендатор'],
                'value' => function ($model, $key, $index, $column) {
                    $type = $model->{$column->attribute};
                    return \yii\helpers\Html::tag(
                        'span',
                        ($type===1)?'собственник':'арендатор'
                    );
                },
            ],
                        
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
