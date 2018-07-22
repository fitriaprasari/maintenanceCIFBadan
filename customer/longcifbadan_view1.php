<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model app\models\Customer */
?>

<div class="customer-view">
    
    <?= DetailView::widget([
        'model' => $newData,
        'attributes' =>
        
        ['business_type',
        'oth_bsnss_type',
        'short_name',
        'name_1',
        'type_of_inst',
        'legal_id',
        'legal_doc_name',
        'legal_id_no',
        'birth_incorp_date',
        'tax_reg_no',
        'zakat_reg_no',
        'nationality',
        'reside_y_n',
        'domicile_1',
        'introducer',
        'sid_eco_sector',
        'sector',
        'company_book',
        'contact_date',
        'mud_printed_nam']

    ]) ?>
    
</div>
