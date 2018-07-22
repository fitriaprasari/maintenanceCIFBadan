<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\Customercorp;
use app\models\Province;
use app\models\KabupatenKota;
use app\models\Nationality;
use app\models\TxnFreqMonth;
use app\models\MonthlyTxnAmt;
use app\models\Acopenpurpose;
use app\models\BussinesType;

//use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'MyForm',
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
    ======================== Data Badan Usaha/Lembaga =======================
    <br><br>
    <?= $form->field($model, 'business_type')->dropDownList(\app\models\BussinesType::getBusinessType(), [ 'prompt' => '----Pilih Bentuk Badan Usaha----']) ?>
    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'type_of_inst')->dropDownList(\app\models\Customercorp::getInstitutionType(), [ 'prompt' => '----Pilih Jenis Badan Usaha----']) ?>
    <?= $form->field($model, 'legal_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'legal_doc_name')->dropDownList(\app\models\Customercorp::getLegalDocName(), [ 'prompt' => '----Pilih Jenis Akta----']) ?>
    <?= $form->field($model, 'legal_id_no')->textInput(['maxlength' => true]) ?>
    <?=
    $form->field($model, 'birth_incorp_date')->textInput(['class' => 'datepicker', 'readonly' => true])->widget(
            \yii\jui\DatePicker::classname(), [
        'language' => 'id',
        'dateFormat' => 'dd-MM-yyyy',
        'clientOptions' => [
            'changeMonth' => true,
            'yearRange' => '1900:2115',
            'changeYear' => true,
            'showOn' => 'button',
            'buttonImage' => Url::to('@web/images/calendaricon.gif'),
        ],
        'options' => ['readonly' => true]
            ], ['class' => 'datepicker'])
    ?>

    <?= $form->field($model, 'tax_reg_no')->textInput(['maxlength' => '16']) ?>

    <?= $form->field($model, 'nationality')->dropDownList(\app\models\Nationality::listNationality(), [ 'prompt' => '----Pilih Negara Asal----']) ?>

    <?= $form->field($model, 'reside_y_n')->inline()->radioList(['Y' => "Y", "N" => "N"]) ?>


    ========================= Alamat Lengkap ================================
    <br><br>
    <?= $form->field($model, 'street')->textInput(['maxlength' => '36']) ?>
    <?= $form->field($model, 'address')->textInput(['maxlength' => '36']) ?>

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
           // KabupatenKota::listKabKot(Html::getInputId($model, 'province')), [
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

    <?= $form->field($model, 'introducer')->textInput(['maxlength' => true]) ?>
    ________________________ Alamat Surat Menyurat __________________________
    <br><br>
    <?= $form->field($model, 'same_as_resadd')->inline()->radioList(['Y' => "Y", "N" => "N"]) ?>

    <?= $form->field($model, 'po_box_no')->textInput(['maxlength' => '36']) ?>

    <?= $form->field($model, 'po_rt_rw')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'po_suburb_town')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'po_city_municip')->textInput(['maxlength' => true]) ?>
    
    
    <?=
    $form->field($model, 'po_province')->dropDownList(\app\models\Province::listProvince(), [
        'prompt' => '----Pilih Propinsi----',
        'onchange' => '$.post( "' . Url::toRoute("customer/getkabkot") . '", { id_prov: $(this).val() } ).done(function(data){'
        . '$( "#' . Html::getInputId($model, 'po_dist_code') . '" ).html( data );});',
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
    
    <?= $form->field($model, 'po_post_code')->textInput(['maxlength' => true]) ?>

    ========================= Data Keuangan =============================
    <br><br>		
    <?= $form->field($model, 'ni_ac_o_purpose')->dropDownList(app\models\Customercorp::getAccPurpose(), ['prompt' => "---Tujuan Pembukaan Rekening--"]) ?>
    <?= $form->field($model, 'oth_acc_open_pr')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'profit')->dropDownList(app\models\Customercorp::getProfit(), ['prompt' => '---Kisaran Laba---']) ?>
    <?= $form->field($model, 'income')->dropDownList(app\models\Customercorp::getIncome(), ['prompt' => '---Kisaran Pendapatan---']) ?>

    <?= $form->field($model, 'monthly_txn_amt')->dropDownList(app\models\MonthlyTxnAmt::kisaranPengeluaran(), ['prompt' => '---Kisaran Pengeluaran---']) ?>

    <?= $form->field($model, 'txn_freq_mon')->dropDownList(app\models\TxnFreqMonth::kisaranTransaksi(), ['prompt' => '---Kisaran Transaksi---']) ?>
    <?= $form->field($model, 'ni_source_fund')->dropDownList(app\models\Customercorp::getSourceFund(), ['prompt' => '---Pilih Sumber Dana---']) ?>
    <?= $form->field($model, 'oth_fund_source')->textInput(['maxlength' => true]) ?>
    
    ========================= Informasi Lainnya ============================
    <br><br>
    <!-- Ini untuk mengambil Account Officer dengan inquiry -->
    <?=
    $form->field($model, 'account_officer', [
        'inputTemplate' => '
            <div class="">{input}</div>',
        'template' => '{label}'
        . '<div class="row">'
        . '<div class="col-sm-2">{input}{error}{hint}</div>'
        . '<span style="margin-top:8px; display:block;" id="ao_desc"></span>'
        . '</div>']
    )->textInput(['maxlength' => true, 'readonly' => false, 'onblur' => ''
        . 'if(this.value != ""){'
        . '   $("#ao-desc-loader").show();'
        . '   $.post( "' . Url::toRoute("/accountofficer/getlokal") . '", { id: this.value } ).done(function(data){ '
        . '     var obj = JSON.parse(data);'
        . '     if(obj.status == "NA") $( "#' . Html::getInputId($model, 'account_officer') . '" ).val(""); '
        . '     $("#ao_desc").html(obj.desc);'
        . '     $("#ao-desc-loader").hide();'
        . '   });'
        . '  '
        . '}'
    ]);
    ?>
    <div id="ao-desc-loader" style="display: none"><img src="../../images/ajax-loader.gif"/> <i>Loading AO Info...</i></div>

    <?= $form->field($model, 'target')->dropDownList(app\models\Customercorp::getSegmentasi(), ['prompt' => '---Pilih Segmentasi---']) ?>
    <?= $form->field($model, 'taxable')->inline()->radioList(['Y' => "Y", "N" => "N"]) ?>
    <?= $form->field($model, 'company_book')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'contact_date')->textInput(['maxlength' => true, 'readonly' => true]) ?>
    
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



