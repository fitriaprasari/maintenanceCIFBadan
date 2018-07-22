<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
use yii\bootstrap\Tabs;

$this->title = 'Maintenance CIF Lengkap';
$this->registerCss(".required label:after { content:' *';color:red; }");
?>
<div class="maintain-form">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo Yii::$app->session->getFlash('maintainlongCIFfailed'); ?>

    <!--pencarian kodepos-->
    <div class="customer-create">    
    <div id='search-kodepos-modal' class="modal fade modal-v1">
        <form id="search_kode_pos" name="search_kode_pos" class="form-horizontal">
            <div class="modal-dialog container">
                <div class="row">
                    <!-- Modal content-->
                    <div class="modal-content col-lg-11" style="padding:0px;">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h4 class="modal-title" id="modal_title">Pencarian Kode Pos</h4>
                        </div>
                        <div class="modal-body" id="modal_body" style="padding:0px;">
                            <div class="panel-body">
                                <div class="form-horizontal">
                                    <div class="form-group form-group-sm" style="padding-bottom: 10px;">
                                        <label for="Jenis Pencarian" class="col-lg-3 col-sm-3 control-label">Jenis Pencarian</label>
                                        <div class="col-lg-5 col-sm-6">
                                            <select id="src_type" name="src_type" class="form-control">
                                                <option value="kodepos">Kode Pos</option>
                                                <option value="kelurahan">Kelurahan/Desa</option>
                                                <option value="kecamatan">Kecamatan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-horizontal">
                                    <div class="form-group form-group-sm" style="padding-bottom: 10px;">
                                        <label for="Kata Kunci" class="col-lg-3 col-sm-3 control-label">Kata Kunci</label>
                                        <div class="col-lg-5 col-sm-6">
                                            <input id="src_keyword" name="src_keyword" class="text_input medium form-control" placeholder="Kata Kunci" autocomplete="off" value="" maxlength="40" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div id="ajax-loader" style="display: none"><?= Html::img('@web/images/ajax-loader.gif') ?> <i>Loading Data...</i></div>
                                <div id="no-more-tables" style="font-size: 12px;">
                                    <div id="div_pencarian_kodepos"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="cari_kode_pos">Cari</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>    
    </div>
    
    

    <div class="maintain-form">
        <?php
        $form = ActiveForm::begin([
                    'layout' => 'horizontal',
                    'id' => 'maintain-form',
                    'fieldConfig' => [
                        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                        'horizontalCssClasses' => [
                            'label' => 'col-sm-2',
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
        <!--customer type = Perorangan-->
        <?php if ($cust_type == 'Perorangan'){?>
        <?= Tabs::widget([
        'items' => [
            [
                'label' => 'Nasabah',
                'content' => $this->render('longcif_form_tab1', ['cust_type'=>$cust_type,'model' => $model, 'form' => $form]),
                //'active' => true itu maksudnya tab mana yang dibuka pertama kali ngeLoad
                'active' => true
            ],
            [
                'label' => 'Alamat',
                'content' => $this->render('longcif_form_tab2', ['cust_type'=>$cust_type,'model' => $model, 'form' => $form]),
            ],
            [
                'label' => 'Kontak',
                'content' => $this->render('longcif_form_tab3', ['cust_type'=>$cust_type,'model' => $model, 'form' => $form]),

            ],
            [
                'label' => 'Pekerjaan',
                'content' => $this->render('longcif_form_tab4', ['cust_type'=>$cust_type,'model' => $model, 'form' => $form]),

            ],
            [
                'label' => 'Data Keuangan',
                'content' => $this->render('longcif_form_tab5', ['cust_type'=>$cust_type,'model' => $model, 'form' => $form]),

            ],
            [
                'label' => 'Data Rekening',
                'content' => $this->render('longcif_form_tab6', ['cust_type'=>$cust_type,'model' => $model, 'form' => $form]),

            ],
            [
                'label' => 'Informasi Lainnya',
                'content' => $this->render('longcif_form_tab7', ['cust_type'=>$cust_type,'model' => $model, 'form' => $form]),

            ],
            [
                'label' => 'Audit',
                'content' => $this->render('longcif_form_tab8', ['cust_type'=>$cust_type,'model' => $model, 'form' => $form]),

            ],
        ]]);
        ?>
        <?php }?>
        
        <!--customer type = Badan Usaha/Lembaga-->
        <?php if ($cust_type == 'Badan Usaha/Lembaga'){$model= app\models\LongcifBadan::find()->where(['id'=>$model2->id])->one()?>
        <?= Tabs::widget([
        'items' => [
            [
                'label' => 'Data Badan Usaha/Lembaga',
                'content' => $this->render('longcif_form_tab1', ['model'=>$model,'cust_type'=>$cust_type,'model2'=>$model2, 'form' => $form]),
                //'active' => true itu maksudnya tab mana yang dibuka pertama kali ngeLoad
                'active' => true
            ],
            [
                'label' => 'Alamat Lengkap',
                'content' => $this->render('longcif_form_tab2', ['model'=>$model,'cust_type'=>$cust_type,'model2'=>$model2, 'form' => $form]),
            ],
            [
                'label' => 'Data Keuangan',
                'content' => $this->render('longcif_form_tab3', ['cust_type'=>$cust_type,'model2'=>$model2, 'form' => $form]),
            ],
            [
                'label' => 'Susunan Pengurus',
                'content' => $this->render('longcif_form_tab9', ['cust_type'=>$cust_type,'model2'=>$model2, 'models3'=>$models3, 'form' => $form]),
            ],
            [
                'label' => 'Pejabat Yang Dapat Dihubungi',
                'content' => $this->render('longcif_form_tab5', ['cust_type'=>$cust_type,'model2'=>$model2,'form' => $form]),
                
            ],
            [
                'label' => 'Informasi Lain',
                'content' => $this->render('longcif_form_tab7', ['cust_type'=>$cust_type,'model2'=>$model2,'form' => $form]),

            ],            
            [
                'label' => 'Audit',
                'content' => $this->render('longcif_form_tab8', ['cust_type'=>$cust_type,'model2'=>$model2,'form' => $form]),
            ],
        ]]);
        ?>
        <?php }?>

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
        
        //Fungsi untuk melakukan pengecekan kartu identitas KTP
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