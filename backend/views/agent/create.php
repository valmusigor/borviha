<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Agent */

$this->title = 'Add agent';
$this->params['breadcrumbs'][] = ['label' => 'Agents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-create">


    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
