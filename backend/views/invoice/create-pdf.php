<!--<div style="text-align: right">Date: 13th November 2008</div>
<table width="100%" style="font-family: serif;" cellpadding="10"><tr>
<td width="45%" style="border: 0.1mm solid #888888; "><span style="font-size: 7pt; color: #555555; font-family: sans;">SOLD TO:</span><br /><br />345 Anotherstreet<br />Little Village<br />Their City<br />CB22 6SO</td>
<td width="10%">&nbsp;</td>
<td width="45%" style="border: 0.1mm solid #888888;"><span style="font-size: 7pt; color: #555555; font-family: sans;">SHIP TO:</span><br /><br />345 Anotherstreet<br />Little Village<br />Their City<br />CB22 6SO</td>
</tr>
</table>
<br />-->
<?php 
use backend\models\Accrual;
$a = new \NumberFormatter("ru-RU", \NumberFormatter::SPELLOUT); 
$all_sum=$model->getAllSum();
$vat_rub=floor($all_sum['vat']);
$sum_with_vat_rub=floor($all_sum['sum_with_vat']);
$arr = [
  'января',
  'февраля',
  'марта',
  'апреля',
  'мая',
  'июня',
  'июля',
  'августа',
  'сентября',
  'октября',
  'ноября',
  'декабря'
];
?>
<div  class="head-title">
    <div class="head-title-first">ТС "Борвиха плюс"</div>
    <div>Адрес: 223053 Минский р-н д. Боровляны ул. 40 лет Победы д.23А</div>
    <div>Тел.: 511-20-36</div>
    <div>УНП  691767937,  ОКПО 303333606000</div>
    <div>ЗАО «Альфа-банк»</div>
    <div>P/C BY97ALFA30152241430020270000</div>
    <div>БИК ALFABY2X</div>
</div>
<div class="invoice-container">
    <div class="invoice-label">СЧЕТ-АКТ № <?=$model->number_invoice?> от <?=$model->date_invoice?></div>
</div>
<div  class="agent-title">
    <div class="agent-title-first"><strong>ПЛАТЕЛЬЩИК:  <?=$model->contract->agent->name?></strong></div>
    <div class="agent-title-middle">
        <?php if($model->contract->agent->type== \backend\models\Agent::AGENT_JUR){?>
        <div><?=$model->contract->agent->legals->legal_address?> УНП: <?=$model->contract->agent->legals->unp?></div>
        <div>р/с <?=$model->contract->agent->legals->pc?> в <?=$model->contract->agent->legals->bank_data?></div>
        <?php }?>
    </div>
    <div class="agent-title-last">Дог №<?=$model->contract->number_contract?> от <?=$model->contract->date_contract?>г.(<?=$model->contract->agent_area?>+<?=$model->contract->common_area?>=<?
     echo ($model->contract->agent_area+$model->contract->common_area);   
        ?>)</div>
</div>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
<!--<thead>-->
    <tbody>
<tr>
    <td width="5%">№</td>
    <td width="37.25%">Наименование товара (услуги, работы) </td>
    <td width="7.13%">Ед. изм.</td>
    <td width="10%">Кол-во</td>
    <td width="9.13%">Цена</td>
    <td width="10.38%">Сумма</td>
    <td width="10.00%">НДС</td>
    <td width="14.63%">Сумма с НДС</td>
</tr>
<!--</thead>-->

<!-- ITEMS HERE -->
<?php 
$i=1;
foreach ($model->accruals as $accrual): ?>
<tr>
<td align="center"><?=$i?></td>
<td align="center"><?= \backend\models\Accrual::NAMES_ACCRUAL[$accrual->name_accrual]?></td>
<td><?=\backend\models\Accrual::UNITS_MAPPING[$accrual->units]?></td>
<td class="cost"><?=$accrual->quantity?></td>
<td class="cost"><?=$accrual->price?></td>
<td class="cost"><?=$accrual->sum?></td>
<td class="cost"><?=$accrual->vat?></td>
<td class="cost"><?=$accrual->sum_with_vat?></td>
</tr>
<?php $i++;
endforeach;
?>
<tr>
    <td></td>
    <td class="blanktotal" colspan="4" rowspan="8" style="text-align:right;font-style: italic"><b>ИТОГО:</b></td>
    <td class="totals cost"><b><?=((isset($all_sum['sum']))?$all_sum['sum']:'')?></b></td>
    <td class="totals cost"><b><?=((isset($all_sum['vat']))?$all_sum['vat']:'')?></b></td>
    <td class="totals cost"><b><?=((isset($all_sum['sum_with_vat']))?$all_sum['sum_with_vat']:'')?></b></td>
</tr>
</tbody>
</table>

<table class="all-sum" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
<tbody>
<tr>
    <td width="42.25%">Сумма НДС:</td>
    <td width="57.75%"><?= ucfirst(($a->format($vat_rub))
    .' '.Accrual::num2word($vat_rub, Accrual::VOCABULARY['rub']).' '
    . Accrual::convertFemale($a->format(round(($all_sum['vat']-$vat_rub)*100))).
     ' '.Accrual::num2word(round(($all_sum['vat']-$vat_rub)*100), Accrual::VOCABULARY['kop']));?></td>
</tr>
<tr>
    <td width="42.25%">Всего  на сумму с НДС:</td>
    <td width="57.75%"><?php echo ucfirst(strval($a->format($sum_with_vat_rub)
            .' '.Accrual::num2word($sum_with_vat_rub, Accrual::VOCABULARY['rub']).' '
            . Accrual::convertFemale($a->format(round(($all_sum['sum_with_vat']-$sum_with_vat_rub)*100)))
            .' '.Accrual::num2word(round(($all_sum['sum_with_vat']-$sum_with_vat_rub)*100), Accrual::VOCABULARY['kop'])));?></td>
</tr>
</tbody>
</table>
<div class="footer-invoice">
    <div style="float:left;width: 21%;margin:0;padding: 0;">
        <div style="margin-bottom:10px;"><b>Председатель правления:</b></div>
        <div><b>Главный бухгалтер</b></div>
    </div>
    <div style="float:left;width:40%">
        <div style="margin:0;padding:0;float:left;width:150px;height:130px;background: url(<?php echo Yii::getAlias('@backend').'/web/templates/print.jpg'; ?>)"></div>
        <div style="float: right;"> 
            <div style="margin-bottom:10px;"><b>A.И.Качановский</b></div>
            <div><b>О.М.Коваленя</b></div>
        </div>
    </div>
    <div style="float:left; width: 38%;margin:0;padding: 0;">
        <div style="text-align:center;margin-bottom:20px;"><b>От собственника (уполномоченное лицо)</b></div>
        <div style="text-align:center;margin-bottom:20px;">М.П.</div>
        <div style="text-align:right;">Документ получен <?=date('d').' '.$arr[(date('n')-1)].' '.date('Y').' г.';?></div>
    </div>
</div> 
</div>
 