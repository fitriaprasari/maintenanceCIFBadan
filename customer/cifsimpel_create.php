<?php

use yii\helpers\Html;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = 'Pembukaan CIF Simpel (Simpanan Pelajar)';
//$this->registerCss(".required label:after { content:' *';color:red; }");
?>
<div class="customer-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo Yii::$app->session->getFlash('createCIFFailed');?>
    <div>&nbsp;</div>
    
    <?= $this->render('cifsimpel_forms', [
        'model' => $model,
    ]) ?>
</div>
