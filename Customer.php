<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
use \yii\helpers\ArrayHelper;

/**
 * This is the model class for table "syiarex_customer".
 *
 * @property string $cif_no
 * @property string $legal_type
 * @property string $legal_id_no
 * @property string $short_name
 * @property string $place_birth
 * @property string $birth_incorp_date
 * @property string $gender
 * @property string $moth_maiden
 * @property string $marital_status
 * @property string $nationality
 * @property string $reside_y_n
 * @property string $street
 * @property string $address
 * @property string $rt_rw
 * @property string $town_country
 * @property string $country
 * @property string $province
 * @property string $district_code
 * @property string $post_code
 * @property string $addr_phone_area
 * @property string $addr_phone_no
 * @property string $sms_1
 * @property string $email_1
 * @property string $employment_kyc
 * @property string $ac_of_fund
 * @property string $ac_open_purpose
 * @property string $income
 * @property string $monthly_txn_amt
 * @property string $txn_freq_mon
 * @property string $cust_risk_prof
 * @property string $inputter
 * @property string $account_officer
 * @property string $co_code
 * @property string $created_date
 * @property string $state
 * @property string $religion
 */
class Customer extends ActiveRecord {

    const STATE_ACTIVE = "ACTIVE";
    const STATE_UPDATING_NAU = "UPDATING_NAU";
    
    const ORIGIN_SYIAREX = "SYIAREX";
    const ORIGIN_T24 = "T24";
    
    const CUST_TYPE_INDIVIDU = "INDIVIDU";
    const CUST_TYPE_BADAN = "BADAN";
    
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'syiarex_customer';
    }

    //Relasi dengan tabel customer_update_log (CustomerUpdateLog.php)
    public function getUpdatelog() {
        return $this->hasMany(CustomerUpdatelog::className(), ['cif_no' => 'id']);
    }
    
    //Relasi dengan tabel account (Account.php)
    public function getAccount(){
        return $this->hasMany(Account::className(), ['cif_no' => 'id']);
    }
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            //Rule Untuk Create
            [[
            'legal_type',
            'legal_id_no',
            'short_name',
            'place_birth',
            'birth_incorp_date',
            'gender',
            'moth_maiden',
            'marital_status',
            'nationality',
            'reside_y_n',
            'street',
            'rt_rw',
            'town_country',
            'country',
            'province',
            'district_code',
            'post_code',
            'employment_kyc',
            'ac_of_fund',
            'ac_open_purpose',
            'income',
            'monthly_txn_amt',
            'txn_freq_mon',
            
            ],'required','on' => 'create_update'],
            [['address'],'safe','on'=>'create_update'],
            [['id', 'legal_id_no'], 'string', 'max' => 16, 'on' => 'create_update'],
            //[['birth_incorp_date'], 'date', 'format' => 'dd-MM-yyyy', 'on' => 'create_update', 'message'=>'Format tanggal harus dd-MM-yyyy'],
            
            //Rule default
            [[
            'legal_type',
            'legal_id_no',
            'short_name',
            'place_birth',
            'birth_incorp_date',
            'gender',
            'moth_maiden',
            'marital_status',
            'nationality',
            'reside_y_n',
            'street',
            'address',
            'rt_rw',
            'town_country',
            'country',
            'province',
            'district_code',
            'post_code',
            'addr_phone_area',
            'addr_phone_no',
            'sms_1',
            'email_1',
            'cust_risk_prof',
            'religion',
                ], 'safe'],
            
            //Rule untuk tampil data
            [['id'], 'required', 'on' => 'tampil'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'Nomor CIF',
            'legal_type' => 'Jenis Kartu Identitas',
            'legal_id_no' => 'No Kartu Identitas',
            'short_name' => 'Nama Sesuai Identitas',
            'place_birth' => 'Tempat Lahir',
            'birth_incorp_date' => 'Tangal Lahir',
            'gender' => 'Jenis Kelamin',
            'moth_maiden' => 'Nama Gadis Ibu Kandung',
            'marital_status' => 'Status Perkawinan',
            'nationality' => 'Warganegara',
            'reside_y_n' => 'Kependuduk',
            'street' => 'Alamat Sesuai Identitas',
            'address' => 'Address',
            'rt_rw' => 'RT/RW',
            'town_country' => 'Desa/Kelurahan',
            'country' => 'Kecamatan',
            'province' => 'Propinsi',
            'district_code' => 'Kabupaten/Kota',
            'post_code' => 'Kode Pos',
            'addr_phone_area' => 'Kode Area Telepon',
            'addr_phone_no' => 'No Telepon',
            'sms_1' => 'No HP',
            'email_1' => 'Email',
            'employment_kyc' => 'Pekerjaan',
            'ac_of_fund' => 'Sumber Dana',
            'ac_open_purpose' => 'Tujuan Pembukaan',
            'income' => 'Pendapatan Per Bulan',
            'monthly_txn_amt' => 'Nilai Transaksi Normal',
            'txn_freq_mon' => 'Frekuensi Transaksi Maksimal',
            'cust_risk_prof' => 'Cust Risk Prof',
            'local_inputter' => 'Inputter',
            'account_officer' => 'Account Officer',
            'company_code' => 'Co Code',
            'local_created_date' => 'Created Date',
            'local_state' => 'State',
            'cust_type' => 'Jenis Nasabah',
            'religion' => 'Agama',
        ];
    }

    public function bukaCIFT24() {
        
        //Encoding Message to JSON Format
        $msgreq = json_encode(
                [
                    "userid" => Yii::$app->user->identity->t24_login_name,
                    "password" => Yii::$app->user->identity->gett24pass(),
                    "cocode" => Yii::$app->user->identity->branch_cd,
                    
                    "legalType" => $this->legal_type,
                    "legalIdNo" => $this->legal_id_no,
                    "shortName" => $this->short_name,
                    "placeBirth" => $this->place_birth,
                    "birthIncorpDate" => date('Ymd',strtotime($this->birth_incorp_date)),
                    "gender" => $this->gender,
                    "mothMaiden" => $this->moth_maiden,
                    "maritalStatus" => $this->marital_status,
                    "nationality" => $this->nationality,
                    "reside" => $this->reside_y_n,
                    "street" => $this->street,
                    "address" => $this->address,
                    "rtrw" => $this->rt_rw,
                    "townCountry" => $this->town_country,
                    "country" => $this->country,
                    "province" => $this->province,
                    "districtCode" => $this->district_code,
                    "postCode" => $this->post_code,
                    "addrPhoneArea" => $this->addr_phone_area,
                    "addrPhoneNo" => $this->addr_phone_no,
                    "sms" => $this->sms_1,
                    "email" => str_replace("_", "'_'",$this->email_1),
                    "employmentKyc" => $this->employment_kyc,
                    "acOfFund" => $this->ac_of_fund,
                    "acOpenPurpose" => $this->ac_open_purpose,
                    "income" => $this->income,
                    "monthlyTxnAmt" => $this->monthly_txn_amt,
                    "txnFreqMon" => $this->txn_freq_mon,
                    "custRiskProf" => $this->cust_risk_prof,
                    "accountOfficer" => $this->account_officer,
                    "sameAsResadd" => $this->same_as_resadd,
                    "taxable" => $this->taxable,
                    "sector" => $this->sector,
                    "industry" => $this->industry,
                    "target" => $this->target,
                    "religion" => $this->religion,
                ]
        );
        $msgresp = null;
        $status = null;
        $statusMsg = null;
        $cifno = null;

        //Request Pembukaan CIF ke T24
        try {
            $syiarexClient = new \SoapClient(YII::$app->params['wsdlt24']);
            $request = $syiarexClient->bukaCIF(['params' => $msgreq]);

            $msgresp = $request->return;
            $response = json_decode($msgresp);

            $statusMsg = $response->statusMsg;

            //Jika Request Berhasil Maka Insert Data CIF ke tabel syiarex_customer
            if ($response->status == "00") {
                $cifno = $response->params->cifno;
                $this->email_1 = str_replace("'_'", "_", $this->email_1);
                $this->id = $cifno;
                $this->birth_incorp_date = date("Y-m-d", strtotime($this->birth_incorp_date));

                try {
                    
                    $this->save();
                    $status = WsclientLog::STATOK;
                } catch (\Exception $ex) {
                    
                    $statusMsg = "Koneksi DB gagal : " . $ex->getMessage();
                    $status = WsclientLog::STATERR;
                }
            }
        } catch (\Exception $ex) {
            $status = WsclientLog::STATERR;
            $statusMsg = "Koneksi Webservice gagal : " . $ex->getMessage();
        }

        //Simpan log
        $log = new WsclientLog();
        $log->func = "bukaCIF";
        $log->request = $msgreq;
        $log->response = $msgresp;
        $log->status = $status;
        $log->error_msg = ($status == WsclientLog::STATOK) ? "":$statusMsg;
        $log->inputter = Yii::$app->user->identity->id;
        $log->hidepassword($msgreq);
        $log->save();

        return ["cifno" => $cifno, 'status' => $status, 'msg' => $statusMsg];
    }

    public static function bacaSmartCIFT24($cifno) {

        $msgreq = json_encode(
            [
                "userid" => Yii::$app->user->identity->t24_login_name,
                "password" => Yii::$app->user->identity->gett24pass(),
                "cocode" => Yii::$app->user->identity->branch_cd,
                "cifno" => $cifno
            ]
        );
        $msgresp = NULL;
        $status = NULL;
        $statusMsg = NULL;

        //Request Baca CIF ke T24
        try {
            $syiarexClient = new \SoapClient(YII::$app->params['wsdlt24']);
            $request = $syiarexClient->bacaCIF(['params' => $msgreq]);

            $msgresp = $request->return;
            $response = json_decode($msgresp);

            $statusMsg = $response->statusMsg;

            //Jika Request Berhasil Maka Insert Data CIF ke tabel syiarex_customer
            if ($response->status == "00") {
                try {
                    
                    Customer::updateOnTheFly($cifno, $response);
                    $statusMsg = "Data CIF Ditemukan";
                    $status = WsclientLog::STATOK;
                } catch (\Exception $ex) {
                    
                    $statusMsg = "Koneksi DB gagal : " . $ex->getMessage();
                    $status = WsclientLog::STATERR;
                }
            }
        } catch (\Exception $ex) {
            $status = WsclientLog::STATERR;
            $statusMsg = "Koneksi Webservice gagal : " . $ex->getMessage();
        }

        //Simpan log
        $log = new WsclientLog();
        $log->func = "bacaCIF";
        $log->request = $msgreq;
        $log->response = $msgresp;
        $log->status = $status;
        $log->error_msg = ($status == WsclientLog::STATOK) ? "":$statusMsg;
        $log->inputter = Yii::$app->user->identity->id;
        $log->hidepassword($msgreq);
        $log->save();

        return ["cifno" => $cifno, 'status' => $status, 'msg' => $statusMsg];
    }
    
    public static function getAccountbyCift24($cifno){
        
        $msgreq = json_encode(
                [
                    "userid" => Yii::$app->user->identity->t24_login_name,
                    "password" => Yii::$app->user->identity->gett24pass(),
                    "cocode" => Yii::$app->user->identity->branch_cd,
                    "cifno" => $cifno
                ]
        );
        
        $msgresp = NULL;
        $status = NULL;
        $statusMsg = NULL;
        $daftarRek = [];
        
        //Request No Rekening berdasarkan CIF ke T24
        try {
            $syiarexClient = new \SoapClient(YII::$app->params['wsdlt24']);
            $request = $syiarexClient->enqAccountByCIF(['params' => $msgreq]);

            $msgresp = $request->return;
            $response = json_decode($msgresp,true);
            
            $status = WsclientLog::STATOK;
            $statusMsg = $response['statusMsg'];
            
            $daftarRek = $response['params']['accountbycifinfo']['contents'];
            
        } catch (\Exception $ex) {
            $status = WsclientLog::STATERR;
            $statusMsg = "Koneksi Webservice gagal : " . $ex->getMessage();
        }

        //Simpan log
        $log = new WsclientLog();
        $log->func = "enqAccountByCIF";
        $log->request = $msgreq;
        $log->response = $msgresp;
        $log->status = $status;
        $log->error_msg = ($status == WsclientLog::STATOK) ? "":$statusMsg;
        $log->inputter = Yii::$app->user->identity->id;
        $log->hidepassword($msgreq);
        $log->save();

        return ["daftarRek" => $daftarRek, 'status' => $status, 'msg' => $statusMsg];
        
    }

    public static function updateOnTheFly($cifno, $response) {

        $model = null;

        if (Customer::findOne($cifno) === null) {
            $model = new Customer();
            $model->id = $cifno;
            $model->local_origin = Customer::ORIGIN_T24;
            $model->local_state = Customer::STATE_ACTIVE;
            $model->local_created_date = date("Y-m-d");
            //$model->local_customer_type = Customer::CUST_TYPE_INDIVIDU;
        } else {
            $model = Customer::findOne($cifno);
        }

        $model->legal_type = $response->params->cifinfo->contents->c0;
        $model->legal_id_no = $response->params->cifinfo->contents->c1;
        $model->short_name = $response->params->cifinfo->contents->c2;
        $model->place_birth = $response->params->cifinfo->contents->c3;
        $model->birth_incorp_date = $response->params->cifinfo->contents->c4;
        $model->gender = $response->params->cifinfo->contents->c5;
        $model->moth_maiden = $response->params->cifinfo->contents->c6;
        $model->marital_status = $response->params->cifinfo->contents->c7;
        $model->nationality = $response->params->cifinfo->contents->c8;
        $model->reside_y_n = $response->params->cifinfo->contents->c9;
        $model->street = $response->params->cifinfo->contents->c10;
        $model->address = $response->params->cifinfo->contents->c11;
        $model->rt_rw = $response->params->cifinfo->contents->c12;
        $model->town_country = $response->params->cifinfo->contents->c13;
        $model->country = $response->params->cifinfo->contents->c14;
        $model->province = $response->params->cifinfo->contents->c15;
        $model->district_code = $response->params->cifinfo->contents->c16;
        $model->post_code = $response->params->cifinfo->contents->c17;
        $model->addr_phone_area = $response->params->cifinfo->contents->c18;
        $model->addr_phone_no = $response->params->cifinfo->contents->c19;
        $model->sms_1 = $response->params->cifinfo->contents->c20;
        $model->email_1 = $response->params->cifinfo->contents->c21;
        $model->employment_kyc = $response->params->cifinfo->contents->c22;
        $model->ac_of_fund = $response->params->cifinfo->contents->c23;
        $model->ac_open_purpose = $response->params->cifinfo->contents->c24;
        $model->income = $response->params->cifinfo->contents->c25;
        $model->monthly_txn_amt = $response->params->cifinfo->contents->c26;
        $model->txn_freq_mon = $response->params->cifinfo->contents->c27;
        $model->cust_risk_prof = $response->params->cifinfo->contents->c28;
        $model->account_officer = $response->params->cifinfo->contents->c29;
        $model->company_book = $response->params->cifinfo->contents->c30;
        $model->cust_type = $response->params->cifinfo->contents->c31;
        $model->local_inputter = Yii::$app->user->identity->id;
        $model->save();
    }
    

    public static function inputUpdateCIFT24($cif_no, $detailUpdate) {

        $msgreq = json_encode(
                [
                    "userid" => Yii::$app->user->identity->t24_login_name,
                    "password" => Yii::$app->user->identity->gett24pass(),
                    "cocode" => Yii::$app->user->identity->branch_cd,
                    "cifno" => $cif_no,
                    "legalType" => $detailUpdate['legal_type']['new'],
                    "legalIdNo" => $detailUpdate['legal_id_no']['new'],
                    "shortName" => $detailUpdate['short_name']['new'],
                    "placeBirth" => $detailUpdate['place_birth']['new'],
                    "birthIncorpDate" => date('Ymd', strtotime($detailUpdate['birth_incorp_date']['new'])),
                    "gender" => $detailUpdate['gender']['new'],
                    "mothMaiden" => $detailUpdate['moth_maiden']['new'],
                    "maritalStatus" => $detailUpdate['marital_status']['new'],
                    "nationality" => $detailUpdate['nationality']['new'],
                    "reside" => $detailUpdate['reside_y_n']['new'],
                    "street" => $detailUpdate['street']['new'],
                    "address" => $detailUpdate['address']['new'],
                    "rtrw" => $detailUpdate['rt_rw']['new'],
                    "townCountry" => $detailUpdate['town_country']['new'],
                    "country" => $detailUpdate['country']['new'],
                    "province" => $detailUpdate['province']['new'],
                    "districtCode" => $detailUpdate['district_code']['new'],
                    "postCode" => $detailUpdate['post_code']['new'],
                    "addrPhoneArea" => $detailUpdate['addr_phone_area']['new'],
                    "addrPhoneNo" => $detailUpdate['addr_phone_no']['new'],
                    "sms" => $detailUpdate['sms_1']['new'],
                    "email" => str_replace("_", "'_'", $detailUpdate['email_1']['new']),
                    "employmentKyc" => $detailUpdate['employment_kyc']['new'],
                    "acOfFund" => $detailUpdate['ac_of_fund']['new'],
                    "acOpenPurpose" => $detailUpdate['ac_open_purpose']['new'],
                    "income" => $detailUpdate['income']['new'],
                    "monthlyTxnAmt" => $detailUpdate['monthly_txn_amt']['new'],
                    "txnFreqMon" => $detailUpdate['txn_freq_mon']['new'],
                    "custRiskProfile" => $detailUpdate['cust_risk_prof']['new'],
//                    "sameAsResadd" => $detailUpdate->same_as_resadd,
//                    "accountOfficer" => $detailUpdate->account_officer,
//                    "taxable" => $detailUpdate->taxable,
//                    "sector" => $detailUpdate->sector,
//                    "industry" => $detailUpdate->industry,
//                    "target" => $detailUpdate->target
                ]
        );
        $msgresp = NULL;
        $status = NULL;
        $statusMsg = NULL;
        $idLogUpdate = NULL;

        try {
            $syiarexClient = new \SoapClient(YII::$app->params['wsdlt24']);
            $request = $syiarexClient->updateCIF(['params' => $msgreq]);

            $msgresp = $request->return;
            $response = json_decode($msgresp);

            $statusMsg = $response->statusMsg;

            //Jika Berhasil maka simpan perubahan data
            if ($response->status == "00") {
                
                $simpanUpdate = Customer::syiarexSimpanUpdate($cif_no, $detailUpdate); //ini dia prosesnya
                $idLogUpdate = $simpanUpdate['idlogupdate'];
 
                $statusMsg = $simpanUpdate['msg'];
                $status = ($simpanUpdate['status'] == "OK") ? WsclientLog::STATOK : WsclientLog::STATERR;
                
            }else{
                $status = WsclientLog::STATERR;
            }
            
        } catch (Exception $ex) {
            $status = WsclientLog::STATERR;
            $statusMsg = "Koneksi Web Servis Gagal : " . $ex->getMessage();
        }
        
        //Simpan log
        $log = new WsclientLog();
        $log->func = "updateCIF";
        $log->request = $msgreq;
        $log->response = $msgresp;
        $log->status = $status;
        $log->error_msg = ($status == WsclientLog::STATOK) ? "":$statusMsg;
        $log->inputter = Yii::$app->user->identity->id;
        $log->hidepassword($msgreq);
        $log->save();

        return ['status' => $status, 'msg' => $statusMsg, 'idlogupdate' => $idLogUpdate];
    }

    public static function syiarexSimpanUpdate($cif_no, $detailUpdate) {

        $idLogUpdate = "";
        $status = "";

        $datacif = Customer::findOne($cif_no);
        
        $updatelog = new CustomerUpdatelog();
        $transaction = CustomerUpdatelog::getDb()->beginTransaction();

        try {
            //update data di syiarex_customer_update_log
            $updatelog->cif_no = $cif_no;
            $updatelog->inputter = Yii::$app->user->identity->t24_login_name;
            $updatelog->detail = json_encode($detailUpdate);
            $updatelog->created_date = date('Y-m-d');
            $updatelog->status = CustomerUpdatelog::INAU;
            $updatelog->co_code = Yii::$app->user->identity->branch_cd;
            $updatelog->save();
            
            //update informasi di tabel syiarex_customer bahwa customer ini sedang maintain
            $datacif->local_state = Customer::STATE_UPDATING_NAU;
            $datacif->save();
            $transaction->commit();

            $idLogUpdate = $updatelog->id;
            $status = "OK";
            $statusMsg = "Perubahan data CIF : " . $cif_no . " berhasil disimpan";
        } catch (\Exception $ex) {
            $transaction->rollBack();
            $status = "ERROR";
            $statusMsg = "Perubahan data CIF : " . $cif_no . " gagal disimpan : " . $ex->getMessage();
        }

        return ['status' => $status, 'msg' => $statusMsg, 'idlogupdate' => $idLogUpdate];
    }

    public function OtoUpdateCIFT24($idupdatelog) {
        
        $msgreq = json_encode(
            [
                'userid' => Yii::$app->user->identity->t24_login_name,
                'password' => Yii::$app->user->identity->gett24pass(),
                'cocode' => Yii::$app->user->identity->branch_cd,
                'cifno' => $this->id
            ]
        );
        
        $msgresp = NULL;
        $status = NULL;
        $statusMsg = NULL;

        try {
            $syiarexClient = new \SoapClient(YII::$app->params['wsdlt24']);
            $request = $syiarexClient->otoUpdateCIF(['params' => $msgreq]);

            $msgresp = $request->return;
            $response = json_decode($msgresp);
            
            $statusMsg = $response->statusMsg;

            if ($response->status == "00") {
                $otoUpdate = $this->syiarexOtoUpdateSmartcif($idupdatelog);
                $statusMsg = $otoUpdate['msg'];
                
                $status = ($otoUpdate['status'] == "OK") ? WsclientLog::STATOK : WsclientLog::STATERR;
            }else{
                $status = WsclientLog::STATERR;
            }
            
        } catch (Exception $ex) {
            $status = WsclientLog::STATOK;
            $statusMsg = "Koneksi Web Servis Gagal : ".$ex->getMessage();
            $log->error_msg = $statusMsg;
        }
        
        //Simpan log
        $log = new WsclientLog();
        $log->func = "otoUpdateCIF";
        $log->request = $msgreq;
        $log->response = $msgresp;
        $log->status = $status;
        $log->error_msg = ($status == WsclientLog::STATOK) ? "":$statusMsg;
        $log->inputter = Yii::$app->user->identity->id;
        $log->hidepassword($msgreq);
        $log->save();
        
        return ['status' => $status, 'msg' => $statusMsg];
    }

    public function syiarexOtoUpdateSmartcif($idupdatelog) {

        $status = "";
        $statusMsg = "";

        $updatelog = CustomerUpdatelog::findOne($idupdatelog);
        $transaction = CustomerUpdatelog::getDb()->beginTransaction();

        try {
            
            $updatelog->authorizer = Yii::$app->user->identity->id;
            $updatelog->auth_date = date('Y-m-d');
            $updatelog->auth_time = date('H:i:s');
            $updatelog->status = CustomerUpdatelog::LIVE;
            $updatelog->save();

            $this->local_state = Customer::STATE_ACTIVE;
            $this->save();
            $transaction->commit();

            $status = "OK";
            $statusMsg = "Otorisasi Perubahan data CIF : " . $updatelog->cif_no . " berhasil dilakukan";
            
        } catch (\Exception $ex) {
            
            $transaction->rollBack();
            $status = "ERROR";
            $statusMsg = "ERROR : " . $ex->getMessage();
        }

        return ['status' => $status, 'msg' => $statusMsg];
    }

    /* Fungsi Dibawah ini adalah fungsi bantuan saat proses Update Data
     * 
     */

    //Ini Fungsi untuk memetakan data apa saja yang diubah
    public static function filterUpdatableData($oldData, $newData) {

        $updatableOldData = [];

        foreach ($newData as $keyNew => $valueNew) {
            foreach ($oldData as $keyOld => $valueOld) {
                if ($keyNew == $keyOld) {
                    $array = [$keyOld => $valueOld];
                    $updatableOldData = array_merge($updatableOldData, $array);
                }
            }
        }

        return $updatableOldData;
    }

    public static function createUpdateDetail($oldData, $newData) {

        $updateinfo = [];

        foreach ($newData as $key => $value) {
            $array = [$key => ['new' => $value, 'old' => $oldData[$key]]];
            $updateinfo = array_merge($updateinfo, $array);
        }

        return $updateinfo;
    }

    public static function newData($updateDetail) {

        $newData = [];
        
        foreach ($updateDetail as $key => $value) {
            $array = [$key => $value['new']];
            $newData = array_merge($newData, $array);
        }
        
        return $newData;
    }
    
    public static function getCustomerRiskProfile(){
        
        $data = [
            ['key'=>'High', 'value'=>'High'],
            ['key'=>'Low', 'value'=>'Low'],
            ['key'=>'Medium', 'value'=>'Medium'],
        ];
        
        return ArrayHelper::map($data,'key','value');
    }
    
    public static function cekLegalId($legal_id_no){
        
        $rows = (new \yii\db\Query())
                ->select(['as_of_dt', 'cif_no', 'short_nm', 'legal_type', 'legal_id_no'])
                ->from('syiarex_lookup_customer')
                ->where(['legal_id_no' => $legal_id_no])
                ->one();
        
        if($rows == NULL){
            return json_encode([
                'status'=>'not found',
                'legal_id_no'=>$legal_id_no
            ]);
        }else{
            return json_encode([
                'status'=>'found',
                'as_of_dt'=>$rows['as_of_dt'],
                'cif_no'=>$rows['cif_no'],
                'short_nm'=>$rows['short_nm'],
                'legal_type'=>$rows['legal_type'],
                'legal_id_no'=>$rows['legal_id_no']
            ]);
        }
    }
    
    
    public static function getLokalT24($id){
        $data = [   'status'       =>  'NA',
                    'short_name'   =>  '',
                    'cust_type'    =>  '',
                ];
        
        $lc = LookupCustomer::findOne($id);
        if($lc != null) {
            $data = [   'status'       =>  'OK',
                        'short_name'   =>  $lc->short_nm,
                        'cust_type'    =>  $lc->cust_type,
                    ];
        }
        else {
            $cT24 = Customer::bacaSmartCIFT24($id);
            if($cT24['status'] == WsclientLog::STATOK){
                $c= Customer::findOne($id);
                if($c != null){
                    $data = [   'status'       =>  'OK',
                                'short_name'   =>  $c->short_name,
                                'cust_type'    =>  $c->cust_type,
                    ];
                }
            }           
        }
        return $data;
    }
    
    public static function getRiskProfile() {
        $data = [
                ['key' => 'Low', 'value' => 'Low'],
                ['key' => 'Medium', 'value' => 'Medium'],
                ['key' => 'High Risk PEPs', 'value' => 'High Risk PEPs'],
                ['key' => 'High Risk Non PEPs', 'value' => 'High Risk Non PEPs']
        ];

        return ArrayHelper::map($data, 'key', 'value');
    }
    
}
