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
<?php if($cust_type == "Badan Usaha/Lembaga"){?>
    <?= $form->field($model2, 'curr_no')->textInput(['readonly' => true,'style' => 'text-transform: uppercase']) ?> 
    <?= $form->field($model2, 'inputter')->textInput(['readonly' => true,'style' => 'text-transform: uppercase']) ?> 
    <?= $form->field($model2, 'date_time')->textInput(['readonly' => true,'style' => 'text-transform: uppercase']) ?> 
    <?= $form->field($model2, 'co_code')->textInput(['readonly' => true,'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'dept_code')->textInput(['readonly' => true,'style' => 'text-transform: uppercase']) ?>

<?php } else { ?>
    <?= $form->field($model, 'curr_no')->textInput(['readonly' => true]) ?> 
    <?= $form->field($model, 'inputter')->textInput(['readonly' => true]) ?> 
    <?= $form->field($model, 'date_time')->textInput(['readonly' => true]) ?> 
    <?= $form->field($model, 'co_code')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'dept_code')->textInput(['readonly' => true]) ?>
    
<?php } ?>

</div>
