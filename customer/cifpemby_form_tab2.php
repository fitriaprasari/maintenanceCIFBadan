<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\KabupatenKota;

//use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="maintain-form">


    <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true])->label("") ?>

    <?= $form->field($model, 'rt_rw')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'province')->dropDownList(\app\models\Province::listProvince(), [
        'prompt' => '----Pilih Propinsi----',
        'onchange' => '$.post( "' . Url::toRoute("customer/getkabkot") . '", { id_prov: $(this).val() } ).done(function(data){'
        . '$( "#' . Html::getInputId($model, 'district_code') . '" ).html( data );});'
            , 'readonly'=>true]
    );
    ?>

    <?=
    $form->field($model, 'district_code')->dropDownList(
            KabupatenKota::listKabKot($model->province), [
        'prompt' => '---Pilih Kabupatan Kota---',
        'onchange' => '$.get( "' . Url::toRoute("customer/getkodepos") . '", { id: $(this).val() } ).done(function(data){'
        . '$( "#' . Html::getInputId($model, 'post_code') . '" ).val(data);});',
            ]
    );
    ?>
    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'town_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'addr_phone_area')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'addr_phone_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sms_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_1')->textInput(['maxlength' => true]) ?>

    ________________________ Alamat Domisili __________________________
    <br><br>
    <?= $form->field($model, 'same_as_resadd')->inline()->radioList(['Y' => "Y", "N" => "N"]) ?>

    <?= $form->field($model, 'po_box_no')->textInput(['maxlength' => '36']) ?>

    <?= $form->field($model, 'po_rt_rw')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'po_province')->dropDownList(\app\models\Province::listProvince(), [
        'prompt' => '----Pilih Propinsi----',
        'onchange' => '$.post( "' . Url::toRoute("customer/getkabkot") . '", { id_prov: $(this).val() } ).done(function(data){'
        . '$( "#' . Html::getInputId($model, 'po_dist_code') . '" ).html( data );});', 'readonly'=>true
            ]
    );
    ?>

    <?=
    $form->field($model, 'po_dist_code')->dropDownList(
            // KabupatenKota::listKabKot(Html::getInputId($model, 'po_province')), [
            KabupatenKota::listKabKot($model->po_province), [
        'prompt' => '---Pilih Kabupatan Kota---',
        'onchange' => '$.get( "' . Url::toRoute("customer/getkodepos") . '", { id: $(this).val() } ).done(function(data){'
        . '$( "#' . Html::getInputId($model, 'po_post_code') . '" ).val(data);});',
            ]
    );
    ?>
    <?= $form->field($model, 'po_city_municip')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'po_suburb_town')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'po_post_code')->textInput(['maxlength' => true, 'readonly'=>true]) ?>

</div>

<?php
$this->registerJs('
        
$("#btn-submit").click(
function(e){
    $(this).attr("disabled",true);
    return true;
}
);        
        
function setkablist(dat1){
    return $.ajax({
        type:"POST",
        url:"' . Url::toRoute("customer/getkabkot") . '",
        data:{id_prov:dat1},
        success:function(data){
            $( "#' . Html::getInputId($model, 'district_code') . '" ).html( data );
        },
    });
}


    $(\'#' . Html::getInputId($model, 'same_as_resadd') . '\').change(function(){
        
        var selected = $("#' . Html::getInputId($model, 'same_as_resadd') . ' input[type=\'radio\']:checked");
        if (selected.length > 0) {   
            var sad = selected.val();            
            if(sad == "Y"){
            $("#' . Html::getInputId($model, 'po_province') . '").val($("#' . Html::getInputId($model, 'province') . '").val());
            //$("#' . Html::getInputId($model, 'po_province') . '").change();
            
            $.post( "' . Url::toRoute("customer/getkabkot") . '", { id_prov: $("#' . Html::getInputId($model, 'province') . '").val(),id_kab: $("#' . Html::getInputId($model, 'district_code') . '").val() } ).done(function(data){'
        . '$( "#' . Html::getInputId($model, 'po_dist_code') . '" ).html( data );});
            
            $("#' . Html::getInputId($model, 'po_box_no') . '").val($("#' . Html::getInputId($model, 'street') . '").val());
            $("#' . Html::getInputId($model, 'po_rt_rw') . '").val($("#' . Html::getInputId($model, 'rt_rw') . '").val());
            $("#' . Html::getInputId($model, 'po_suburb_town') . '").val($("#' . Html::getInputId($model, 'town_country') . '").val());
            $("#' . Html::getInputId($model, 'po_city_municip') . '").val($("#' . Html::getInputId($model, 'country') . '").val());
            
            //$("#' . Html::getInputId($model, 'po_dist_code') . '").val($("#' . Html::getInputId($model, 'district_code') . '").val());
            $("#' . Html::getInputId($model, 'po_post_code') . '").val($("#' . Html::getInputId($model, 'post_code') . '").val());
            }
            else{
                $("#' . Html::getInputId($model, 'po_box_no') . '").val("");
                $("#' . Html::getInputId($model, 'po_box_no') . '").val("");
                $("#' . Html::getInputId($model, 'po_rt_rw') . '").val("");
                $("#' . Html::getInputId($model, 'po_suburb_town') . '").val("");
                $("#' . Html::getInputId($model, 'po_city_municip') . '").val("");
                $("#' . Html::getInputId($model, 'po_province') . '").val("");
                $("#' . Html::getInputId($model, 'po_dist_code') . '").val("");
                $("#' . Html::getInputId($model, 'po_post_code') . '").val("");
            }
        }
    });


');
?>




