<?php

use \app\models\Nationality;
use \app\models\Province;
use app\models\KabupatenKota;
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
        
        
        
        return $value;
    } 
?>
