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
        <br>
        ...::: Rekening di BRI Syariah :::...
        <br><br>
        <?= $form->field($model, 'oth_bnk_acct')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'bnk_acc_type')->dropDownList(app\models\Longcif::getJenisRekening(), ['' => 'No. Rekening']) ?>

        <br>
        ...::: Rekening di Bank Lain :::...
        <br><br>
        <?= $form->field($model, 'oth_bank_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'oth_acc_nbnk')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'acc_type_nbnk')->dropDownList(app\models\Longcif::getJenisRekeninglain(), ['' => 'Pilih Jenis Rekening Lain']) ?>
    <?= $form->field($model, 'oth_type_nbank')->textInput(['maxlength' => true]) ?> 

        <br>
        ...::: Kartu Kredit :::...
        <br><br>
        <?= $form->field($model, 'credit_card')->inline()->radioList(['Y' => "Y", "N" => "N"]) ?>
        <?= $form->field($model, 'issuer_cr_card')->dropDownList(['' => '', 'BRI' => 'BRI', 'Lainnya' => 'Lainnya']) ?>
        <?= $form->field($model, 'nbnk_cr_card')->textInput(['maxlength' => true]) ?> 
        <?= $form->field($model, 'cr_card_type')->dropDownList(['' => '', 'Classic' => 'Classic', 'Gold' => 'Gold', 'Platinum' => 'Platinum']) ?>
    <?= $form->field($model, 'oth_iss_cr_card')->textInput(['maxlength' => true]) ?> 

    </div>

