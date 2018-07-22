<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\KabupatenKota;
use yii\helpers\ArrayHelper;

//use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="maintain-form">

    <?= $form->field($model, 'employment_kyc')->dropDownList(app\models\Employmentkyc::listEmployment(), ['' => 'Pilih Jenis Pekerjaan', 'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model, 'job_title')->dropDownList(app\models\Longcif::getJobTitle(), ['' => 'Pilih Jabatan', 'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model, 'employers_name')->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase']) ?> 
    <?= $form->field($model, 'employers_add')->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model, 'sid_eco_sector')->dropDownList(\app\models\EcoSector::getEcosector(), ['' => 'Pilih Bidang Usaha', 'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model, 'tax_reg_no')->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase']) ?>   

    <div class="row required">
        <label class="control-label col-sm-2" for="longcif-phone_no_emp"><?= $model->getAttributeLabel('phone_no_emp') ?></label>
        <div class="col-sm-3"><?=
            $form->field($model, 'phone_area_emp', [
                'horizontalCssClasses' => [
                    'wrapper' => 'col-sm-12',
                    'offset' => '',
                ],
                'inputOptions' => [
                    'placeholder' => $model->getAttributeLabel('phone_area_emp'),
                ],
            ])->textInput(['maxlength' => true])->label(false)
            ?>
        </div>

        <div class="col-sm-5"><?=
            $form->field($model, 'phone_no_emp', [
                'horizontalCssClasses' => [
                    'wrapper' => 'col-sm-12',
                    'offset' => '',
                ],
                'inputOptions' => [
                    'placeholder' => $model->getAttributeLabel('phone_no_emp'),
                ]
            ])->textInput(['maxlength' => true])->label(false)
            ?>
        </div>
    </div>

    <?= $form->field($model, 'fax_no')->textInput(['maxlength' => true]) ?>

</div>