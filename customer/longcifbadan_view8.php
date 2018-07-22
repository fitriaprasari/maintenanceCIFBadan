<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model app\models\Customer */
?>

<div class="customer-view">
    <!--auditrail-->
    <?= DetailView::widget([
        'model' => $newData,
        'attributes' =>
        [
            'opening_company',
            'curr_no',
            'inputter',
            'co_code',
            'dept_code',
            'local_inputter'
        ]

    ]) ?>
    
</div>
