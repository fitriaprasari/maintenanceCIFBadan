<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \app\models\KabupatenKota;
use \app\models\Nationality;
use \app\models\Province;


?>
<div class="customer-view">
    
    <?php if($model->cust_type == "Badan Usaha/Lembaga"){ ?>
        <div class="tombol pull-right">
        <?= Html::a('Lengkapi/Ubah', ['updatelongcifbadan', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </div>
    <?php } else { ?>
    <div class="tombol pull-right">
        <?= Html::a('Lengkapi/Ubah', ['updatelongcif', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </div>
    <?php } ?>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label'=>$model->getAttributeLabel('id'),
                'value'=>$model->id,
            ],
            [
                'label'=>$model->getAttributeLabel('short_name'),
                'value'=>$model->short_name,
            ],
            [
                'label'=>$model->getAttributeLabel('street'),
                'value'=>$model->street,
            ],
            [
                'label'=>$model->getAttributeLabel('district_code'),
                'value'=>$model->kab_kot,
            ],
            [
                'label'=>$model->getAttributeLabel('cust_type'),
                'value'=>$model->cust_type,
            ],
            [
                'label'=>$model->getAttributeLabel('company_book'),
                'value'=>$model->opening_comp,
            ],
            [
                'label'=>$model->getAttributeLabel('status'),
                'value'=>$model->status,
            ],

        ],
    ]) ?>

</div>
