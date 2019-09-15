<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Coord */

$this->title = 'Create Coord';
$this->params['breadcrumbs'][] = ['label' => 'Coords', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coord-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
