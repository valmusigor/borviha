<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
    
   
    
    <div id="title" style="text-align:center;"><img src="<?php echo '/templates/floor11.png' ?>"
    alt="Навигация по этажу" usemap="#Locationagent" /><br>
    </div>
         <p><map id="Locationagent" name="Locationagent">
    <area shape="poly" coords="28,29,88,29,88,83,83,100,80,104,28,104" href="inform.html" alt="Информация">
    <area shape="poly" coords="210,24,233,0,329,0,307,24" href="activity.html" alt="Мероприятия">
    <area shape="poly" coords="304,24,385,24,407,0,329,0" href="depart.html" alt="Отделения">
    <area shape="poly" coords="384,24,449,24,473,0,406,0" href="techinfo.html" alt="Техническая информация">
    <area shape="poly" coords="449,24,501,24,525,0,473,0" href="study.html" alt="Обучение">
    <area shape="poly" coords="501,24,560,24,583,0,525,0" href="work.html" alt="Работа">
    <area shape="poly" coords="560,24,615,24,639,0,585,0" href="misk.html" alt="Разное">
   </map></p>
    


</div>
