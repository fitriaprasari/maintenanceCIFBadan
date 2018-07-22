<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model app\models\Customer */
?>

<div class="customer-view">
    
    <!--susunan pengurus-->
    <?php 
    $index = 0;
    foreach($newDataSP as $data){
        $index = $index+1;
        echo '<br>';
        echo 'PENGURUS '.$index;
        echo '<br>';?>
        <?= DetailView::widget([
        'model' => $data,
        'attributes' =>
        [
            ['label'=>'Nama Pengurus'.$index,
             'value'=>$data->bd_name],
            'bd_position',
            'bd_gender',
            'bd_leg_type',
            'bd_legal_id',
            'bd_exp_date',
            'bd_tax_no',
            'bd_address',
            'bd_district_cd',
            'bd_country',
            'bd_town_country',
            'bd_mobile_ph',
            'bd_email_id',
            'bd_share_prcnt',
            'bd_birth_date', 
            'bd_place_birth'
        ]]) ?>
        
    <?php } ?>
    
    
</div>
