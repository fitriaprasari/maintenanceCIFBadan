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

    <?= $form->field($model, 'sector')->dropDownList(app\models\Sector::getSector(), ['prompt' => '---Kelompok Nasabah---']) ?> 
    <?= $form->field($model, 'industry')->dropDownList(app\models\Industri::getIndustry(), ['prompt' => '---Sektor Ekonomi---']) ?> 
    <?= $form->field($model, 'target')->dropDownList(app\models\Target::getTarget(), ['prompt' => '---Segmentasi---']) ?> 
    <?= $form->field($model, 'sid_relati_bank')->dropDownList(app\models\SIDRelatiBank::getSID(), ['prompt' => '---Hub. Dengan Bank---']) ?> 
    <?= $form->field($model, 'taxable')->inline()->radioList(['Y' => "Y", "N" => "N"]) ?>
    <?= $form->field($model, 'cust_risk_prof')->dropDownList(app\models\Customer::getCustomerRiskProfile(), ['prompt' => '---Customer Risk Profile---']) ?>
    <?= $form->field($model, 'cust_stat_lbus')->dropDownList(app\models\Longcif::getCustLbus(), ['prompt' => '---Customer Risk Profile---']) ?> 
    <?= $form->field($model, 'xbrl_lbus')->dropDownList(app\models\XbrlLbus::getXbrlLbus(), ['prompt' => '---Customer Risk Profile---']) ?>
 

</div>

