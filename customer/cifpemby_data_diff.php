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
use app\models\Agama;
use app\models\JobTittle;
use app\models\RelationCustomer;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$field = new app\models\Longcif;
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
        
//        if($key == 'birth_incorp_date'){
//            return date('d-m-Y',strtotime($value));
//        }
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
        
        if($key == "religion"){
            return (Agama::findOne($value) !== null) ? Agama::findOne($value)->agama_name:"-";
        }
        
        if($key == "job_title"){
            return (JobTittle::findOne($value) !== null) ? JobTittle::findOne($value)->job_tittle_name:"-";
        }
        
        if($key == "contact_rel_cus"){
            return (RelationCustomer::findOne($value) !== null) ? RelationCustomer::findOne($value)->descr:"-";
        }
        
        if($key == "education"){
            return (\app\models\Education::findOne($value) !== null) ? \app\models\Education::findOne($value)->descr:"-";
        }
        
        if($key == "account_officer"){
            return (\app\models\AccountOfficer::findOne($value) !== null) ? \app\models\AccountOfficer::findOne($value)->name:"-";
        }
        
        if($key == "sector"){
            return (\app\models\Sector::findOne($value) !== null) ? \app\models\Sector::findOne($value)->descr:"-";
        }
        
        if($key == "industry"){
            return (\app\models\Industri::findOne($value) !== null) ? \app\models\Industri::findOne($value)->industry_name:"-";
        }
        
        if($key == "target"){
            return (\app\models\Target::findOne($value) !== null) ? \app\models\Target::findOne($value)->target_name:"-";
        }
        
        if($key == "sid_relati_bank"){
            return (\app\models\SIDRelatiBank::findOne($value) !== null) ? \app\models\SIDRelatiBank::findOne($value)->descr:"-";
        }
        
        if($key == "cust_stat_lbus"){
            return (\app\models\CustStatLbus::findOne($value) !== null) ? \app\models\CustStatLbus::findOne($value)->descr:"-";
        }
        
        if($key == "xbrl_lbus"){
            return (\app\models\XbrlLbus::findOne($value) !== null) ? \app\models\XbrlLbus::findOne($value)->descr:"-";
        }
        
        if($key == "employment_status"){
            return (\app\models\EmploymentStatus::findOne($value) !== null) ? \app\models\EmploymentStatus::findOne($value)->descr:"-";
        }
        
        if($key == "sid_eco_sector"){
            return (\app\models\EcoSector::findOne($value) !== null) ? \app\models\EcoSector::findOne($value)->sid_eco_sector_name:"-";
        }
        return $value;
    } 
?>
