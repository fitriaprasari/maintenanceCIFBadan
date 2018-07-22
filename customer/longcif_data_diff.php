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
                    echo "<td>" . isFieldSP($field->getAttributeLabel($key))."</td>";
                    echo "<td>" . getValue($key, $value['old']) . "</td>";
                    echo "<td>" . getValue($key, $value['new']) . "</td>";
                    echo "</tr>";
                } else {
                    echo "<tr>";
                    echo "<td>" . isFieldSP($field->getAttributeLabel($key)) . "</td>";
                    echo "<td>" . getValue($key, $value['old']) . "</td>";
                    echo "<td>" . getValue($key, $value['new']) . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
    
    <table class="table table-bordered">
        <tr>
            <td>
                Inputter
            </td>
            <td>
                <?php echo \app\models\User::findOne($inputter)->user_name; ?>
            </td>
        </tr>
        <tr>
            <td>
                Authoriser
            </td>
            <td>
                <?php if ($authorizer!== null){
                    
                    echo \app\models\User::findOne($authorizer)->user_name; 
                }
                ?>
            </td>
        </tr>
    </table>
</div>

    <?php
    
    //fitriana.dewi
    //fungsi untuk susunan pengurus
    function isFieldSP($key)
    {
        $num = intval(preg_replace('/[^0-9]+/', '', $key), 10);
        switch ($key)
        {
            case (strpos($key, 'Bd Cif')):
                return "CIF Badan Usaha." . $num;
                break;
            case (strpos($key, 'Bd Name')):
                return "Nama Pengurus." . $num;
                break;
            case (strpos($key, 'Bd Position')):
                return "Jabatan." . $num;
                break;
            case (strpos($key, 'Bd Gender')):
                return "Jenis Kelamin." . $num;
                break;
            case (strpos($key, 'Bd Birth Date')):
                return "Tgl Lahir." . $num;
                break;
            case (strpos($key, 'Bd Place Birth')):
                return "Tempat Lahir." . $num;
                break;
            case (strpos($key, 'Bd Leg Type')):
                return "Jenis Kartu ID." . $num;
                break;
            case (strpos($key, 'Bd Legal Id')):
                return "No. Kartu ID." . $num;
                break;
            case (strpos($key, 'Bd Exp Date')):
                return "Tgl. Kadaluarsa ID." . $num;
                break;
            case (strpos($key, 'Bd Tax No')):
                return "No. NPWP." . $num;
                break;
            case (strpos($key, 'Bd Address')):
                return "Alamat Tinggal." . $num;
                break;
            case (strpos($key, 'Bd Province')):
                return "Provinsi." . $num;
                break;
            case (strpos($key, 'Bd District Cd')):
                return "Kota/Kab." . $num;
                break;
            case (strpos($key, 'Bd Country')):
                return "Kecamatan." . $num;
                break;
            case (strpos($key, 'Bd Town Country')):
                return "Kelurahan." . $num;
                break;
            case (strpos($key, 'Bd Mobile Ph')):
                return "No.Hp." . $num;
                break;
            case (strpos($key, 'Bd Email Id')):
                return "Email." . $num;
                break;
            case (strpos($key, 'Bd Share Prcnt')):
                return "Presentase Kepemilikan." . $num;
                break;
            case (strpos($key, 'Bd Flag')):
                return "Pengurus (Y/N?)." . $num;
                break;

            case (strpos($key, 'Ni Source Fund')):
                return "Sumber Dana";
                break;
            case (strpos($key, 'Oth Fund Source')):
                return "Lainnya";
                break;
            case (strpos($key, 'Oper Type Lbus')):
                return "Jenis Operasional";
                break;
            case (strpos($key, 'Cu Rating Inst')):
                return "Lembaga Pemeringkat";
                break;
            case (strpos($key, 'Term Rate')):
                return "Term Peringkat";
                break;
            case (strpos($key, 'Cu Rating')):
                return "Nilai Peringkat";
                break;
            case (strpos($key, 'Cu Rate Date')):
                return "Tgl. Pemeringkat";
                break;
            case (strpos($key, 'Type Of Inst')):
                return "Jenis Badan Usaha/Lembaga";
                break;
            case (strpos($key, 'Ni Ac O Purpose')):
                return "Tujuan Pembukaan Rekening";
                break;
            case (strpos($key, 'Oth Acc Open Pr')):
                return "Tujuan Pembukaan Lainnya";
                break;
            case (strpos($key, 'Contact Worktel')):
                return "No. Telp. Kantor";
                break;
            case (strpos($key, 'Contact Pos')):
                return "Jabatan Pjb. yang dapat dihub.";
                break;
            case (strpos($key, 'Legal Doc Name')):
                return "Jenis Akta/Dok. Legal";
                break;
            case (strpos($key, 'Oth Bsnss Type')):
                return "Bentuk Badan Usaha Lainnya";
                break;
            case (strpos($key, 'Business Type')):
                return "Bentuk Badan Usaha / Lembaga";
                break;
            case (strpos($key, 'Profit')):
                return "Laba Per Bulan";
                break;
            case (strpos($key,'Legal Id')):
                return "No. Pengesahan/No. Legalitas";
            break;
            case (strpos($key,'Legal Exp Date')):
                return "Tg.Kadaluarsa ID";
            break;
       
                
            default :
                return $key;
                break;
        }
    }

function getValue($key, $value)
    {

//        if($key == 'birth_incorp_date'){
//            return date('d-m-Y',strtotime($value));
//        }
        if ($key == 'nationality')
        {
            return (Nationality::findOne($value) !== null) ? Nationality::findOne($value)->nationality_name : "-";
        }

        if ($key == 'province')
        {
            return (Province::findOne($value) !== null) ? Province::findOne($value)->prov_name : "-";
        }

        if ($key == "district_code")
        {
            return (KabupatenKota::findOne($value) !== null) ? KabupatenKota::findOne($value)->kab_name : "-";
        }

        if ($key == "employment_kyc")
        {
            return (Employmentkyc::findOne($value) !== null) ? Employmentkyc::findOne($value)->descr : "-";
        }

        if ($key == "ac_of_fund")
        {
            return (Acoffund::findOne($value) !== null) ? Acoffund::findOne($value)->descr : "-";
        }

        if ($key == "ac_open_purpose")
        {
            return (Acopenpurpose::findOne($value) !== null) ? Acopenpurpose::findOne($value)->descr : "-";
        }

        if ($key == "income")
        {
            return (Income::findOne($value) !== null) ? Income::findOne($value)->descr : "-";
        }

        if ($key == "monthly_txn_amt")
        {
            return (MonthlyTxnAmt::findOne($value) !== null) ? MonthlyTxnAmt::findOne($value)->descr : "-";
        }

        if ($key == "txn_freq_mon")
        {
            return (TxnFreqMonth::findOne($value) !== null) ? TxnFreqMonth::findOne($value)->descr : "-";
        }

        if ($key == "religion")
        {
            return (Agama::findOne($value) !== null) ? Agama::findOne($value)->agama_name : "-";
        }

        if ($key == "job_title")
        {
            return (JobTittle::findOne($value) !== null) ? JobTittle::findOne($value)->job_tittle_name : "-";
        }

        if ($key == "contact_rel_cus")
        {
            return (RelationCustomer::findOne($value) !== null) ? RelationCustomer::findOne($value)->descr : "-";
        }

        if ($key == "education")
        {
            return (\app\models\Education::findOne($value) !== null) ? \app\models\Education::findOne($value)->descr : "-";
        }

        if ($key == "account_officer")
        {
            return (\app\models\AccountOfficer::findOne($value) !== null) ? \app\models\AccountOfficer::findOne($value)->name : "-";
        }

        if ($key == "sector")
        {
            return (\app\models\Sector::findOne($value) !== null) ? \app\models\Sector::findOne($value)->descr : "-";
        }

        if ($key == "industry")
        {
            return (\app\models\Industri::findOne($value) !== null) ? \app\models\Industri::findOne($value)->industry_name : "-";
        }

        if ($key == "target")
        {
            return (\app\models\Target::findOne($value) !== null) ? \app\models\Target::findOne($value)->target_name : "-";
        }

        if ($key == "sid_relati_bank")
        {
            return (\app\models\SIDRelatiBank::findOne($value) !== null) ? \app\models\SIDRelatiBank::findOne($value)->descr : "-";
        }

        if ($key == "cust_stat_lbus")
        {
            return (\app\models\CustStatLbus::findOne($value) !== null) ? \app\models\CustStatLbus::findOne($value)->descr : "-";
        }

        if ($key == "xbrl_lbus")
        {
            return (\app\models\XbrlLbus::findOne($value) !== null) ? \app\models\XbrlLbus::findOne($value)->descr : "-";
        }

        return $value;
    }
?>