<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
use yii\bootstrap\Tabs;

$this->title = 'Maintenance CIF Badan';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h1><?= Html::encode($this->title." ".$id) ?></h1>

<div class="maintain-form">
        <?php
        $form = ActiveForm::begin([
                    'layout' => 'horizontal',
                    'id' => 'maintain-form',
                    'fieldConfig' => [
                        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                        'horizontalCssClasses' => [
                            'label' => 'col-sm-2',
                            //'offset' => 'col-sm-offset-2',
                            'wrapper' => 'col-sm-8',
                            'error' => '',
                            'hint' => '',
                        //'input' => 'input sm'
                        ],
                    ],
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    
        ]);
        ?>

<?=
Tabs::widget([
    'items' => [
        [
            'label' => 'Data Badan Usaha/Lembaga',
            'content' => $this->render('longcifbadan_view1', ['id'=>$id,'newData'=>$newData]),
            //'active' => true itu maksudnya tab mana yang dibuka pertama kali ngeLoad
            'active' => true
        ],
        [
            'label' => 'Alamat Lengkap',
            'content' => $this->render('longcifbadan_view2',  ['id'=>$id,'newData'=>$newData]),
        ],
        [
            'label' => 'Data Keuangan',
            'content' => $this->render('longcifbadan_view3', ['id'=>$id,'newData'=>$newData]),
        ],
        [
            'label' => 'Susunan Pengurus',
            'content' => $this->render('longcifbadan_view9', ['id'=>$id,'newDataSP'=>$newDataSP]),
        ],
        [
            'label' => 'Pejabat Yang Dapat Dihubungi',
            'content' => $this->render('longcifbadan_view5', ['id'=>$id,'newData'=>$newData]),
        ],
        [
            'label' => 'Informasi Lain',
            'content' => $this->render('longcifbadan_view7',['id'=>$id,'newData'=>$newData]),
        ],
        [
            'label' => 'Audit',
            'content' => $this->render('longcifbadan_view8',['id'=>$id,'newData'=>$newData]),
        ],
]]);
?>
<?php ActiveForm::end(); ?>
</div>