<?php

use \app\models\Nationality;
use \app\models\Province;
use app\models\KabupatenKota;
use app\models\Employmentkyc;
use \app\models\Acoffund;
use app\models\Acopenpurpose;
use app\models\Income;
use \app\models\MonthlyTxnAmt;
use app\models\TxnFreqMonth;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$field = new app\models\Customer;
?>
<div class="data-diff">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Field</th>
                <th>Data Lama</th>
                <th>Data Baru</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($detailupdate as $key => $value) {                
                if ($value['new'] != $value['old']) {
                    echo "<tr bgcolor='#369dff'>";
                    echo "<td>" . $field->getAttributeLabel($key)."</td>";
                    echo "<td>" . getValue($key, $value['old']) . "</td>";
                    echo "<td>" . getValue($key, $value['new']) . "</td>";
                    echo "</tr>";
                } else {
                    echo "<tr>";
                    echo "<td>" . $field->getAttributeLabel($key) . "</td>";
                    echo "<td>" . getValue($key, $value['old']) . "</td>";
                    echo "<td>" . getValue($key, $value['new']) . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>
<?php
    function getValue($key,$value){
        
        if($key == 'birth_incorp_date'){
            return date('d-m-Y',strtotime($value));
        }
        if($key == 'nationality'){
            return (Nationality::findOne($value) !== null) ? Nationality::findOne($value)->nationality_name:"-";
        }
        
        if($key == 'province'){
            return (Province::findOne($value) !== null) ? Province::findOne($value)->prov_name:"-";
        }
        
        if($key == "district_code"){
            return (KabupatenKota::findOne($value) !== null) ? KabupatenKota::findOne($value)->kab_name:"-";
        }
        
        if($key == "employment_kyc"){
            return (Employmentkyc::findOne($value) !== null) ? Employmentkyc::findOne($value)->descr:"-";
        }
        
        if($key == "ac_of_fund"){
            return (Acoffund::findOne($value) !== null) ? Acoffund::findOne($value)->descr:"-";
        }
        
        if($key == "ac_open_purpose"){
            return (Acopenpurpose::findOne($value) !== null) ? Acopenpurpose::findOne($value)->descr:"-";
        }
        
        if($key == "income"){
            return (Income::findOne($value) !== null) ? Income::findOne($value)->descr : "-";
        }
        
        if($key == "monthly_txn_amt"){
            return (MonthlyTxnAmt::findOne($value) !== null) ? MonthlyTxnAmt::findOne($value)->descr:"-";
        }
        
        if($key == "txn_freq_mon"){
            return (TxnFreqMonth::findOne($value) !== null) ? TxnFreqMonth::findOne($value)->descr:"-";
        }
        
        return $value;
    } 
?>
