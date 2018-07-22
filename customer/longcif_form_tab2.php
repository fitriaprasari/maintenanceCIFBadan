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
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>


<?php if($cust_type == "Badan Usaha/Lembaga") { ?>

    <!--tab 2 Alamat Lengkap-->
    <?= $form->field($model2, 'street')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'address')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'rt_rw')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
     
    <?=
    $form->field($model2, 'province')->dropDownList(\app\models\Province::listProvince(), [
        '' => '----Pilih Propinsi----','style' => 'text-transform: uppercase',
        'onchange' => '$.post( "' . Url::toRoute("customer/getkabkot") . '", { id_prov: $(this).val() } ).done(function(data){'
        . '$( "#' . Html::getInputId($model2, 'district_code') . '" ).html( data );});',
            ]
    );
    ?>
    <?=
    $form->field($model2, 'district_code')->dropDownList(
        KabupatenKota::listKabKot($model2->province), [
        '' => '---Pilih Kabupatan Kota---','style' => 'text-transform: uppercase',
        'onchange' => '$.get( "' . Url::toRoute("customer/getkodepos") . '", { id: $(this).val() } ).done(function(data){'
        . '$( "#' . Html::getInputId($model2, 'post_code') . '" ).val(data);});',
            ]);
    ?>
    
    
    <?php
//    $form->field($model2, 'district_code', [
//
//        'inputTemplate' => '<div class="input-group" id="cariKodePos">{input}<span class="input-group-btn">
//                  <button class="btn btn-success" type="button">
//                     <i class="glyphicon glyphicon-search"></i>
//                  </button>
//               </span></div>',
//        'template' => '{label}'
//        . '<div class="row">'
//        . '<div class="col-sm-4">{input}{error}{hint}</div>'
//        . '</div>']
//    )->textInput(['maxlength' => true, 'readonly' => true]);
    ?>
    
    <?= $form->field($model2, 'country')->textInput(['maxlength'=>true,'style' => 'text-transform: uppercase'])?>
    <?= $form->field($model2, 'town_country')->textInput(['maxlength'=>true,'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'post_code')->textInput(['maxlength'=>true,'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'residence')->dropDownList(['ID'=>'Indonesia'],[''=>'Pilih Negara','style' => 'text-transform: uppercase']); ?>
    <?= $form->field($model2, 'addr_phone_area')->textInput(['maxlength'=>true]) ?>
    <?= $form->field($model2, 'addr_phone_no')->textInput(['maxlength'=>true]) ?>
    <?= $form->field($model2, 'contact_fax_no')->textInput(['maxlength'=>true]) ?>
    <?= $form->field($model2, 'email_1')->textInput(['maxlength'=>true]) ?>

________________________ Alamat Surat Menyurat __________________________
<br><br>
    <?php $model2->same_as_resadd = "N";?>
    <?= $form->field($model2, 'same_as_resadd')->inline()->radioList(['Y' => "Y", "N" => "N"]) ?>
    <?= $form->field($model2, 'po_box_no')->textInput(['maxlength'=>true]) ?>
    <?= $form->field($model2, 'po_rt_rw')->textInput(['maxlength'=>true]) ?>

    <?=
    $form->field($model2, 'po_province')->dropDownList(\app\models\Province::listProvince(), [
        '' => '----Pilih Propinsi----','style' => 'text-transform: uppercase',
        'onchange' => '$.post( "' . Url::toRoute("customer/getkabkot") . '", { id_prov: $(this).val() } ).done(function(data){'
        . '$( "#' . Html::getInputId($model2, 'district_code') . '" ).html( data );});',
            ]
    );
    ?>

   <?=
    $form->field($model2, 'po_dist_code')->dropDownList(
        KabupatenKota::listKabKot($model2->province), [
        '' => '---Pilih Kabupatan Kota---','style' => 'text-transform: uppercase']);
    ?>

    <?= $form->field($model2, 'po_city_municip')->textInput(['maxlength'=>true,'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'po_suburb_town')->textInput(['maxlength'=>true,'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'po_post_code')->textInput(['maxlength'=>true]) ?>
    <?= $form->field($model2, 'domicile_2')->dropDownList(['ID'=>'Indonesia'],[''=>'Pilih Negara','style' => 'text-transform: uppercase']) ?>
    
<?php } else { ?>

    <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'address')->textInput(['maxlength' => true])->label("") ?>
    <?= $form->field($model, 'rt_rw')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'province')->dropDownList(\app\models\Province::listProvince(), [
        '' => '----Pilih Propinsi----',
        'onchange' => '$.post( "' . Url::toRoute("customer/getkabkot") . '", { id_prov: $(this).val() } ).done(function(data){'
        . '$( "#' . Html::getInputId($model, 'district_code') . '" ).html( data );});',
            ]
    );
    ?>

    <?=
    $form->field($model, 'district_code')->dropDownList(
            KabupatenKota::listKabKot($model->province), [
        '' => '---Pilih Kabupatan Kota---',
        'onchange' => '$.get( "' . Url::toRoute("customer/getkodepos") . '", { id: $(this).val() } ).done(function(data){'
        . '$( "#' . Html::getInputId($model, 'post_code') . '" ).val(data);});',
            ]
    );
    ?>

    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'town_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'residence_status')->dropDownList(\app\models\Longcif::getResidenceStatus(), ['' => 'Pilih Status Tempat Tinggal']) ?>

    <?= $form->field($model, 'other_residence')->textInput(['maxlength' => 69]) ?>

    <?= $form->field($model, 'addr_phone_area')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'addr_phone_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sms_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_1')->textInput(['maxlength' => true]) ?>

________________________ Alamat Domisili __________________________
<br><br>
   
    <?= $form->field($model, 'same_as_resadd')->inline()->radioList(['Y' => "Y", 'N' => "N"]) ?>

    <?= $form->field($model, 'po_box_no')->textInput(['maxlength' => '36']) ?>

    <?= $form->field($model, 'po_rt_rw')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'po_province')->dropDownList(\app\models\Province::listProvince(), [
        '' => '----Pilih Propinsi----',
        'onchange' => '$.post( "' . Url::toRoute("customer/getkabkot") . '", { id_prov: $(this).val() } ).done(function(data){'
        . '$( "#' . Html::getInputId($model, 'po_dist_code') . '" ).html( data );});',
            ]
    );
    ?>

    <?=
    $form->field($model, 'po_dist_code')->dropDownList(
            // KabupatenKota::listKabKot(Html::getInputId($model, 'po_province')), [
            KabupatenKota::listKabKot($model->po_province), [
        '' => '---Pilih Kabupatan Kota---',
        'onchange' => '$.get( "' . Url::toRoute("customer/getkodepos") . '", { id: $(this).val() } ).done(function(data){'
        . '$( "#' . Html::getInputId($model, 'po_post_code') . '" ).val(data);});',
            ]
    );
    ?>
    <?= $form->field($model, 'po_city_municip')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'po_suburb_town')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'po_post_code')->textInput(['maxlength' => true]) ?>

________________________ Alamat Surat Menyurat __________________________
<br><br>

<?= $form->field($model, 'corspd_addr_opt')->dropDownList([''=>'Pilih Alamat Surat Menyurat','Alamat Domisili' => 'Alamat Domisili', 'Alamat Sesuai Identitas' => 'Alamat Sesuai Identitas', 'Alamat Tempat Bekerja' => 'Alamat Tempat Bekerja']) ?>
<?php } ?>
</div>

<?php if($cust_type == "Perorangan"){
    
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

//                $("#' . Html::getInputId($model, 'po_dist_code') . '").val($("#' . Html::getInputId($model, 'district_code') . '").val());
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
} else {
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
                    $( "#' . Html::getInputId($model2, 'post_code') . '" ).html( data );
                },
            });
        }
        
//       $(\'#'.Html::getInputId($model2, 'same_as_resadd').'\').change(function()){
//         var selected = $("#' . Html::getInputId($model2, 'same_as_resadd') . ' input[type=\'radio\']:checked");
//         if(selected.length > 0){
//           var sad = selected.val();
//           if(sad == "Y"){
//           
//           $("#' . Html::getInputId($model2, 'po_box_no') . '").val($("#' . Html::getInputId($model2, 'street') . '").val());
//           $("#' . Html::getInputId($model2, 'po_rt_rw') . '").val($("#' . Html::getInputId($model2, 'rt_rw') . '").val());
//           $("#' . Html::getInputId($model2, 'po_province') . '").val($("#' . Html::getInputId($model2, 'province') . '").val());
             $.post( "' . Url::toRoute("customer/getkabkot") . '", { id_prov: $("#' . Html::getInputId($model2, 'po_province') . '").val(),id_kab: $("#' . Html::getInputId($model, 'district_code') . '").val() } ).done(function(data){'
            . '$( "#' . Html::getInputId($model, 'po_dist_code') . '" ).html( data );});
//           $("#' . Html::getInputId($model2, 'po_dist_code') . '").val($("#' . Html::getInputId($model2, 'district_code') . '").val());
//           $("#' . Html::getInputId($model2, 'po_city_municip') . '").val($("#' . Html::getInputId($model2, 'country') . '").val());
//           $("#' . Html::getInputId($model2, 'po_suburb_town') . '").val($("#' . Html::getInputId($model2, 'town_country') . '").val());
//           $("#' . Html::getInputId($model2, 'po_post_code') . '").val($("#' . Html::getInputId($model2, 'post_code') . '").val());
//           $("#' . Html::getInputId($model2, 'domicile') . '").val($("#' . Html::getInputId($model2, 'residence') . '").val());
//           } else {
//           $("#' . Html::getInputId($model2, 'po_box_no') . '").val("");
//           $("#' . Html::getInputId($model2, 'po_rt_rw') . '")..val("");
//           $("#' . Html::getInputId($model2, 'po_province') . '")..val("");
             

//           $("#' . Html::getInputId($model2, 'po_dist_code') . '")..val("");
//           $("#' . Html::getInputId($model2, 'po_city_municip') . '").val("");
//           $("#' . Html::getInputId($model2, 'po_suburb_town') . '").val("");
//           $("#' . Html::getInputId($model2, 'po_post_code') . '").val("");
//           $("#' . Html::getInputId($model2, 'domicile') . '").val("");
//           }
//        });
        

        //new
        $(\'#' . Html::getInputId($model2, 'same_as_resadd') . '\').change(function(){
            var selected = $("#' . Html::getInputId($model2, 'same_as_resadd') . ' input[type=\'radio\']:checked");
            if (selected.length > 0) {   
                var sad = selected.val();            
                if(sad == "Y"){
                   $("#' . Html::getInputId($model2, 'po_box_no') . '").val($("#' . Html::getInputId($model2, 'street') . '").val());
                   $("#' . Html::getInputId($model2, 'po_rt_rw') . '").val($("#' . Html::getInputId($model2, 'rt_rw') . '").val());
                   $("#' . Html::getInputId($model2, 'po_province') . '").val($("#' . Html::getInputId($model2, 'province') . '").val());
                       
                   $.post( "' . Url::toRoute("customer/getkabkot") . '", { id_prov: $("#' . Html::getInputId($model2, 'po_province') . '").val(),id_kab: $("#' . Html::getInputId($model2, 'district_code') . '").val() } ).done(function(data){'
                   . '$( "#' . Html::getInputId($model2, 'po_dist_code') . '" ).html( data );});

                   //$("#' . Html::getInputId($model2, 'po_dist_code') . '").val($("#' . Html::getInputId($model2, 'district_code') . '").val());
                   $("#' . Html::getInputId($model2, 'po_city_municip') . '").val($("#' . Html::getInputId($model2, 'country') . '").val());
                   $("#' . Html::getInputId($model2, 'po_suburb_town') . '").val($("#' . Html::getInputId($model2, 'town_country') . '").val());
                   $("#' . Html::getInputId($model2, 'po_post_code') . '").val($("#' . Html::getInputId($model2, 'post_code') . '").val());
                   $("#' . Html::getInputId($model2, 'domicile') . '").val($("#' . Html::getInputId($model2, 'residence') . '").val());
                   $("#' . Html::getInputId($model2, 'domicile_2') . '").val($("#' . Html::getInputId($model2, 'residence') . '").val());
                }
                else{
                   $("#' . Html::getInputId($model2, 'po_box_no') . '").val("");
                   $("#' . Html::getInputId($model2, 'po_rt_rw') . '").val("");
                   $("#' . Html::getInputId($model2, 'po_province') . '").val("");
                   $("#' . Html::getInputId($model2, 'po_dist_code') . '").val("");
                   $("#' . Html::getInputId($model2, 'po_city_municip') . '").val("");
                   $("#' . Html::getInputId($model2, 'po_suburb_town') . '").val("");
                   $("#' . Html::getInputId($model2, 'po_post_code') . '").val("");
                   $("#' . Html::getInputId($model2, 'domicile') . '").val("");
                   $("#' . Html::getInputId($model2, 'domicile_2') . '").val("");
                }
            }
        });



');
}
?>

<?php
$this->registerJs('
        var jenis_button = "";        
$("#btn-submit").click(
function(e){
    $(this).attr("disabled",true);
    return true;
}
);        
        
$("#cariKodePos").focusin(
function(e){
    jenis_button = "identitas";
    $("#search-kodepos-modal").modal("show");
}
);
        
        
$("#cariKodePosPo").focusin(
function(e){
    jenis_button = "domisili";
    $("#search-kodepos-modal").modal("show");
}
);  

$("#search_kode_pos").submit(function() {
    var src_type = $("#src_type").val();
    var src_keyword = $("#src_keyword").val();
    $.ajax({
        type: "post",
        url : "' . Url::toRoute("cif/search-kode-pos") . '",
        data : $(this).serialize()+"&src_type="+src_type+"&src_keyword="+src_keyword,
        dataType: "html",
        beforeSend:function(){
            $("#ajax-loader").show();
        },
        error: function(jqXHR, textStatus, errorThrown){
            $("#ajax-loader").hide();
            alert("");
        },
        success: function(data){
                        $("#ajax-loader").hide();
                        if(data ==  false)
                        {
                                alert("Kata kunci Pencarian salah!");
                        }
                        else
                        {
                                $("#div_pencarian_kodepos").html(data);
                                pilih_kode_pos();
                        }

           return false;
        }
    });
    return false;
});

function pilih_kode_pos(){
    $(".pilih_kode_pos").off().click(function(){
        var prop_no = $(this).attr("r_prop_no"); var prop_nm = $(this).attr("r_prop_nm"); 
        var kab_no = $(this).attr("r_kab_no"); var kab_nm = $(this).attr("r_kab_nm"); 
        var kec_no = $(this).attr("r_kec_no"); var kec_nm = $(this).attr("r_kec_nm"); 
        var kel_no = $(this).attr("r_kel_no"); var kel_nm = $(this).attr("r_kel_nm"); 
        var kodepos = $(this).attr("r_kodepos");

        if(jenis_button == "identitas")
        {
            $("#' . Html::getInputId($model2, 'province') . '").val(prop_no); $("#province_nm").html(prop_nm);
            $("#' . Html::getInputId($model2, 'district_code') . '").val(kab_no); $("#district_code_nm").html(kab_nm);
            $("#' . Html::getInputId($model2, 'country') . '").val(kec_no); $("#country_nm").html(kec_nm);
            $("#' . Html::getInputId($model2, 'town_country') . '").val(kel_no); $("#town_country_nm").html(kel_nm);
            $("#' . Html::getInputId($model2, 'post_code') . '").val(kodepos);

        }
        else if(jenis_button == "domisili")
        {
            $("#' . Html::getInputId($model, 'po_province') . '").val(prop_no); $("#po_province_nm").html(prop_nm);
            $("#' . Html::getInputId($model, 'po_dist_code') . '").val(kab_no); $("#po_dist_code_nm").html(kab_nm);
            $("#' . Html::getInputId($model, 'po_city_municip') . '").val(kec_no); $("#po_city_municip_nm").html(kec_nm);
            $("#' . Html::getInputId($model, 'po_suburb_town') . '").val(kel_no); $("#po_suburb_town_nm").html(kel_nm);
            $("#' . Html::getInputId($model, 'po_post_code') . '").val(kodepos);

        }

        $("#search-kodepos-modal").modal("hide");
        return false;
    });
}');

?>