<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

//use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>
<?php if ($cust_type == "Perorangan")
{ ?>
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

        <?= $form->field($model, 'sector')->dropDownList(app\models\Sector::getSector(), ['' => '---Kelompok Nasabah---']) ?> 
        <?= $form->field($model, 'industry')->dropDownList(app\models\Industri::getIndustry(), ['' => '---Sektor Ekonomi---']) ?> 
        <?= $form->field($model, 'target')->dropDownList(app\models\Target::getTarget(), ['' => '---Segmentasi---']) ?> 
        <?= $form->field($model, 'sid_relati_bank')->dropDownList(app\models\SIDRelatiBank::getSID(), ['' => '---Hub. Dengan Bank---']) ?> 
        <?= $form->field($model, 'taxable')->inline()->radioList(['Y' => "Y", "N" => "N"]) ?>
        <?= $form->field($model, 'cust_risk_prof')->dropDownList(app\models\Customer::getCustomerRiskProfile(), ['' => '---Customer Risk Profile---']) ?>
        <?= $form->field($model, 'cust_stat_lbus')->dropDownList(app\models\Longcif::getCustLbus(), ['' => '---Customer Risk Profile---']) ?> 
        <?= $form->field($model, 'xbrl_lbus')->dropDownList(['9000' => '9000|Perseorangan', '9700' => '9700|Bukan Penduduk - Perseorangan'], ['' => '---Pilih Golongan Nasabah---']) ?>


    </div>    
    <?php }
    else { ?>
    <div>&nbsp;</div>
    <div>&nbsp;</div>

    <!--Informasi Lainya untuk CIF Badan-->
    <?= $form->field($model2, 'industry')->dropDownList(app\models\Industri::getIndustry(), ['' => '-Pilih Industri-','style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'target')->dropDownList(app\models\Target::getTarget(), ['' => '-Pilih Segmentasi-','style' => 'text-transform: uppercase']) ?>
    <?=
    $form->field($model2, 'account_officer', [
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
        . '     if(obj.status == "NA") $( "#' . Html::getInputId($model2, 'account_officer') . '" ).val(""); '
        . '     $("#ao_desc").html(obj.desc);'
        . '     $("#ao-desc-loader").hide();'
        . '   });'
        . '  '
        . '}'
    ]);
    ?>
    <?php // $form->field($model2, 'customer_liability') ?>
    <?= $form->field($model2, 'cust_risk_prof')->dropDownList(['Medium' => 'Medium', 'High' => 'High', 'Low' => 'Low'], ['' => '-Pilih-','style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'sid_relati_bank')->dropDownList(app\models\SIDRelatiBank::getSID(), ['' => '-Pilih-','style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'xbrl_lbus')->dropDownList(app\models\XbrlLbus::getXbrlLbus(), ['' => '-Pilih-','style' => 'text-transform: uppercase']) ?>
    <?= $form->field($model2, 'taxable')->inline()->radioList(['Y' => "Y", "N" => "N"]) ?>
    <?=
    $form->field($model2, 'cust_stat_lbus')->dropDownList(['1-Perusahaan Induk' => 'Perusahaan Induk',
        '2-Perusahaan Anak' => 'Perusahaan Anak',
        '3-Perusahaan Asosiasi' => 'Perusahaan Asosiasi',
        '9-Lainnya' => 'Lainnya'], ['' => '-Pilih-','style' => 'text-transform: uppercase'])
    ?>

    <?= $form->field($model2, 'oper_type_lbus')->dropDownList(['1-Syariah' => 'Syariah', '2-Konvensional' => 'Konvensional'],['style' => 'text-transform: uppercase']) ?>

    <div>&nbsp;</div>
    <div>&nbsp;</div>
    ================ Data Rating ==================
    <div>&nbsp;</div>
    <div>&nbsp;</div>

    <?=
    $form->field($model2, 'cu_rating_inst')->dropDownList([
        "00-Tidak Ada" => "Tidak Ada",
        "10-Moody's Investor" => "Moody's Investor",
        "11-Standard and Poor's" => "Standard and Poor's",
        "12-Fitch Rating International" => "Fitch Rating International",
        "13-Pefindo" => "Pefindo",
        "14-ICRA Indonesia" => "ICRA Indonesia",
        "15-Fitch Indonesia" => "Fitch Indonesia"],
        [''=>'-Pilih-'],
        ['style' => 'text-transform: uppercase'],
        ['onchange'=>''
            . 'if(this.value == "00-Tidak Ada"){'
            . 'alert("hai");'
            . '$("#'.Html::getInputId($model2, 'term_rate').'").prop("readonly",true);'
            . '}'
        ]);
    ?>
    
    <?= $form->field($model2, 'term_rate')->dropDownList(["00-Tidak Ada" => "Tidak Ada",
                                                          "1-Long Term Rating" => "Long Term Rating",
                                                          "2-Short Term Rating" => "Short Term Rating"],
                                                         [""=>"-Pilih-"],
                                                         ['style' => 'text-transform: uppercase'])
    ?>

    <?= $form->field($model2, 'cu_rating')->dropDownList(["00-Tidak Ada" => "Tidak Ada",
                                                          "1-Long Term Rating" => "Long Term Rating",
                                                          "2-Short Term Rating" => "Short Term Rating"],
                                                         [""=>"-Pilih-"],
                                                         ['style' => 'text-transform: uppercase'])
    ?>
    
    <?=
    $form->field($model2, 'cu_rate_date')->textInput(['class' => 'datepicker'])->widget(
            \yii\jui\DatePicker::classname(), ['language' => 'id',
        'dateFormat' => 'yyyy-MM-dd',
        'clientOptions' => [
            'changeMonth' => true,
            'yearRange' => '2010:2049',
            'changeYear' => true,
            'showOn' => 'button',
            'buttonImage' => 'images/calendar.gif',
        ],
            ], ['class' => 'datepicker'])
    ?> 
<?php } ?>