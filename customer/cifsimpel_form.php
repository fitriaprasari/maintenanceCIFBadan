<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
use yii\bootstrap\Tabs;

$this->title = 'Maintenance CIF Simpel (Simpanan Pelajar)';
//$this->registerCss(".required label:after { content:' *';color:red; }");
?>
<div class="maintain-form">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo Yii::$app->session->getFlash('maintainCifsimpelfailed'); ?>


    <div class="maintain-form">
        <?php
        $form = ActiveForm::begin([
                    'layout' => 'horizontal',
                    'id' => 'maintain-form',
                    'fieldConfig' => [
                        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                        'horizontalCssClasses' => [
                            'label' => 'col-sm-3',
                            //'offset' => 'col-sm-offset-2',
                            'wrapper' => 'col-sm-8',
                            'error' => '',
                            'hint' => '',
                        //'input' => 'input sm'
                        ],
                    ],
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    
        ]);
        ?>
        
        <?= Tabs::widget([
        'items' => [
            [
                'label' => 'Nasabah',
                'content' => $this->render('cifsimpel_form_tab1', ['model' => $model, 'form' => $form]),
                //'active' => true itu maksudnya tab mana yang dibuka pertama kali ngeLoad
                'active' => true
            ],
            [
                'label' => 'Alamat',
                'content' => $this->render('cifsimpel_form_tab2', ['model' => $model, 'form' => $form]),
            ],
            [
                'label' => 'Informasi Orangtua',
                'content' => $this->render('cifsimpel_form_tab3', ['model' => $model, 'form' => $form]),

            ],
            [
                'label' => 'Informasi Lainnya',
                'content' => $this->render('cifsimpel_form_tab4', ['model' => $model, 'form' => $form]),

            ],
            [
                'label' => 'Audit',
                'content' => $this->render('cifsimpel_form_tab5', ['model' => $model, 'form' => $form]),

            ],
        ]]);
        ?>

         <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['id' => 'btn-submit', 'class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
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