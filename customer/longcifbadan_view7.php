<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model app\models\Customer */
?>

<div class="customer-view">
    <!--informasi lain-->
    <?= DetailView::widget([
        'model' => $newData,
        'attributes' => [
        'industry',
        'target',
        'account_officer',
        'customer_liability',
        'cust_risk_prof',
        'sid_relati_bank',
        'xbrl_lbus',
        'taxable',
        'cust_stat_lbus',
        'oper_type_lbus',
        'cu_rating_inst',
        'term_rate',
        'cu_rating',
        'cu_rate_date'
    ]]) ?>
    
</div>
