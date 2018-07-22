<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model app\models\Customer */
?>

<div class="customer-view">
    <!--data keuangan-->
    <?= DetailView::widget([
        'model' => $newData,
        'attributes' => [
        'ni_ac_o_purpose',
        'oth_acc_open_pr',
        'profit',
        'income',
        'monthly_txn_amt',
        'txn_freq_mon',
        'ni_source_fund',
        'oth_fund_source'
        ]
    ]) ?>
    
</div>
