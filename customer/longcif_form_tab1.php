<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\KabupatenKota;
use app\models\BadanUsaha;
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
   <?php if($cust_type == 'Badan Usaha/Lembaga'){    
   ?>
    
   <?= $form->field($model2, 'business_type')->dropDownList([
//                                                            '201-Badan Usaha Unit Desa' => 'Badan Usaha Unit Desa',
                                                            '201'=> 'Badan Usaha Unit Desa',
                                                            '202'=> 'Commanditor Venotschap (CV)',
                                                            '203'=> 'Debitur Kelompok',
                                                            '204'=> 'Ekspedisi Muatan Kapal Laut',
                                                            '205'=> 'Firma',
                                                            '206'=> 'Gabung Koperasi',
                                                            '207'=> 'Induk Koperasi',
                                                            '208'=> 'Koperasi',
                                                            '209'=>'Koperasi Unit Desa',
                                                            '210'=>'Limited',
                                                            '211'=>'Maskapai Andil Indonesia',
                                                            '212'=>'Namloose Venotschap (NV)',
                                                            '213'=>'Perusahaan Daerah',
                                                            '214'=>'Persero',
                                                            '215'=>'Persekutuan Perdata',
                                                            '216'=>'Perusahaan Umum',
                                                            '217'=>'Primer Koperasi',
                                                            '218'=>'Perseroan Terbatas',
                                                            '219'=>'Pusat Koperasi',
                                                            '220'=>'Pusat Koperasi Unit Desa',
                                                            '221'=>'Usaha Dagang',
                                                            '222'=>'Unit Dagang Kredit Pedesaan',
                                                            '223'=>'Yayasan',
                                                            '299'=>'Lainnya - Badan Usaha'],
                                                            ['' => 'Pilih Jabatan','style' => 'text-transform: uppercase']) ?>
    
    <?= $form->field($model2, 'oth_bsnss_type')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'short_name')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'name_1')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
    
    <?= $form->field($model2, 'type_of_inst')->dropDownList(['BUMS' => 'BUMS',
                                                             'BUMD'=>'BUMD',
                                                             'BUMN'=>'BUMN',
                                                             'Inst. Pemerintah Daerah' => 'Inst. Pemerintah Daerah',
                                                             'Inst. Pemerintah Pusat' => 'Inst. Pemerintah Pusat'],
                                                            ['' => 'Pilih Jenis Badan Usaha/Lembaga','style' => 'text-transform: uppercase']) ?>
      
   <?= $form->field($model2,'legal_doc_name')->dropDownList(\app\models\LegaldocName::listLegalDocName(),
                                                        ['' => 'Pilih Bidang Usaha','style' => 'text-transform: uppercase']) ?>
    
    <?= $form->field($model2, 'legal_id')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'legal_id_no')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
   
   <?= $form->field($model2, 'legal_iss_date')->textInput(['class' => 'datepicker'])->widget(
                                                                                \yii\jui\DatePicker::classname(),
                                                                              ['language' => 'id',
                                                                                'dateFormat' => 'yyyy-MM-dd',
                                                                                'clientOptions' => [
                                                                                    'changeMonth' => true,
                                                                                    'yearRange' => '1950:2045',
                                                                                    'changeYear' => true,
                                                                                    'showOn' => 'button',
                                                                                    'buttonImage' => 'images/calendar.gif',
                                                                                ],
                                                                              ], ['class' => 'datepicker'])
    ?>
   
   <?= $form->field($model2, 'legal_exp_date')->textInput(['class' => 'datepicker'])->widget(
                                                                                \yii\jui\DatePicker::classname(),
                                                                              ['language' => 'id',
                                                                                'dateFormat' => 'yyyy-MM-dd',
                                                                                'clientOptions' => [
                                                                                    'changeMonth' => true,
                                                                                    'yearRange' => '1950:2045',
                                                                                    'changeYear' => true,
                                                                                    'showOn' => 'button',
                                                                                    'buttonImage' => 'images/calendar.gif',
                                                                                ],
                                                                              ], ['class' => 'datepicker'])
    ?>
    <?= $form->field($model2, 'birth_incorp_date')->textInput(['class' => 'datepicker'])->widget(
                                                                                \yii\jui\DatePicker::classname(),
                                                                              ['language' => 'id',
                                                                                'dateFormat' => 'yyyy-MM-dd',
                                                                                'clientOptions' => [
                                                                                    'changeMonth' => true,
                                                                                    'yearRange' => '1950:2099',
                                                                                    'changeYear' => true,
                                                                                    'showOn' => 'button',
                                                                                    'buttonImage' => 'images/calendar.gif',
                                                                                ],
                                                                              ], ['class' => 'datepicker'])
    ?>
    
    <?= $form->field($model2, 'tax_reg_no')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase' ]) ?>
    <?= $form->field($model2, 'zakat_reg_no')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'nationality')->dropdownList(['ID' => 'Indonesia'],
//                                                                            'LN' => 'Luar Negeri'],
                                                           ['' => 'Pilih Negara']) ?>
    
    <?= $form->field($model2,'reside_y_n')->dropdownList(['Y'=>'Y','N'=>'N'],['' => 'Pilih'])?>
    <?= $form->field($model2,'domicile_1')->dropdownList(['ID' => 'Indonesia'],
                                                                          ['' => 'Pilih Negara Domisili','style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2,'introducer')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2,'sector')->dropDownList(app\models\Sector::getSector(),['' => '-Pilih-','style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2,'sid_eco_sector')->dropDownList(\app\models\BadanUsaha::listBadanUsaha(),
                                                        ['' => 'Pilih Bidang Usaha','style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2,'company_book')->textInput(['maxlength' => true,'readonly'=>true]) ?>
    <?= $form->field($model2,'contact_date')->textInput(['maxlength' => true,'readonly'=>true,'style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2,'mud_printed_nam')->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
       
   <?php }else{ ?>
    <!--form cif perseorangan-->
    <?= $form->field($model, 'cust_title_1')->dropDownList(\app\models\CusTitle::getCusTitle(), ['' => 'Pilih Gelar Sebelum Nama']) ?>
    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'cust_title_2')->dropDownList(\app\models\CusTitle::getCusTitle(), ['' => 'Pilih Gelar Sesudah Nama']) ?>
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
    <?= $form->field($model, 'religion')->dropDownList(\app\models\Longcif::getReligion(), ['' => 'Pilih Agama']) ?>
    <?= $form->field($model, 'gender')->inline()->radioList(['MALE' => "LAKI -LAKI", "FEMALE" => "PEREMPUAN"]) ?>
    <?= $form->field($model, 'reside_y_n')->inline()->radioList(['Y' => "Y", "N" => "N"]) ?>
    <?= $form->field($model, 'domicile')->dropDownList(\app\models\Nationality::listNationality(), ['' => 'Pilih Domisili']) ?>
    <?= $form->field($model, 'nationality')->dropDownList(\app\models\Nationality::listNationality(), ['' => 'Pilih Kewarganegaraan']) ?>

    <?= $form->field($model, 'legal_type')->dropDownList(['01-KTP' => 'KTP', '02-SIM' => 'SIM', '03-PASSPORT/KITAS/KIMS' => 'PASSPORT/KITAS/KIMS'], ['' => 'Pilih Jenis Identitas']) ?>
    <?= $form->field($model, 'legal_id_no')->textInput(['maxlength' => 16]) ?>

    <?=
    $form->field($model, 'legal_iss_date')->textInput(['class' => 'datepicker'])->widget(
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

    <?=
    $form->field($model, 'expiry_dte_id')->textInput(['class' => 'datepicker'])->widget(
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
    <?= $form->field($model, 'marital_status')->inline()->radioList(['MARRIED' => "MENIKAH", "SINGLE" => "BELUM MENIKAH", "WIDOWED" => "JANDA/DUDA"]) ?>
    <?= $form->field($model, 'no_of_dependents')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'education')->dropDownList(\app\models\Longcif::getEducation(), ['' => 'Pilih Pendidikan Terakhir']) ?>
    <?= $form->field($model, 'company_book')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
    <?= $form->field($model, 'contact_date')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
    <?= $form->field($model, 'mud_printed_nam')->textInput(['maxlength' => true]) ?>
   <?php }?>
    
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
    
        });');
?>