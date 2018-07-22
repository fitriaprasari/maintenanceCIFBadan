<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = 'Update Customer: ' . ' ' . $model->id;
$this->registerCss(".required label:after { content:' *';color:red; }");
?>
<div class="customer-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo Yii::$app->session->getFlash('saveUpdateFailed');?>
    <?= $this->render('smartcif_form', ['model' => $model]) ?>

</div>
