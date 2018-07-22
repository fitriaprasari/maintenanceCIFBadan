<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\KabupatenKota;
use app\modules\maintaincif\models\LongcifBadan;
use \wbraganca\dynamicform\DynamicFormWidget;
//use \kartik\date\DatePicker;
//use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */


$js = '';

if(!empty($oldIDs)){
    $js .= '    
    $(document).ready(function() {';
    $ix = 0;
    foreach ($oldIDs as $olsID){
        $js .= '$(".i-'.$ix.' .remove-item").hide();
            $(".i-'.$ix.' .form-control").prop("readonly", true);
            $(".i-'.$ix.' .form-control :not(:selected)").attr("disabled","disabled");';
        $ix++;
    }
    $js .= '});';
}

$js .= '

jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Susunan Pengurus " + (index + 1))
    });
    
    $( ".datepicker" ).each(function() {
      $( this ).datepicker($.extend({}, $.datepicker.regional[\'id\'], {"changeMonth":true,"yearRange":"1990:2099","changeYear":true,"dateFormat":"dd-mm-yy"}));
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Susunan Pengurus " + (index + 1))
    });
});

';

$this->registerJs($js);

?>

<div class="maintain-form">
    <div>&nbsp;</div>
    <div>&nbsp;</div>
    
    <?php
    DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
//        'limit' => 4, // the maximum times, an element can be cloned (default 999)
        'limit'=>15,
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $models3[0],
        'formId' => 'maintain-form',
        'formFields' => [
            'bd_name',
            'bd_position',
            'bd_gender',
            'bd_birth_date',
            'bd_place_birth',
            'bd_leg_type'
        ],
    ]);
    ?>

    <div class="panel panel-default">
        <div class="panel-heading">Susunan Pengurus CIF Badan
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Tambah Cif</button>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items">
            <?php foreach ($models3 as $index => $model3): ?>
                <div class="item panel panel-default"> 
                    <div class="panel-heading">
                        <span class="panel-title-address">Susunan Pengurus <?= ($index + 1) ?></span>
                        <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        if (!$model3->isNewRecord)
                        {
                            echo Html::activeHiddenInput($model3, "[{$index}]bd_cif");
                        }
                        ?>

                            <?= $form->field($model3, "[{$index}]bd_name")->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
                        
                            <?=
                            $form->field($model3, "[{$index}]bd_position")->dropDownList(['00-PENGURUS-PEMILIK' => 'PENGURUS - PEMILIK',
                                '01-PEMILIK-Direktur Utama/Pres.Dir' => 'PEMILIK - Direktur Utama/Pres.Dir',
                                '02-PEMILIK-Direktur' => 'PEMILIK - Direktur',
                                '03-PEMILIK-Komisaris Utama / Pres.Kom' => 'PEMILIK - Komisaris Utama / Pres.Kom',
                                '04-PEMILIK-Komisaris' => 'PEMILIK - Komisaris',
                                '06-PEMILIK-Kuasa Direksi' => 'PEMILIK - Kuasa Direksi',
                                '07-PEMILIK-Pemilik Bukan Pengurus' => 'PEMILIK - Pemilik Bukan Pengurus',
                                '09-PEMILIK-Masyarakat' => 'PEMILIK - Masyarakat',
                                '10-PEMILIK-Ketua Umum' => 'PEMILIK - Ketua Umum',
                                '11-PEMILIK-Ketua' => 'PEMILIK - Ketua',
                                '12-PEMILIK-Sekretaris' => 'PEMILIK - Sekretaris',
                                '13-PEMILIK-Bendahara' => 'PEMILIK - Bendahara',
                                '19-PEMILIK-Lainnya' => 'PEMILIK - Lainnya',
                                //bukan pemilik
                                '51-BUKAN PEMILIK-Direktur Utama/Pres.Dir' => 'BUKAN PEMILIK-Direktur Utama/Pres.Dir',
                                '52-BUKAN PEMILIK-Direktur' => 'BUKAN PEMILIK-Direktur',
                                '53-BUKAN PEMILIK-Komisaris Utama / Pres.Kom' => 'BUKAN PEMILIK-Komisaris Utama / Pres.Kom',
                                '54-BUKAN PEMILIK-Komisaris' => 'BUKAN PEMILIK-Komisaris',
                                '55-BUKAN PEMILIK-Kuasa Direksi' => 'BUKAN PEMILIK-Kuasa Direksi',
                                '57-BUKAN PEMILIK-Ketua Umum' => 'BUKAN PEMILIK-Ketua Umum',
                                '58-BUKAN PEMILIK-Ketua' => 'BUKAN PEMILIK-Ketua',
                                '59-BUKAN PEMILIK-Sekretaris' => 'BUKAN PEMILIK-Sekretaris',
                                '60-BUKAN PEMILIK-Bendahara' => 'BUKAN PEMILIK-Bendahara',
                                '69-BUKAN PEMILIK-Lainnya' => 'BUKAN PEMILIK-Lainnya'], ['' => 'Pilih Jabatan','style' => 'text-transform: uppercase'])
                            ?>

                            <?=
                            $form->field($model3, "[{$index}]bd_gender")->dropDownList(['FEMALE' => 'FEMALE',
                                'MALE' => 'MALE'], ['' => 'Pilih Jenis Kelamin','style' => 'text-transform: uppercase'])
                            ?>
                        
                            <?= $form->field($model3, "[{$index}]bd_birth_date")->widget(
                                    \yii\jui\DatePicker::classname(), [
                                'language' => 'id',
                                'dateFormat' => 'dd-MM-yyyy',
                                'options'=>['readonly'=>true,'class'=>'form-control datepicker', 'style'=>'width:260px', 'id'=>'dp1'.$index],
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'yearRange' => '1925:2049',               
                                    'changeYear' => true,  

                                    //'showOn' => 'button',
                                    //'buttonImage' => '../../images/calendaricon.gif',
                                ],
                                    ], ['class' => 'datepicker'])
                            ?>
                        
                            <?= $form->field($model3, "[{$index}]bd_place_birth")->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>

                            <?=
                            $form->field($model3, "[{$index}]bd_leg_type")->dropDownList(['01-KTP' => 'KTP',
                                '02-SIM' => 'SIM',
                                '03-Passport/KITAS/KIMIS' => 'Passport/KITAS/KIMIS'], ['' => 'Pilih Jenis Kartu Identitas','style' => 'text-transform: uppercase'])
                            ?>

                            <?= $form->field($model3, "[{$index}]bd_legal_id")->textInput(['readonly' => false,'maxlength'=>true,'style' => 'text-transform: uppercase']) ?>
                            
                            <?= $form->field($model3, "[{$index}]bd_exp_date")->widget(
                                    \yii\jui\DatePicker::classname(), [
                                'language' => 'id',
                                'dateFormat' => 'dd-MM-yyyy',
                                'options'=>['readonly'=>true,'class'=>'form-control datepicker', 'style'=>'width:260px', 'id'=>'dp'.$index],
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'yearRange' => '1925:2049',               
                                    'changeYear' => true,  

                                    //'showOn' => 'button',
                                    //'buttonImage' => '../../images/calendaricon.gif',
                                ],
                                    ], ['class' => 'datepicker'])
                            ?>
                           
                            <?= $form->field($model3, "[{$index}]bd_tax_no")->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
                            <?= $form->field($model3, "[{$index}]bd_address")->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
          
                            <?=
                            $form->field($model3, "[{$index}]bd_province")->dropDownList(\app\models\Province::listProvince(), [
                                '' => '----Pilih Propinsi----',
                                'onchange' => 'var names = this.getAttribute("name");'
                                 . 'var numberPattern = /\d+/g;'
                                 . 'var x = names.match( numberPattern );'                                
                                . '$.post( "' . Url::toRoute("customer/getkabkot") . '", { id_prov: $(this).val() } ).done(function(data){ '                                     
                                 . '$("#longcifbadansusunanpengurus-" + x + "-bd_district_cd").html( data );'
                                . '});',
                                    ]
                                    
                            );
                            ?>
                        
                            <?=
                            $form->field($model3, "[{$index}]bd_district_cd")->dropDownList(
//                                 KabupatenKota::listKabKot($model2->province), 
                                ['' => '----Pilih Kabupaten Kota----']);
                            ?>
                        
                            <?= $form->field($model3, "[{$index}]bd_country")->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
                            <?= $form->field($model3, "[{$index}]bd_town_country")->textInput(['maxlength' => true,'style' => 'text-transform: uppercase']) ?>
                            <?= $form->field($model3, "[{$index}]bd_mobile_ph")->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase']) ?>
                            <?= $form->field($model3, "[{$index}]bd_email_id")->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model3, "[{$index}]bd_share_prcnt")->textInput(['maxlength' => true]) ?>
                        <?=
                            $form->field($model3, "[{$index}]bd_flag")->dropDownList(['Y' => 'Y',
                                'N' => 'N'], ['' => '-Pilih-','style' => 'text-transform: uppercase'])
                            ?>
                    </div>
                </div>
<?php endforeach; ?>
        </div>
    </div>

    <?php DynamicFormWidget::end(); ?>
    </div>

