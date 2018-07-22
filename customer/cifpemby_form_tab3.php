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

    <?= $form->field($model, 'employment_status')->dropDownList(\app\models\Longcif::getEmploymentStatus(), ['prompt' => 'Pilih Jenis Pekerjaan']) ?>
    <?= $form->field($model, 'employers_name')->textInput(['maxlength' => true]) ?> 
    <?= $form->field($model, 'sid_eco_sector')->dropDownList(\app\models\EcoSector::getEcosector(), ['prompt' => 'Pilih Bidang Usaha']) ?>
    <?= $form->field($model, 'tax_reg_no')->textInput(['maxlength' => true]) ?> 


</div>
