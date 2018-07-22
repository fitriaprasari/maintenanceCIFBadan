<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="customer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Customer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'legal_type',
            'legal_id_no',
            'short_name',
            'place_birth',
            // 'birth_incorp_date',
            // 'gender',
            // 'mother_maiden',
            // 'marital_status',
            // 'nationality',
            // 'reside_y_n',
            // 'street',
            // 'address',
            // 'rt_rw',
            // 'town_country',
            // 'country',
            // 'province',
            // 'district_code',
            // 'post_code',
            // 'addr_phone_area',
            // 'addr_phone_no',
            // 'sms_1',
            // 'email_1:email',
            // 'employment_kyc',
            // 'ac_of_fund',
            // 'ac_open_purpose',
            // 'income',
            // 'monthly_txn_amt',
            // 'txn_freq_mon',
            // 'cust_risk_prof',
            // 'inputter',
            // 'authoriser',
            // 'account_officer',
            // 'co_code',
            // 'created_date_t24',
            // 'created_date_syiarex',
            // 'last_updated_date',
            // 'state',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
