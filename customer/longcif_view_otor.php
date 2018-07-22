<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//var_dump($updatelog);die();
$this->title = 'Otorisasi Perubahan Data LongCIF - ' . $updatelog->cif_no;
$session = Yii::$app->session;
?>
<div class="custtomer-update-view-otor">
    <h3><?= Html::encode($this->title); ?></h3>
    <?php echo $session->getFlash('otoUpdateCIFFailed');?>
    <?php echo $session->getFlash('otoUpdateCIFSuccess');?>
    <?php echo $session->getFlash('hapusUpdateCIFFailed');?>
    <?php echo $this->render('longcif_data_diff', ['detailupdate' => $updatelog->detail, 'inputter'=>$updatelog->inputter, 'authorizer'=>$updatelog->authorizer]); ?>

    <?php
    if ($updatelog->status == app\models\LongcifUpdatelog::INAU) {
        $form = ActiveForm::begin([]);
        echo $form->field($updatelog, 'id')->hiddenInput(['maxlength' => 16])->label(false);
        echo '<div class="form-group">';
        echo Html::submitButton('Otorisasi', ['class' => 'btn btn-primary pull-right']);
        echo Html::a('Hapus', ['/customer/hapusupdateciflong','id'=>$updatelog->id], ['class'=>'btn btn-danger','style'=>'margin-left:10px','onclick'=>'return confirm("Hapus data ini ?")']);
        echo '</div>';
        ActiveForm::end();
    }
    ?>
    <div>&nbsp;</div>
    <div>&nbsp;</div>
</div>






