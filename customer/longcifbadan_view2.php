<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model app\models\Customer */
?>

<div class="customer-view">
    
    <!--alamat lengkap-->
    <?= DetailView::widget([
        'model' => $newData,
        'attributes' => [
        'street',
        'address',
        'rt_rw',
        'province',
        'district_code',
        'country',
        'town_country',
        'post_code',
        'residence',
        'addr_phone_area',
        'contact_fax_no',
        'email_1',

//        'same_as_resadd',
        'po_box_no',
        'po_rt_rw',
        'po_province',
        'po_dist_code',
        'po_city_municip',
        'po_suburb_town',
        'po_post_code',
        'domicile_2',

            ]]) ?>
    
</div>
