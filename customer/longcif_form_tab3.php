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
<div>&nbsp;</div>
<?php if($cust_type=="Badan Usaha/Lembaga"){ ?>
    <?= $form->field($model2, 'ni_ac_o_purpose')->dropDownList(['20-Investasi'=>'Investasi',
                                                               '21-Transaksi'=>'Transaksi',
                                                               '22-Lainnya'=>'Lainnya'],
                                                              [''=>"-Pilih Tujuan Pembukaan-",'style' => 'text-transform: uppercase']) ?>
    
    <?= $form->field($model2, 'oth_acc_open_pr')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model2, 'profit')->dropDownList(['30|<= Rp. 10 Juta'=>'<= Rp. 10 Juta',
                                                      '31|> Rp. 10-50 Juta'=>'> Rp. 10-50 Juta',
                                                      '32|> Rp. 50 Juta-100 Juta'=>'> Rp. 50 Juta-100 Juta',
                                                      '33|> Rp. 100-500 Juta'=>'> Rp. 100-500 Juta',
                                                      '34|> Rp. 500 Juta'=>'> Rp. 500 Juta'],
                                                      [''=>'-Pilih Laba Perbulan-','style' => 'text-transform: uppercase']) ?>
    
    <?= $form->field($model2, 'income')->dropDownList(['20|<= Rp. 50 Juta'=>'<= Rp. 50 Juta',
                                                      '21|> Rp. 50-500 Juta'=>'> Rp. 50-500 Juta',
                                                      '22|> Rp. 500 Juta - 1 Milyar'=>'> Rp. 500 Juta - 1 Milyar',
                                                      '23|> Rp. 1-10 Milyar'=>'> Rp. 1-10 Milyar',
                                                      '24|> Rp. 10 Milyar'=> '> Rp. 10 Milyar'],
                                                      [''=>'-Pilih Pendapatan Perbulan-','style' => 'text-transform: uppercase']) ?>
    
    <?= $form->field($model2, 'monthly_txn_amt')->dropDownList(['10|<= Rp. 1 Juta'=>'<= Rp. 1 Juta',
                                                               '11|> Rp. 1-10 Juta'=>'> Rp. 1-10 Juta',
                                                               '12|> Rp. 10-100 Juta'=>'> Rp. 10-100 Juta',
                                                               '13|> Rp. 100 Juta'=>'> Rp. 100 Juta',
                                                               '20|<= Rp. 50 Juta'=>'<= Rp. 50 Juta',
                                                               '21|> Rp. 50 - 500 Juta'=>'> Rp. 50 - 500 Juta',
                                                               '22|> Rp. 500 Juta - 1 Milyar'=>'> Rp. 500 Juta - 1 Milyar',
                                                               '23|> Rp. 1 - 10 Milyar'=>'> Rp. 1 - 10 Milyar',
                                                               '24|> Rp. 10 Milyar'=>'> Rp. 10 Milyar',
                                                               '31|> Rp. 10 - 50 Juta'=>'> Rp. 10 - 50 Juta',
                                                               '32|> Rp. 50 Juta - 100 Juta'=>'> Rp. 50 Juta - 100 Juta',
                                                               '33|> Rp. 100 - 500 Juta'=>'> Rp. 100 - 500 Juta',
                                                               '34|> Rp. 500 Juta'=>'> Rp. 500 Juta'],[''=>'-Pilih-','style' => 'text-transform: uppercase']) ?>

    <?= $form->field($model2, 'txn_freq_mon')->dropDownList(['01 | < 10 X'=>'< 10 X','02 | 10 s.d 50 X'=>'10 s.d 50 X','03 | > 50 X'=>'> 50 X'],[''=>'-PILIH-']) ?>
    <?= $form->field($model2, 'ni_source_fund')->dropDownList(['23 - Hasil Usaha'=>'Hasil Usaha','27 - Lainnya'=>'Lainnya'],[''=>'-Pilih-','style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'oth_fund_source')->textInput(['maxlength'=>true,'style' => 'text-transform: uppercase']) ?>
    
<?php } else {?>
        <br>
        ...::: Orang Yang Dapat Dihubungi Dalam Keadaan Darurat :::...
        <br><br>
        <?= $form->field($model, 'contact_nam')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'contact_homtel')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'contact_mobtel')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'contact_rel_cus')->dropDownList(\app\models\Longcif::getRelCus(), ['' => 'Pilih Hub. Dengan Nasabah']) ?>
<?php } ?>

</div>
