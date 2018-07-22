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

<div class="customer-form">

    <?php
    $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                    'horizontalCssClasses' => [
                        'label' => 'col-sm-3',
                        'offset' => 'col-sm-offset-4',
                        'wrapper' => 'col-sm-8',
                        'error' => '',
                        'hint' => '',
                        'input' => 'input sm'
                    ],
                ],
                'enableAjaxValidation' => false,
                'enableClientValidation' => false
    ]);
    ?>

    <?= $form->field($model, 'legal_type')->dropDownList(['01-KTP' => 'KTP', '03-Passport/KITAS/KIMS' => 'PASSPORT/KITAS/KIMS'], ['prompt' => 'Pilih Jenis Identitas']) ?>

    <?php //$form->field($model, 'legal_id_no')->textInput(['maxlength' => 16]) ?>

    <?=
    $form->field($model, 'legal_id_no', [
        'inputTemplate' => '<div class="input-group">{input}<span class="input-group-btn">
                  <button class="btn btn-success" id="cekid" type="button">
                     Cek ID
                  </button>
               </span></div>',
        'template' => '{label}'
        . '<div class="row">'
        . '<div class="col-sm-4">{input}{error}{hint}</div>'
        . '<div id="wait">' . Html::img('@web/images/ajax-loader.gif', ['id' => 'imgloader', 'style' => 'display:none']) . '</div>'
        . '</div>'
    ])->textInput(['maxlength' => true]);
    ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'place_birth')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'birth_incorp_date')->textInput(['class' => 'datepicker', 'readonly' => true])->widget(
            \yii\jui\DatePicker::classname(), [
        'language' => 'id',
        'dateFormat' => 'dd-MM-yyyy',
        'clientOptions' => [
            'changeMonth' => true,
            'yearRange' => '1900:2099',
            'changeYear' => true,
            'showOn' => 'button',
            'buttonImage' => Url::to('@web/images/calendaricon.gif'),
        ],
        'options' => ['readonly' => true]
            ], ['class' => 'datepicker'])
    ?>
    
    <?= $form->field($model, 'gender')->inline()->radioList(['MALE' => "LAKI -LAKI", "FEMALE" => "PEREMPUAN"]) ?>

    <?=
    $form->field($model, 'religion')->dropDownList(\app\models\Agama::listAgama(), [
        'prompt' => '----Pilih Agama----',
        
            ]
    );
    ?>
    
    <?= $form->field($model, 'moth_maiden')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'marital_status')->inline()->radioList(['MARRIED' => "MENIKAH", "SINGLE" => "BELUM MENIKAH", "WIDOWED" => "JANDA/DUDA"]) ?>

    <?= $form->field($model, 'nationality')->dropDownList(\app\models\Nationality::listNationality()) ?>

    <?= $form->field($model, 'reside_y_n')->inline()->radioList(['Y' => "Y", "N" => "N"]) ?>

    <?= $form->field($model, 'street')->textInput(['maxlength' => '36']) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => '36'])->label("") ?>

    <?= $form->field($model, 'rt_rw')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'town_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'province')->dropDownList(\app\models\Province::listProvince(), [
        'prompt' => '----Pilih Propinsi----',
        'onchange' => '$.post( "' . Url::toRoute("customer/getkabkot") . '", { id_prov: $(this).val() } ).done(function(data){'
        . '$( "#' . Html::getInputId($model, 'district_code') . '" ).html( data );});',
            ]
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

    <?= $form->field($model, 'post_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'addr_phone_area')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'addr_phone_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sms_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employment_kyc')->dropDownList(app\models\Employmentkyc::listEmployment(), ['prompt' => '---Pilih Jenis Pekerjaan---']) ?>

    <?= $form->field($model, 'ac_of_fund')->dropDownList(app\models\Acoffund::listSumberDana(), ['prompt' => '---Pilih Sumber Dana---']) ?>

    <?= $form->field($model, 'ac_open_purpose')->dropDownList(app\models\Acopenpurpose::listTujuanPembukaanCIF(), ['prompt' => "---Tujuan Pembukaan CIF--"]) ?>

    <?= $form->field($model, 'income')->dropDownList(app\models\Income::kisaranPendapatan(), ['prompt' => '---Kisaran Pendapatan---']) ?>

    <?= $form->field($model, 'monthly_txn_amt')->dropDownList(app\models\MonthlyTxnAmt::kisaranPengeluaran(), ['prompt' => '---Kisaran Pengeluaran---']) ?>

    <?= $form->field($model, 'txn_freq_mon')->dropDownList(app\models\TxnFreqMonth::kisaranTransaksi(), ['prompt' => '---Kisaran Transaksi---']) ?>

    <?= $form->field($model, 'cust_risk_prof')->dropDownList(app\models\Customer::getCustomerRiskProfile(), ['prompt' => '---Customer Risk Profile---']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['id' => 'btn-submit', 'class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs('
        
$("#btn-submit").click(
function(e){
    $(this).attr("disabled",true);
    return true;
}
);
        
        //Fungsi untuk melakukan pengecekan kartu identita KTP
        $("#cekid").click(function(){
        
            
            $.ajax({
                type:"GET",
                url:"' . Url::toRoute("customer/ceklookupcustomerlegalidno") . '",
                data:{legal_id_no: $("#' . Html::getInputId($model, 'legal_id_no') . '").val(),
                    legal_type: $("#' . Html::getInputId($model, 'legal_type') . '").val()},
                beforeSend: function(xhr){
                    $("#form").trigger("reset");
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
                    }else if(dataId.jeniskartu !== ""){
                        $("#' . Html::getInputId($model, 'short_name') . '").val(dataId.nama_lengkap).attr("readonly",true);
                        $("#' . Html::getInputId($model, 'place_birth') . '").val(dataId.tmpt_lhr).attr("readonly",true);
                        $("#' . Html::getInputId($model, 'birth_incorp_date') . '").val(dataId.tgl_lahir).attr("readonly",true);
                        $("#' . Html::getInputId($model, 'moth_maiden') . '").val(dataId.nama_lgkp_ibu);
                        $("#' . Html::getInputId($model, 'religion') . '").val(dataId.syiar_agama);    
                        if(dataId.no_rt!=""){
                            $("#' . Html::getInputId($model, 'rt_rw') . '").val(dataId.no_rt+"/"+dataId.no_rw).attr("readonly",true);  
                        }
                        if(dataId.alamat!=""){
                            $("#' . Html::getInputId($model, 'street') . '").val(dataId.alamat).attr("readonly",true);  
                        }
                        if(dataId.kec_name!=""){
                            $("#' . Html::getInputId($model, 'country') . '").val(dataId.kec_name).attr("readonly",true);
                        }
                        if(dataId.kel_name!=""){
                            $("#' . Html::getInputId($model, 'town_country') . '").val(dataId.kel_name).attr("readonly",true);  
                        }
                        $("#' . Html::getInputId($model, 'post_code') . '").val(dataId.kode_pos);    
                        $("#' . Html::getInputId($model, 'province') . '").val(dataId.syiar_noprop).attr("readonly",true);  
                        
                        $.when(setkablist(dataId.syiar_noprop)).then(function(){
                            $("#' . Html::getInputId($model, 'district_code') . '").val(dataId.syiar_nokab).attr("readonly",true);     
                        });
                        if(dataId.jenis_klmin == "LAKI-LAKI"){
                            $("input[name=' . "'Customer[gender]'" . '][value=' . "'MALE'" . ']").attr("checked", true);
                            $("input[name=' . "'Customer[gender]'" . '][value=' . "'FEMALE'" . ']").attr("disabled", true);    
                        }else if(dataId.jenis_klmin == "PEREMPUAN"){
                            $("input[name=' . "'Customer[gender]'" . '][value=' . "'FEMALE'" . ']").attr("checked", true);
                            $("input[name=' . "'Customer[gender]'" . '][value=' . "'MALE'" . ']").attr("disabled", true);    
                        }
                         
                            
                        if(dataId.status_kawin === "KAWIN"){                           
                            $("input[name=' . "'Customer[marital_status]'" . '][value=' . "'MARRIED'" . ']").attr("checked", true);      
                        }else if(dataId.status_kawin === "BELUM KAWIN"){                            
                            $("input[name=' . "'Customer[marital_status]'" . '][value=' . "'SINGLE'" . ']").attr("checked", true);    
                        }else if(dataId.status_kawin === "CERAI MATI"){
                            $("input[name=' . "'Customer[marital_status]'" . '][value=' . "'WIDOWED'" . ']").attr("checked", true);                            
                        }
                        
                    }else{
                        alert("No ID "+dataId.legal_id_no+" belum memiliki CIF");
                    }
                    
                    $("#' . Html::getInputId($model, 'legal_id_no') . '").removeAttr("disabled");
                    $("#cekid").prop("disabled", false);
                    $("#imgloader").hide();
                },
                error:function(xhr,status,error){
                    var err = eval("(" + xhr.responseText + ")");
                    alert("Maaf, Permintaan gagal. "+err.message);
                    $("#' . Html::getInputId($model, 'legal_id_no') . '").removeAttr("disabled");
                    $("#cekid").prop("disabled", false);
                    $("#' . Html::getInputId($model, 'legal_id_no') . '").val("").focus();
                    $("#imgloader").hide();
                }
            });
        
        });
        
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

');
?>



