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
    <?= $form->field($model, 'curr_no')->textInput(['readonly' => true]) ?> 
    <?= $form->field($model, 'inputter')->textInput(['readonly' => true]) ?> 
    <?= $form->field($model, 'date_time')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'co_code')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'dept_code')->textInput(['readonly' => true]) ?>


</div>
