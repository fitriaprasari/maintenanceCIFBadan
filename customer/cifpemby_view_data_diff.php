<?php

use yii\helpers\Html;

echo Yii::$app->session->getFlash('saveUpdateOK');
$this->title = "Detail Perubahan CIF : ".$updatelog->cif_no;

?>
<h3><?= Html::encode($this->title);?></h3>
<?php echo $this->render('cifpemby_data_diff',['detailupdate'=>$updatelog->detail]);?>
