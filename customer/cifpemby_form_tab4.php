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
    <?=
    $form->field($model, 'account_officer', [
        'inputTemplate' => '
            <div class="">{input}</div>',
        'template' => '{label}'
        . '<div class="row">'
        . '<div class="col-sm-2">{input}{error}{hint}</div>'
        . '<span style="margin-top:8px; display:block;" id="ao_desc"></span>'
        . '</div>']
    )->textInput(['maxlength' => true, 'readonly' => true, 'onblur' => ''
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

    <?= $form->field($model, 'sector')->dropDownList(app\models\Sector::getSector(), ['prompt' => '---Kelompok Nasabah---']) ?> 
    <?= $form->field($model, 'industry')->dropDownList(app\models\Industri::getIndustry(), ['prompt' => '---Sektor Ekonomi---']) ?> 
    <?= $form->field($model, 'target')->dropDownList(app\models\Target::getTarget(), ['prompt' => '---Segmentasi---']) ?> 
    <?= $form->field($model, 'orgmas')->textInput(['maxlength' => true,'readonly' => true]) ?>
    <?= $form->field($model, 'taxable')->textInput(['maxlength' => true ,'readonly' => true]) ?>
    <?= $form->field($model, 'cust_risk_prof')->dropDownList(app\models\Customer::getCustomerRiskProfile(), ['prompt' => '---Customer Risk Profile---']) ?>
     ============== Informasi Terkait Bank Indonesia ==============
    <?= $form->field($model, 'din_number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'bmpk_violation')->inline()->radioList(['Y' => "Y", "N" => "N"]) ?>
    <?= $form->field($model, 'bmpk_exceeding')->inline()->radioList(['Y' => "Y", "N" => "N"]) ?>
    <?= $form->field($model, 'sid_relati_bank')->dropDownList(app\models\SIDRelatiBank::getSID(), ['prompt' => '---Hub. Dengan Bank---']) ?> 
    <?= $form->field($model, 'xbrl_lbus')->dropDownList(['9000' => '9000|Perseorangan', '9700' => '9700|Bukan Penduduk - Perseorangan'], ['prompt' => '---Pilih Golongan Nasabah---']) ?>
    <?= $form->field($model, 'cust_stat_lbus')->dropDownList(app\models\Longcif::getCustLbus(), ['prompt' => '---Customer Risk Profile---']) ?> 
     ================= Kategori Usaha Nasabah ==================
    <?= $form->field($model, 'income_type')->dropDownList(['Fixed Income' => 'Fixed Income', 'Non Fixed Income' => 'Non Fixed Income'], ['prompt' => 'Pilih Jenis Penghasilan']) ?> 
    <?= $form->field($model, 'net_asset')->textInput(['maxlength' => true]) ?> 
    <?= $form->field($model, 'annual_sale')->textInput(['maxlength' => true]) ?>
</div>

