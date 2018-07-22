<?php

use yii\helpers\Html;
use app\models\LongcifBadan;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
if ($cust_type == "Badan Usaha/Lembaga")
{
    $this->title = 'Update Customer: ' . ' ' . $model2->id;
}
else
{
    $this->title = 'Update Customer: ' . ' ' . $model->id;
}

$this->registerCss(".required label:after { content:' *';color:red; }");
?>
<div class="customer-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
        if (is_array($message)) {
            foreach ($message as $item) {
                echo '<div class="alert alert-' . $key . '">' . $item . '</div>';
            }
        } else
            echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
    }
//    ?>
    <?php echo Yii::$app->session->getFlash('saveUpdateFailed'); ?>
    <?php if ($cust_type == "Badan Usaha/Lembaga")
    {
        ?>
        <?php echo Yii::$app->session->getFlash('errorValidation');?>
        <?= $this->render('longcif_form', ['cust_type'=>$cust_type,'model2' => $model2, 'models3' => $models3]) ?>
    <?php
    }
    else
    {
        ?>
    <?= $this->render('longcif_form', ['cust_type'=>$cust_type,'model' => $model]) ?>
<?php } ?>


</div>
