<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model app\models\Customer */
?>

<div class="customer-view">
    <!--pejabat yang dapat dihubungi-->
    <?= DetailView::widget([
        'model' => $newData,
        'attributes' =>
        [
        'contact_nam',
        'contact_pos',
        'contact_worktel',
        'contact_homtel',
        'contact_mobtel'
        ]
    ]) ?>
    
</div>
