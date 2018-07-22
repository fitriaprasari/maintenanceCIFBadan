<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \app\models\Customer;
use app\models\Longcif;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = "Perubahan Data CIF Pembiayaan";
$session = Yii::$app->session;
?>
<div class="customer-view-search">
    <h1><?= Html::encode($this->title) ?></h1>

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
                    'action' => ['updatecifpembysearch'],
                    'method' => 'post',
        ]);
        ?>

        <?= $form->field($model, 'id', ['inputOptions' => ['placeholder' => 'Nomor CIF']])->textInput() ?>
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>
    
    <?php
        echo $session->getFlash('msgnotfound');
        echo $session->getFlash('msgfound');
        echo $session->getFlash('msgupdating');
        if ($session->getFlash('ciffound')==="OK"){
            echo $this->render('viewcifpemby', ['model' => $model]);
        }   
    ?>


</div>

