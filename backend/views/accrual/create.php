<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Accrual */

$this->title = 'Create Accrual';
$this->params['breadcrumbs'][] = ['label' => 'Accruals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accrual-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
