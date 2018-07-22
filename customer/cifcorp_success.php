<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'Pembukaan CIF Badan - ' . $model->id;
$session = Yii::$app->session;
?>
<div class="custtomer-update-view-otor">
    <h3><?= Html::encode($this->title); ?></h3>
    <?php echo $session->getFlash('createCIFFailed');?>
    <?php echo $session->getFlash('createCIFSuccess');?>
    <?php echo $session->getFlash('hapusCIFFailed');?>
</div>






