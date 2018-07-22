<?php

//============Library/Kelas===============
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

//========================================
//Set Judul halaman
$this->title = "Cetak Ulang Data Statis";

//========================================
//set variable lain - lain hehe...
$session = Yii::$app->session;
?>

<div class="reprint-form-search">
    <h1><?= Html::encode($this->title); ?></h1>

    <div class="form-group">
        <?php
        $form = ActiveForm::begin([
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                        'horizontalCssClasses' => [
                            'label' => 'col-sm-2',
                            'offset' => 'col-sm-offset-2',
                            'wrapper' => 'col-sm-4',
                            'error' => '',
                            'hint' => '',
                            'input' => 'input-sm'
                        ],
                    ],
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'action' => ['reprintsmartcif'],
                    'method' => 'post'
        ]);
        ?>
        <?= $form->field($model, 'cif_no', ['inputOptions' => []]) ?>
        <?= $form->field($model, 'reprint_reason', ['inputOptions' => []]) ?>
        <?= Html::submitButton('Request Cetak Ulang', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<div>
    <?= $session->getFlash('msgnotfound') ?>
    <?= $session->getFlash('msgfound') ?>
</div>
<hr>
<?php
if ($session->getFlash('datacif') === 'found') {
    echo $this->render('smartcif_reprint_prev', ['model' => $datacif]);
}
?>


