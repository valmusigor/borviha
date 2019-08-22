<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Agent */

$this->title = 'Update Agent: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Собственники/Арендаторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="agent-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
