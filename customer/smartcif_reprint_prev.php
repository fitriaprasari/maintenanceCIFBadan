<html>
    <head>
        <style>
            @page{
                size:auto;
                margin:20mm 0mm 0mm 0mm;
            }
            .cif
            {
                font-family: "Courier new";
                line-height: 1;
                *line-height:1em;
                font-size: 10pt;
                margin-left: 50px;
                margin-top:50px;
                margin-bottom: 50px;
                border-collapse: collapse;
                border:0px solid black;
            }

            .field
            {
                width:350px
            }

            #borderbottom{
                border-bottom:thin dashed;
            }
        </style>
        <!--[if IE]>
                <style>
                        .report
                        {
                        font-family: "Courier new";
                        line-height:1;
                        font-size:8pt;
                        }</style>
        <![endif]-->
    </head>
    <body>
        <?php

        use yii\helpers\Html;
        use yii\helpers\Url;
        
        $urlByCif = Url::to(['customer/printsmartcif', 'cifno' => $model->id]);
        echo Html::a('REPRINT', $urlByCif, ['class' => 'btn btn-primary pull-right', 'target' => '_blank']);
        
        ?>
        <table class='cif'>
            <tr id='borderbottom'>
                <td class="field">KANCA BRI SYARIAH</td>
                <td>:</td>
                <td><?php echo $model->company_book ?></td>
            </tr>
            <tr>
                <td class="field">Nomor CIF</td>
                <td>:</td>
                <td><?php echo $model->id ?></td>
            </tr>
            <tr>
                <td class="field">Nama Sesuai Identitas</td>
                <td>:</td>
                <td><?php echo $model->short_name ?></td>
            </tr>
            <tr>
                <td class="field">Tempat Lahir</td>
                <td>:</td>
                <td><?php echo $model->place_birth; ?></td>
            </tr>
            <tr>
                <td class="field">Tanggal Lahir</td>
                <td>:</td>
                <td><?php echo date("d M Y", strtotime($model->birth_incorp_date)) ?></td>
            </tr>
            <tr>
                <td class="field">Jenis Kelamin</td>
                <td>:</td>
                <td><?php echo $model->gender ?></td>
            </tr>
            <tr>
                <td class="field">Agama</td>
                <td>:</td>
                <td><?php echo $model->religion ?></td>
            </tr>
            <tr>
                <td class="field">Status Perkawinan</td>
                <td>:</td>
                <td><?php echo $model->marital_status ?></td>
            </tr>
            <tr>
                <td class="field">Nama Gadis Ibu Kandung</td>
                <td>:</td>
                <td><?php echo $model->moth_maiden ?></td>
            </tr>
            <tr>
                <td class="field">Jenis Identitas</td>
                <td>:</td>
                <td><?php echo $model->legal_type ?></td>
            </tr>
            <tr>
                <td class="field">Nomor Identitas</td>
                <td>:</td>
                <td><?php echo $model->legal_id_no ?></td>
            </tr>
            <tr>
                <td class="field">Alamat Sesuai Identitas</td>
                <td>:</td>
                <td colspan="2"><?php echo $model->street . ", " . $model->address ?></td>
            </tr>
            <tr>
                <td class="field">RT/RW</td>
                <td>:</td>
                <td><?php echo $model->rt_rw ?></td>
            </tr>
            <tr>
                <td class="field">Desa/Kelurahan</td>
                <td>:</td>
                <td><?php echo $model->town_country ?></td>
            </tr>
            <tr>
                <td class="field">Kecamatan</td>
                <td>:</td>
                <td><?php echo $model->country ?></td>
            </tr>
            <tr>
                <td class="field">Kabupaten/Kota</td>
                <td>:</td>
                <td><?php echo $model->district_code ?></td>
            </tr>
            <tr>
                <td class="field">Kode pos</td>
                <td>:</td>
                <td><?php echo $model->post_code ?></td>
            </tr>
            <tr>
                <td class="field">Provinsi</td>
                <td>:</td>
                <td><?php echo $model->province ?></td>
            </tr>
            <tr>
                <td class="field">Jenis Pekerjaan</td>
                <td>:</td>
                <td><?php echo $model->employment_kyc ?></td>
            </tr>
            <tr>
                <td class="field">Sumber Dana</td>
                <td>:</td>
                <td><?php echo $model->ac_of_fund ?></td>
            </tr>
            <tr>
                <td class="field">Tujuan Pembukaan Rek.</td>
                <td>:</td>
                <td><?php echo $model->ac_open_purpose ?></td>
            </tr>
            <tr>
                <td class="field">Penghasilan per bulan</td>
                <td>:</td>
                <td><?php echo $model->income ?></td>
            </tr>
            <tr>
                <td class="field">Nilai Transaksi Normal</td>
                <td>:</td>
                <td><?php echo $model->monthly_txn_amt ?></td>
            </tr>
            <tr>
                <td class="field">Max Frekuensi Transaksi Per Hari</td>
                <td>:</td>
                <td><?php echo $model->txn_freq_mon ?></td>
            </tr>
            <tr>
                <td class="field">Warganegara</td>
                <td>:</td>
                <td><?php echo $model->nationality ?></td>
            </tr>
            <tr>
                <td class="field">Kependudukan</td>
                <td>:</td>
                <td><?php echo $model->reside_y_n ?></td>
            </tr>
            <tr>
                <td class="field">No telepon rumah</td>
                <td>:</td>
                <td><?php echo $model->addr_phone_area . " - " . $model->addr_phone_no ?></td>
            </tr>
            <tr>
                <td class="field">Telp selular</td>
                <td>:</td>
                <td><?php echo $model->sms_1 ?></td>
            </tr>
            <tr>
                <td class="field">Email</td>
                <td>:</td>
                <td><?php echo $model->email_1 ?></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>&nbsp;</td></tr>

            <tr>
                <td class="field">
                    Mengetahui,<br>Petugas Bank
                    <br /><br /><br /><br /><br /><br /><br />
                    (<?php echo app\models\User::findOne($model->local_inputter)->user_name ?>)
                </td>
                <td></td>
                <td class="field">
                    <?php
                    $branch_nm = $model->company_book;
                    $branch = explode(" ", $branch_nm);
                    echo $branch[1]. ", " . date('d M Y') . "<br>Nasabah,";
                    ?>
                    <?php //echo "JAKARTA" . ", " . date('d M Y', strtotime($model->local_created_date)) . "<br>Nasabah,";  ?>
                    <br /><br /><br /><br /><br /><br /><br />
                    (<?php echo $model->short_name; ?>)
                </td>
            </tr>
        </table>
    </body>
</html>