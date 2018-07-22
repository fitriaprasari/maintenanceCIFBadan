<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

//use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="maintain-form">
    <div>&nbsp;</div>
    <div>&nbsp;</div>
   <?php if($cust_type == "Perorangan"){?>
    
    <?= $form->field($model, 'income')->dropDownList(app\models\Income::kisaranPendapatan(), ['' => '---Kisaran Pendapatan---']) ?>
    <?= $form->field($model, 'fund_source')->dropDownList(app\models\Longcif::getFundSource(), ['' => '---Pilih Sumber Pendapatan---']) ?>
    <?= $form->field($model, 'ac_of_fund')->dropDownList(app\models\Acoffund::listSumberDana(), ['' => '---Pilih Sumber Dana---']) ?>

    <?= $form->field($model, 'ac_open_purpose')->dropDownList(app\models\Acopenpurpose::listTujuanPembukaanCIF(), ['' => "---Tujuan Pembukaan CIF--"]) ?>

    <?= $form->field($model, 'monthly_txn_amt')->dropDownList(app\models\MonthlyTxnAmt::kisaranPengeluaran(), ['' => '---Kisaran Pengeluaran---']) ?>

    <?= $form->field($model, 'txn_freq_mon')->dropDownList(app\models\TxnFreqMonth::kisaranTransaksi(), ['' => '---Kisaran Transaksi---']) ?>

   <?php } else {?>
    
    <!--form cif badan-->
    <?= $form->field($model2, 'contact_nam')->textInput(['maxlength'=>true,'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'contact_pos')->textInput(['maxlength'=>true,'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'contact_worktel')->textInput(['maxlength'=>true,'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'contact_mobtel')->textInput(['maxlength'=>true,'style' => 'text-transform: uppercase']) ?>
   <?php } ?>
    
</div>




