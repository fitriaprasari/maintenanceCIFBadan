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
    <?= $form->field($model, 'contact_nam')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'parent_jobs')->dropDownList(app\models\Employmentkyc::listEmployment(), ['prompt' => 'Pilih Jenis Pekerjaan']) ?>

    <?= $form->field($model, 'parent_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'office_address')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'parent_phone')->textInput(['maxlength' => 16]) ?>

</div>
