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
<br>
    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true, 'readonly' => true]) ?>
    <?= $form->field($model, 'name_1')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'given_names')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'place_birth')->textInput(['maxlength' => true]) ?>
    <?=
    $form->field($model, 'birth_incorp_date')->textInput(['class' => 'datepicker'])->widget(
            \yii\jui\DatePicker::classname(), [
        'language' => 'id',
        'dateFormat' => 'yyyy-MM-dd',
        'clientOptions' => [
            'changeMonth' => true,
            'yearRange' => '1930:2099',
            'changeYear' => true,
            'showOn' => 'button',
            'buttonImage' => 'images/calendar.gif',
        ],
            ], ['class' => 'datepicker'])
    ?>
    <?= $form->field($model, 'moth_maiden')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'gender')->inline()->radioList(['MALE' => "LAKI -LAKI", "FEMALE" => "PEREMPUAN"]) ?>
    <?= $form->field($model, 'reside_y_n')->inline()->radioList(['Y' => "Y", "N" => "N"]) ?>
    <?= $form->field($model, 'nationality')->dropDownList(\app\models\Nationality::listNationality(), ['prompt' => 'Pilih Kewarganegaraan']) ?>
    <?= $form->field($model, 'domicile')->hiddenInput(['value'=> 'ID'])->label(false) ?>
    <?= $form->field($model, 'legal_type')->dropDownList(['01-KTP' => 'KTP', '02-SIM' => 'SIM', '03-PASSPORT/KITAS/KIMS' => 'PASSPORT/KITAS/KIMS'], ['prompt' => 'Pilih Jenis Identitas']) ?>

    <?php //$form->field($model, 'legal_id_no')->textInput(['maxlength' => 16]) ?>

    <?= $form->field($model, 'legal_id_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'marital_status')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'education')->dropDownList(\app\models\Longcif::getEducation(), ['prompt' => 'Pilih Pendidikan Terakhir']) ?>
    <?= $form->field($model, 'company_book')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
   

</div>

<?php
$this->registerJs('
        
        //Fungsi untuk melakukan pengecekan kartu identita KTP
        $("#cekid").click(function(){
        
            
            $.ajax({
                type:"GET",
                url:"' . Url::toRoute("customer/ceklookupcustomerlegalidno") . '",
                data:{legal_id_no: $("#' . Html::getInputId($model, 'legal_id_no') . '").val()},
                beforeSend: function(xhr){
                    $("#' . Html::getInputId($model, 'legal_id_no') . '").attr("disabled","disabled");
                    $("#cekid").prop("disabled", true);
                    $("#imgloader").show(); 
                },
                success:function(data){
                    
                    var dataId = jQuery.parseJSON(data);
                    if(dataId.status == "found"){
                        
                        if(dataId.legal_type == "01-KTP"){
                            alert("NO KTP :"+dataId.legal_id_no+" ,telah memiliki no cif : "+dataId.cif_no);
                        }else if(dataId.legal_type == "02-SIM"){
                            alert("NO SIM :"+dataId.legal_id_no+" ,telah memiliki no cif : "+dataId.cif_no);
                        }else if(dataId.legal_type == "03-Passport/KITAS/KIMS"){
                            alert("NO Passport/KITAS/KIMS :"+dataId.legal_id_no+" ,telah memiliki no cif : "+dataId.cif_no);
                        }else{
                            alert("Jenis identitas tidak terdeteksi atas nama :"+dataId.short_nm);
                        }
                    }else{
                        alert("No ID "+dataId.legal_id_no+" belum memiliki CIF");
                    }
                    
                    $("#' . Html::getInputId($model, 'legal_id_no') . '").removeAttr("disabled");
                    $("#cekid").prop("disabled", false);
                    $("#imgloader").hide();
                },
                error:function(){
                    alert("Maaf, Permintaan gagal. Silahkan periksa inputan anda");
                    $("#' . Html::getInputId($model, 'legal_id_no') . '").removeAttr("disabled");
                    $("#cekid").prop("disabled", false);
                    $("#' . Html::getInputId($model, 'legal_id_no') . '").val("").focus();
                    $("#imgloader").hide();
                }
            });
            /*$.ajax({
                type:"GET",
                url: "' . Url::toRoute("dukcapil/ktp/search") . '",
                data: {nik: $("#' . Html::getInputId($model, 'legal_id_no') . '").val()},
                beforeSend: function(xhr){
                    $("#' . Html::getInputId($model, 'legal_id_no') . '").attr("disabled","disabled");
                    $("#cekktp").prop("disabled", true);
                    $("#wait").html("Melakukan Pemeriksaan KTP...");
                },
                success: function (data_ktp) {
                    
                    $("#' . Html::getInputId($model, 'short_name') . '").val(data_ktp.nama_lengkap);
                    $("#' . Html::getInputId($model, 'place_birth') . '").val(data_ktp.tmpt_lhr);
                    $("#' . Html::getInputId($model, 'birth_incorp_date') . '").val(data_ktp.tgl_lhr);
                    $("#' . Html::getInputId($model, 'moth_maiden') . '").val(data_ktp.nama_lgkp_ibu);
                        
                    if(data_ktp.jenis_klmin == "LAKI-LAKI"){
                        $("input[name="Customer[gender]"][value="MALE"]").attr("checked", true);
                    }else if(data_ktp.jenis_klmin == "PEREMPUAN"){
                        $("input[name="Customer[gender]"][value="FEMALE"]").attr("checked", true);
                    }
                    
                    if(data_ktp.status_kawin == "MENIKAH"){
                        $("#' . Html::getInputId($model, 'marital_status') . '").val("MARRIED");
                    }else if(data_ktp.staus_kawin == "BELUM MENIKAH"){
                        $("#' . Html::getInputId($model, 'marital_status') . '").val("SINGLE");
                    }else if(data_ktp.status_kawin == "JANDA/DUDA"){
                        $("#' . Html::getInputId($model, 'marital_status') . '").val("WIDOWED");
                    }
                    
                    
                        
                    $("#' . Html::getInputId($model, 'legal_id_no') . '").removeAttr("disabled");
                    $("#cekktp").prop("disabled", false);
                    $("#wait").html("");
                },
                error: function (xhr,status,error){
                    alert("Maaf, Permintaan gagal. Silahkan periksa inputan anda");
                    $("#' . Html::getInputId($model, 'legal_id_no') . '").removeAttr("disabled");
                    $("#cekktp").prop("disabled", false);
                    $("#' . Html::getInputId($model, 'legal_id_no') . '").val("").focus();
                    $("#wait").html("");
                },
            });*/
    
        });
        
     ');
?>



