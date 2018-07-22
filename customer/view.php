<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use \app\models\KabupatenKota;
use \app\models\Nationality;
use \app\models\Province;


/* @var $this yii\web\View */
/* @var $model app\models\Customer */


?>
<div class="customer-view">
    
    <div class="tombol pull-right">
        <?= Html::a('Update', ['updatesmartcif', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </div>
    
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'legal_type',
                    'legal_id_no',
                    'short_name',
                    'place_birth',
                    [
                        'label'=>$model->getAttributeLabel('birth_incorp_date'),
                        'value'=>date('d-m-Y',strtotime($model->birth_incorp_date)),
                    ],
                    'gender',
                    'moth_maiden',
                    'marital_status',
                    'nationality',
                    'reside_y_n',
                    'street',
                    'address',
                    'rt_rw',
                    'town_country',
                    'country',
                    'province',
                    'district_code',
                    'post_code',
                    'addr_phone_area',
                    'addr_phone_no',
                    'sms_1',
                    'email_1:email',
                    'employment_kyc',
                    'ac_of_fund',
                    'ac_open_purpose',
                    'ac_open_purpose',
                    'income',
                    'monthly_txn_amt',
                    'txn_freq_mon'
        //            'cust_risk_prof',
        //            'inputter',
        //            'account_officer',
        //            'co_code',
        //            'created_date_t24',
        //            'created_date_syiarex',
        //            'state',
                ],
            ]) ?>
   
    </div>
