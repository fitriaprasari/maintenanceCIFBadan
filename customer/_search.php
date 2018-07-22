<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'cif_no') ?>

    <?= $form->field($model, 'legal_type') ?>

    <?= $form->field($model, 'legal_id_no') ?>

    <?= $form->field($model, 'short_name') ?>

    <?= $form->field($model, 'place_birth') ?>

    <?php // echo $form->field($model, 'birth_incorp_date') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'mother_maiden') ?>

    <?php // echo $form->field($model, 'marital_status') ?>

    <?php // echo $form->field($model, 'nationality') ?>

    <?php // echo $form->field($model, 'reside_y_n') ?>

    <?php // echo $form->field($model, 'street') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'rt_rw') ?>

    <?php // echo $form->field($model, 'town_country') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'province') ?>

    <?php // echo $form->field($model, 'district_code') ?>

    <?php // echo $form->field($model, 'post_code') ?>

    <?php // echo $form->field($model, 'addr_phone_area') ?>

    <?php // echo $form->field($model, 'addr_phone_no') ?>

    <?php // echo $form->field($model, 'sms_1') ?>

    <?php // echo $form->field($model, 'email_1') ?>

    <?php // echo $form->field($model, 'employment_kyc') ?>

    <?php // echo $form->field($model, 'ac_of_fund') ?>

    <?php // echo $form->field($model, 'ac_open_purpose') ?>

    <?php // echo $form->field($model, 'income') ?>

    <?php // echo $form->field($model, 'monthly_txn_amt') ?>

    <?php // echo $form->field($model, 'txn_freq_mon') ?>

    <?php // echo $form->field($model, 'cust_risk_prof') ?>

    <?php // echo $form->field($model, 'inputter') ?>

    <?php // echo $form->field($model, 'authoriser') ?>

    <?php // echo $form->field($model, 'account_officer') ?>

    <?php // echo $form->field($model, 'co_code') ?>

    <?php // echo $form->field($model, 'created_date_t24') ?>

    <?php // echo $form->field($model, 'created_date_syiarex') ?>

    <?php // echo $form->field($model, 'last_updated_date') ?>

    <?php // echo $form->field($model, 'state') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
