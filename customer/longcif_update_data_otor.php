<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = "Data Otorisasi Perubahan Data CIF";
$session = Yii::$app->session;
?>
<div class="customer-data-otor">

    <div>&nbsp;</div>
    <h1><?= Html::encode($this->title) ?></h1>
    <div>&nbsp;</div>
    <?php echo $session->getFlash('otoUpdateCIFSuccess');?>
    <?php echo Yii::$app->session->getFlash('hapusUpdateCIFSuccess');?>
    <?php echo Yii::$app->session->getFlash('hapusUpdateCIFFailed');?>
    <div class="form-group">
        <?php
        $form = ActiveForm::begin([
                    'layout' => 'inline',
                    'fieldConfig' => [
                        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                        'horizontalCssClasses' => [
                            'label' => 'col-sm-2',
                            'offset' => 'col-sm-offset-4',
                            'wrapper' => 'col-sm-8',
                            'error' => '',
                            'hint' => '',
                            'input' => 'input sm'
                        ],
                    ],
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'action' => ['displaylongcifotorupdate'],
                    'method' => 'get',
        ]);
        ?>
        
        <?= $form->field($searchModel, 'cif_no',['inputOptions' => ['placeholder'=>'No CIF']]) ?>
        <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'cif_no',
            'created_date',
            'status',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{detail}',
                'buttons'=>[
                  'detail'=>function($url,$model){
                    $url = Url::to(['customer/otorupdatelongcif','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-cog"></span>',$url);
                  }  
                ],
            ],
        ],
    ]);
    ?>
</div>
