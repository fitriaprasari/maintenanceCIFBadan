<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use \app\models\Customer;
use \app\models\LongcifBadanSusunanPengurus;
use app\models\LongcifBadan;
use \app\models\Customercorp;
use \app\models\CustomerUpdatelog;
use \app\models\ReprintcifLog;
use \app\models\KabupatenKota;
use \app\models\Province;
use \app\models\Employmentkyc;
use \app\models\Acoffund;
use \app\models\Acopenpurpose;
use \app\models\Income;
use \app\models\MonthlyTxnAmt;
use \app\models\TxnFreqMonth;
use \app\models\Nationality;
use \app\models\Branch;
use \yii\filters\VerbFilter;
use \app\models\WsclientLog;
use \app\modules\dukcapil\common\Search;
use \app\models\Model;
use app\common\helpers\Helpers;

//use \yii\base\Model;

/**
 * CustomerController implements the CRUD actions for Customer model.
 * 
 * @author rafi
 */
class CustomerController extends Controller {

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionCreatesmartcif()
    {

        $session = Yii::$app->session;

        $model = new Customer(['scenario' => 'create_update']);
        $model->nationality = "ID";
        $model->reside_y_n = "Y";

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {

            //membuat inputan menjadi huruf kapital
            $model->short_name = strtoupper($model->short_name);
            $model->place_birth = strtoupper($model->place_birth);
            $model->moth_maiden = strtoupper($model->moth_maiden);
            $model->street = strtoupper($model->street);
            $model->address = strtoupper($model->address);
            $model->town_country = strtoupper($model->town_country);
            $model->country = strtoupper($model->country);

            //email jika terdapat karakter "_" maka diubah menjadi "'_'" agar dapat diterima t24
            $model->email_1 = str_replace("_", "'_'", $model->email_1);
            $model->birth_incorp_date = date("Y-m-d", strtotime($model->birth_incorp_date));
            $model->account_officer = "9300"; //account_officer di syiar, untuk customer individu di set 9300.
            $model->company_book = Yii::$app->user->identity->branch_cd;
            $model->contact_date = date("Y-m-d");
            $model->same_as_resadd = "Y";
            $model->taxable = "Y";
            $model->sector = "29"; //individual
            $model->industry = "1000";
            $model->target = "9999";

            //field local syiarexpress
            $model->local_created_date = date("Y-m-d");
            $model->local_inputter = Yii::$app->user->identity->id;
            $model->local_origin = Customer::ORIGIN_SYIAREX;
            $model->local_customer_type = Customer::CUST_TYPE_INDIVIDU;
            $model->local_state = Customer::STATE_ACTIVE;

            $process = $model->bukaCIFt24();

            if ($process['status'] == WsclientLog::STATOK)
            {
                $session->setFlash('state', 'onestop');
                //redirect ke halaman pemilihan produk tabungan by Onny
                return $this->redirect([
                            'account/redirect',
                            'cif_no' => $model->id,
                            'account_title' => $model->short_name,
                            'short_title' => $model->short_name
                ]);
            }
            else
            {
                $session->setFlash('createCIFFailed', '<div class="alert alert-danger">' . $process['msg'] . '</div>');
            }
        }
        return $this->render('smartcif_create', ['model' => $model]);
    }

    public function actionPrintsmartcif($cifno)
    {

        $model = $this->findModel($cifno);
        $model->district_code = KabupatenKota::findOne($model->district_code) !== NULL ? KabupatenKota::findOne($model->district_code)->kab_name : "";
        $model->province = Province::findOne($model->province) !== NULL ? Province::findOne($model->province)->prov_name : "";
        $model->employment_kyc = Employmentkyc::findOne($model->employment_kyc) !== NULL ? Employmentkyc::findOne($model->employment_kyc)->descr : "";
        $model->ac_of_fund = Acoffund::findOne($model->ac_of_fund) !== NULL ? Acoffund::findOne($model->ac_of_fund)->descr : "";
        $model->ac_open_purpose = Acopenpurpose::findOne($model->ac_open_purpose) !== NULL ? Acopenpurpose::findOne($model->ac_open_purpose)->descr : "";
        $model->income = Income::findOne($model->income) !== NULL ? Income::findOne($model->income)->descr : "";
        $model->monthly_txn_amt = MonthlyTxnAmt::findOne($model->monthly_txn_amt) !== NULL ? MonthlyTxnAmt::findOne($model->monthly_txn_amt)->descr : "";
        $model->txn_freq_mon = TxnFreqMonth::findOne($model->txn_freq_mon) !== NULL ? TxnFreqMonth::findOne($model->txn_freq_mon)->descr : "";
        $model->nationality = Nationality::findOne($model->nationality) !== NULL ? Nationality::findOne($model->nationality)->nationality_name : "";
        $model->company_book = Branch::findOne($model->company_book) !== NULL ? Branch::findOne($model->company_book)->branch_nm : "KODE CABANG " . $model->company_book . " TIDAK DITEMUKAN";
        $model->religion = \app\models\Agama::tampilAgama($model->religion) . "";

        return $this->renderPartial('smartcif_print_view', ['model' => $model]);
    }

    public function actionPrintcif($cif_no)
    {

        $model = $this->findModel($cif_no);
        $model->district_code = KabupatenKota::findOne($model->district_code) !== NULL ? KabupatenKota::findOne($model->district_code)->kab_name : "";
        $model->province = Province::findOne($model->province) !== NULL ? Province::findOne($model->province)->prov_name : "";
        $model->employment_kyc = Employmentkyc::findOne($model->employment_kyc) !== NULL ? Employmentkyc::findOne($model->employment_kyc)->descr : "";
        $model->ac_of_fund = Acoffund::findOne($model->ac_of_fund) !== NULL ? Acoffund::findOne($model->ac_of_fund)->descr : "";
        $model->ac_open_purpose = Acopenpurpose::findOne($model->ac_open_purpose) !== NULL ? Acopenpurpose::findOne($model->ac_open_purpose)->descr : "";
        $model->income = Income::findOne($model->income) !== NULL ? Income::findOne($model->income)->descr : "";
        $model->monthly_txn_amt = MonthlyTxnAmt::findOne($model->monthly_txn_amt) !== NULL ? MonthlyTxnAmt::findOne($model->monthly_txn_amt)->descr : "";
        $model->txn_freq_mon = TxnFreqMonth::findOne($model->txn_freq_mon) !== NULL ? TxnFreqMonth::findOne($model->txn_freq_mon)->descr : "";
        $model->nationality = Nationality::findOne($model->nationality) !== NULL ? Nationality::findOne($model->nationality)->nationality_name : "";
        $model->company_book = Branch::findOne($model->company_book) !== NULL ? Branch::findOne($model->company_book)->branch_nm : "KODE CABANG " . $model->company_book . " TIDAK DITEMUKAN";
        $model->religion = \app\models\Agama::tampilAgama($model->religion) . "";

        return $this->renderPartial('smartcif_print_view', ['model' => $model]);
    }

    public function actionUpdatesmartcifsearch()
    {

        $request = Yii::$app->request;
        $session = Yii::$app->session;

        $model = new Customer(['scenario' => 'tampil']);

        if ($model->load($request->post()) && $model->validate())
        {

            //mencari data dari T24 dulu.
            $process = Customer::bacaSmartCIFT24($model->id);

            //Pencarian data CIF pada T24.
            if ($process['status'] == WsclientLog::STATOK)
            {
                $model = Customer::findOne($model->id);

                $nationality = function ($model) {

                    if (strlen($model->nationality) < 1)
                    {
                        return "-";
                    }
                    elseif (Nationality::findOne($model->nationality) == NULL)
                    {
                        return "kode " . $data->getAttributeLabel('nationality') . " " . $model->nationality . " belum terdaftar di syiarexpress";
                    }
                    else
                    {
                        return Nationality::findOne($model->nationality)->nationality_name;
                    }
                    return $model->nationality;
                };

                $province = function($model) {
                    
                    if (strlen($model->province) < 1)
                    {
                        return "-";
                    }
                    elseif (Province::findOne($model->province) == NULL)
                    {
                        return "kode " . $model->getAttributeLabel('province') . " " . $model->province . " belum terdaftar di syiarexpress";
                    }
                    else
                    {
                        return Province::findOne($model->province)->prov_name;
                    }
                };

                $district_code = function($model) {
                    
                    if (strlen($model->district_code) < 1)
                    {
                        return "-";
                    }
                    elseif (KabupatenKota::findOne($model->district_code) === NULL)
                    {
                        return "kode " . $model->getAttributeLabel("district_code") . " " . $model->district_code . " belum terdaftar di syiarexpress";
                    }
                    else
                    {
                        return KabupatenKota::findOne($model->district_code)->kab_name;
                    }
                };

                $employment_kyc = function($model) {
                    
                    if (strlen($model->employment_kyc) < 1)
                    {
                        return "-";
                    }
                    elseif (Employmentkyc::findOne($model->employment_kyc) == NULL)
                    {
                        return "kode " . $model->getAttributeLabel('employment_kyc') . " " . $model->employment_kyc . " belum terdaftar di syiarexpress";
                    }
                    else
                    {
                        return Employmentkyc::findOne($model->employment_kyc)->descr;
                    }
                };

                $ac_of_fund = function($model) {
                    
                    if (strlen($model->ac_of_fund) < 1)
                    {
                        return "-";
                    }
                    elseif (\app\models\Acoffund::findOne($model->ac_of_fund) == NULL)
                    {
                        return "kode " . $model->getAttributeLabel('ac_of_fund') . " " . $model->ac_of_fund . " belum terdaftar di syiarexpress";
                    }
                    else
                    {
                        return \app\models\Acoffund::findOne($model->ac_of_fund)->descr;
                    }
                };

                $ac_open_purpose = function($model) {
                    
                    if (strlen($model->ac_open_purpose) < 1)
                    {
                        return "-";
                    }
                    elseif (\app\models\Acopenpurpose::findOne($model->ac_open_purpose) == NULL)
                    {
                        return "kode " . $model->getAttributeLabel('ac_open_purpose') . $model->ac_open_purpose . " belum terdaftar di syiarexpress";
                    }
                    else
                    {
                        return \app\models\Acopenpurpose::findOne($model->ac_open_purpose)->descr;
                    }
                };

                $income = function($model) {
                    
                    if (strlen($model->income) < 1)
                    {
                        return "-";
                    }
                    elseif (\app\models\Income::findOne($model->income) == NULL)
                    {
                        return "kode " . $model->getAttributeLabel('income') . " " . $model->income . " belum terdaftar";
                    }
                    else
                    {
                        return \app\models\Income::findOne($model->income)->descr;
                    }
                };

                $monthly_txn_amt = function($model) {
                    
                    if (strlen($model->monthly_txn_amt) < 1)
                    {
                        return "-";
                    }
                    elseif (\app\models\MonthlyTxnAmt::findOne($model->monthly_txn_amt) == NULL)
                    {
                        return "kode " . $model->getAttributeLabel('monthly_txn_amt') . " " . $model->monthly_txn_amt . " belum terdaftar";
                    }
                    else
                    {
                        return \app\models\MonthlyTxnAmt::findOne($model->monthly_txn_amt)->descr;
                    }
                };

                $txn_freq_mon = function($model) {
                    
                    if (strlen($model->txn_freq_mon) < 1)
                    {
                        return "-";
                    }
                    elseif (\app\models\TxnFreqMonth::findOne($model->txn_freq_mon) == NULL)
                    {
                        return "kode " . $model->getAttributeLabel('txn_freq_mon') . " " . $model->txn_freq_mon;
                    }
                    else
                    {
                        return \app\models\TxnFreqMonth::findOne($model->txn_freq_mon)->descr;
                    }
                };

                $model->nationality = $nationality($model);
                $model->province = $province($model);
                $model->district_code = $district_code($model);
                $model->employment_kyc = $employment_kyc($model);
                $model->ac_of_fund = $ac_of_fund($model);
                $model->ac_open_purpose = $ac_open_purpose($model);
                $model->income = $income($model);
                $model->monthly_txn_amt = $monthly_txn_amt($model);
                $model->txn_freq_mon = $txn_freq_mon($model);
            }
            else
            {
                $session->setFlash("msgnotfound", "<div class='alert alert-danger'>" . $process['msg'] . "</div>");
            }

            //Memeriksa state dari CIF, Apakah sedang aktif (ACTIVE)
            if ($model->local_state == Customer::STATE_ACTIVE)
            {
                $session->setFlash("ciffound", "OK");
                $session->setFlash("msgfound", "<div class='alert alert-success'>" . $process['msg'] . "</div>");
            }
            //Memeriksa state dari CIF, Apakah sedang dalam otorisasi (UPDATING_NAU)
            if ($model->local_state == Customer::STATE_UPDATING_NAU)
            {
                $process['msg'] = "Perubahan CIF sebelumnya belum di otorisasi, lakukan otorisasi terlebih dahulu !";
                $session->setFlash("msgupdating", "<div class='alert alert-danger'>" . $process['msg'] . "</div>");
            }
        }

        return $this->render('smartcif_search_update', ['model' => $model]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdatesmartcif($id)
    {

        $model = $this->findModel($id);
        $model->scenario = "create_update";

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {

            $newData = Yii::$app->request->post('Customer');
            $newData['short_name'] = strtoupper($newData['short_name']);
            $newData['place_birth'] = strtoupper($newData['place_birth']);
            $newData['moth_maiden'] = strtoupper($newData['moth_maiden']);
            $newData['street'] = strtoupper($newData['street']);
            $newData['address'] = strtoupper($newData['address']);
            $newData['town_country'] = strtoupper($newData['town_country']);
            $newData['country'] = strtoupper($newData['country']);
            $newData['birth_incorp_date'] = date('Y-m-d', strtotime($newData['birth_incorp_date']));

            $oldData = Customer::filterUpdatableData($this->findModel($id)->getAttributes(), $newData);
            $detailUpdate = Customer::createUpdateDetail($oldData, $newData);

            $process = Customer::inputUpdateCIFT24($id, $detailUpdate);

            $session = Yii::$app->session;

            if ($process['status'] == WsclientLog::STATOK)
            {
                $session->setFlash('saveUpdateOK', '<div class="alert alert-success">' . $process['msg'] . '</div>');
                return $this->redirect(['displaysmartcifdatadiff', 'idlogupdate' => $process['idlogupdate']]);
            }
            else
            {
                $session->setFlash('saveUpdateFailed', '<div class="alert alert-danger">' . $process['msg'] . '</div>');
            }
        }
        return $this->render('smartcif_update', ['model' => $model]);
    }

    //menampilkan perbedaan data lama dan baru pada proses update smartcif
    public function actionDisplaysmartcifdatadiff($idlogupdate)
    {

        $updatelog = CustomerUpdatelog::findOne($idlogupdate);
        $updatelog->detail = json_decode($updatelog->detail, true);
        return $this->render('smartcif_view_data_diff', ['updatelog' => $updatelog]);
    }

    //menampilkan perbedaan data lama dan baru pada proses update longcif
    public function actionDisplaylongcifdatadiff($idlogupdate)
    {
        $updatelog = \app\models\LongcifUpdatelog::findOne($idlogupdate);
        $updatelog->detail = json_decode($updatelog->detail, true);
        return $this->render('longcif_view_data_diff', ['updatelog' => $updatelog]);
    }
   
    //menampilkan perbedaan data lama dan baru pada proses update cif pembiayaan
    public function actionDisplaycifpembydatadiff($idlogupdate)
    {

        $updatelog = \app\models\CifpembyUpdateLog::findOne($idlogupdate);
        $updatelog->detail = json_decode($updatelog->detail, true);
        return $this->render('cifpemby_view_data_diff', ['updatelog' => $updatelog]);
    }

    //menampilkan perbedaan data lama dan baru pada proses update cif simpel
    public function actionDisplaycifsimpeldatadiff($idlogupdate)
    {

        $updatelog = \app\models\CifsimpelUpdateLog::findOne($idlogupdate);
        $updatelog->detail = json_decode($updatelog->detail, true);
        return $this->render('cifsimpel_view_data_diff', ['updatelog' => $updatelog]);
    }

    //menampilkan perbedaan data otorisasi update smartcif
    public function actionDisplaysmartcifotorupdate()
    {
        $co_code = Yii::$app->user->identity->branch_cd;
        $searchModel = new CustomerUpdatelog();
        $dataProvider = $searchModel->searchDataotor(Yii::$app->request->queryParams, $co_code);

        return $this->render('smartcif_update_data_otor', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    //menampilkan perbedaan data otorisasi update longcif
    public function actionDisplaylongcifotorupdate()
    {

        $co_code = Yii::$app->user->identity->branch_cd;
        $searchModel = new \app\models\LongcifUpdatelog();
        $dataProvider = $searchModel->searchDataotor(Yii::$app->request->queryParams, $co_code);
                
        return $this->render('longcif_update_data_otor', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    //menampilkan perbedaan data otorisasi update cif pembiayaan
    public function actionDisplaycifpembiayaanotorupdate()
    {

        $co_code = Yii::$app->user->identity->branch_cd;
        $searchModel = new \app\models\CifpembyUpdateLog();
        $dataProvider = $searchModel->searchDataotor(Yii::$app->request->queryParams, $co_code);

        return $this->render('cifpemby_update_data_otor', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    //menampilkan perbedaan data otorisasi update cif simpel
    public function actionDisplaycifsimpelotorupdate()
    {

        $co_code = Yii::$app->user->identity->branch_cd;
        $searchModel = new \app\models\CifsimpelUpdateLog();
        $dataProvider = $searchModel->searchDataotor(Yii::$app->request->queryParams, $co_code);

        return $this->render('cifsimpel_update_data_otor', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    //otorisasi update smart cif
    public function actionOtorupdatesmartcif($id)
    {

        $updatelog = CustomerUpdatelog::findOne($id);
        $updatelog->detail = json_decode($updatelog->detail, true); //convert json to array

        if ($updatelog->load(Yii::$app->request->post()))
        {

            $session = Yii::$app->session;

            $updatelog = CustomerUpdatelog::findOne($updatelog->id);
            $updatelog->detail = json_decode($updatelog->detail, true);

            $newData = Customer::newData($updatelog->detail);

            $model = $this->findModel($updatelog->cif_no);
            $model->attributes = $newData;
            $model->birth_incorp_date = date('Y-m-d', strtotime($model->birth_incorp_date));

            $process = $model->OtoUpdateCIFT24($updatelog->id);

            if ($process['status'] == WsclientLog::STATOK)
            {
                $session->setFlash("otoUpdateCIFSuccess", "<div class='alert alert-success'>" . $process['msg'] . "</div>");
                return $this->redirect(['otorupdatesmartcif', 'id' => $updatelog->id]);
            }
            else
            {
                $session->setFlash("otoUpdateCIFFailed", "<div class='alert alert-danger'>" . $process['msg'] . "</div>");
            }
        }

        return $this->render('smartcif_view_otor', ['updatelog' => $updatelog]);
    }

    //otorisasi update long cif
    public function actionOtorupdatelongcif($id)
    {
        $updatelog = \app\models\LongcifUpdatelog::findOne($id);
        $updatelog->detail = json_decode($updatelog->detail, true); //convert json to array
        
        //@fitriana.dewi
        //cek apakah cust.type = Badan Usaha/Lembaga
        $data = \app\models\LongcifBadan::findOne($updatelog->cif_no);
        
        if (!empty($data))
        {
            return $this->redirect(['otorupdatelongcifbadan', 'id' => $updatelog->id]);
        }

        if ($updatelog->load(Yii::$app->request->post()))
        {
            $session = Yii::$app->session;

            $updatelog = \app\models\LongcifUpdatelog::findOne($updatelog->id);
            $updatelog->detail = json_decode($updatelog->detail, true);

            $newData = \app\models\Longcif::newData($updatelog->detail);

            $model = $this->findModellong($updatelog->cif_no);
            $model->attributes = $newData;
            $model->birth_incorp_date = date('Y-m-d', strtotime($model->birth_incorp_date));
            $process = $model->OtoUpdateCIFT24($updatelog->id);

            if ($process['status'] == WsclientLog::STATOK)
            {
                $session->setFlash("otoUpdateCIFSuccess", "<div class='alert alert-success'>" . $process['msg'] . "</div>");
                return $this->redirect(['otorupdatelongcif', 'id' => $updatelog->id]);
            }
            else
            {
                $session->setFlash("otoUpdateCIFFailed", "<div class='alert alert-danger'>" . $process['msg'] . "</div>");
            }
        }

        return $this->render('longcif_view_otor', ['updatelog' => $updatelog]);
    }
    
    //otorisasi update long cif badan
    public function actionOtorupdatelongcifbadan($id)
    {

        $updatelog = \app\models\LongcifUpdatelog::findOne($id);
        $updatelog->detail = json_decode($updatelog->detail, true); //convert json to array

        if ($updatelog->load(Yii::$app->request->post()))
        {

            $session = Yii::$app->session;

            $updatelog = \app\models\LongcifUpdatelog::findOne($updatelog->id);
            $updatelog->detail = json_decode($updatelog->detail, true);

            $newData = \app\models\Longcif::newData($updatelog->detail);

            $model = $this->findModellongBadan($updatelog->cif_no);
            $model->attributes = $newData;
            $model->birth_incorp_date = date('Y-m-d', strtotime($model->birth_incorp_date));

            $process = $model->OtorUpdateCIFT24($updatelog->id);
         
            if ($process['status'] == WsclientLog::STATOK)
            {
                $session->setFlash("otoUpdateCIFSuccess", "<div class='alert alert-success'>" . $process['msg'] . "</div>");
                return $this->redirect(['otorupdatelongcifbadan', 'id' => $updatelog->id]);
            }
            else
            {
                $session->setFlash("otoUpdateCIFFailed", "<div class='alert alert-danger'>" . $process['msg'] . "</div>");
            }
        }

        return $this->render('longcif_view_otor', ['updatelog' => $updatelog]);
    }

    //otorisasi update cif pembiayaan
    public function actionOtorupdatecifpemby($id)
    {

        $updatelog = \app\models\CifpembyUpdateLog::findOne($id);
        $updatelog->detail = json_decode($updatelog->detail, true); //convert json to array

        if ($updatelog->load(Yii::$app->request->post()))
        {

            $session = Yii::$app->session;

            $updatelog = \app\models\CifpembyUpdateLog::findOne($updatelog->id);
            $updatelog->detail = json_decode($updatelog->detail, true);

            $newData = \app\models\Longcif::newData($updatelog->detail);

            $model = $this->findModellong($updatelog->cif_no);
            $model->attributes = $newData;
            $model->birth_incorp_date = date('Y-m-d', strtotime($model->birth_incorp_date));

            $process = $model->OtoUpdateCIFPemby($updatelog->id);

            if ($process['status'] == WsclientLog::STATOK)
            {
                $session->setFlash("otoUpdateCIFSuccess", "<div class='alert alert-success'>" . $process['msg'] . "</div>");
                return $this->redirect(['otorupdatecifpemby', 'id' => $updatelog->id]);
            }
            else
            {
                $session->setFlash("otoUpdateCIFFailed", "<div class='alert alert-danger'>" . $process['msg'] . "</div>");
            }
        }

        return $this->render('cifpemby_view_otor', ['updatelog' => $updatelog]);
    }

    //otorisasi update cif simpanan pelajar (simpel)
    public function actionOtorupdatecifsimpel($id)
    {

        $updatelog = \app\models\CifsimpelUpdateLog::findOne($id);
        $updatelog->detail = json_decode($updatelog->detail, true); //convert json to array

        if ($updatelog->load(Yii::$app->request->post()))
        {

            $session = Yii::$app->session;

            $updatelog = \app\models\CifsimpelUpdateLog::findOne($updatelog->id);
            $updatelog->detail = json_decode($updatelog->detail, true);

            $newData = \app\models\Longcif::newData($updatelog->detail);

            $model = $this->findModellong($updatelog->cif_no);
            $model->attributes = $newData;
            $model->birth_incorp_date = date('Y-m-d', strtotime($model->birth_incorp_date));

            $process = $model->OtoUpdateCIFsimpel($updatelog->id);

            if ($process['status'] == WsclientLog::STATOK)
            {
                $session->setFlash("otoUpdateCIFSuccess", "<div class='alert alert-success'>" . $process['msg'] . "</div>");
                return $this->redirect(['otorupdatecifsimpel', 'id' => $updatelog->id]);
            }
            else
            {
                $session->setFlash("otoUpdateCIFFailed", "<div class='alert alert-danger'>" . $process['msg'] . "</div>");
            }
        }

        return $this->render('cifsimpel_view_otor', ['updatelog' => $updatelog]);
    }

    public function actionReprintsmartcif()
    {

        $model = new ReprintcifLog();
        $request = Yii::$app->request;
        $session = Yii::$app->session;

        if ($model->load($request->post()) && $model->validate())
        {

            $caricif = Customer::bacaSmartCIFT24($model->cif_no);

            if ($caricif['status'] == WsclientLog::STATOK)
            {
                $model->inputter = Yii::$app->user->identity->id;
                $model->input_date = date('Y-m-d');
                $model->co_code = Yii::$app->user->identity->branch_cd;
                $model->save();
                $datacif = Customer::findOne($model->cif_no);

                $datacif->district_code = KabupatenKota::findOne($datacif->district_code) !== NULL ? KabupatenKota::findOne($datacif->district_code)->kab_name : "";
                $datacif->province = Province::findOne($datacif->province) !== NULL ? Province::findOne($datacif->province)->prov_name : "";
                $datacif->employment_kyc = Employmentkyc::findOne($datacif->employment_kyc) !== NULL ? Employmentkyc::findOne($datacif->employment_kyc)->descr : "";
                $datacif->ac_of_fund = Acoffund::findOne($datacif->ac_of_fund) !== NULL ? Acoffund::findOne($datacif->ac_of_fund)->descr : "";
                $datacif->ac_open_purpose = Acopenpurpose::findOne($datacif->ac_open_purpose) !== NULL ? Acopenpurpose::findOne($datacif->ac_open_purpose)->descr : "";
                $datacif->income = Income::findOne($datacif->income) !== NULL ? Income::findOne($datacif->income)->descr : "";
                $datacif->monthly_txn_amt = MonthlyTxnAmt::findOne($datacif->monthly_txn_amt) !== NULL ? MonthlyTxnAmt::findOne($datacif->monthly_txn_amt)->descr : "";
                $datacif->txn_freq_mon = TxnFreqMonth::findOne($datacif->txn_freq_mon) !== NULL ? TxnFreqMonth::findOne($datacif->txn_freq_mon)->descr : "";
                $datacif->nationality = Nationality::findOne($datacif->nationality) !== NULL ? Nationality::findOne($datacif->nationality)->nationality_name : "";
                $datacif->company_book = Branch::findOne($datacif->company_book) !== NULL ? Branch::findOne($datacif->company_book)->branch_nm : "KODE CABANG " . $datacif->company_book . " BELUM TERDAFTAR";
                $datacif->religion = \app\models\Agama::tampilAgama($datacif->religion) . "";

                $session->setFlash('datacif', 'found');
                $session->setFlash('msgfound', "<div class='alert alert-success'>" . $caricif['msg'] . "</div>");

                return $this->render('smartcif_reprint_form', ['model' => $model, 'datacif' => $datacif]);
            }
            else
            {
                $session->setFlash('msgnotfound', "<div class='alert alert-danger'>" . $caricif['msg'] . "</div>");
            }
        }

        return $this->render('smartcif_reprint_form', ['model' => $model]);
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModellong($id)
    {
        if (($model = \app\models\Longcif::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModellongBadan($id)
    {
        if (($model = \app\models\LongcifBadan::findOne($id)) !== null)
        {
        return $model;
            
        }
        
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelSusunanPengurus($id)
    {
        if (($model = \app\models\LongcifBadanSusunanPengurus::find()->where(['bd_cif'=> $id]) !== null))
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

//    protected function findModels($id) {
//        if (($model = \app\models\LongcifUpdatelog::findOne($id)) !== null) {
//            return $model;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
//        }
//    }

    protected function findLog($id)
    {
        if (($model = CustomerUpdatelog::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //ini untuk hapus data otor maintenance CIF lengkap / longcif
    protected function findLong($id)
    {
        if (($model = \app\models\LongcifUpdatelog::findOne($id)) !== null)
        {

            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //ini untuk hapus data otor maintenance CIF pembiayaan
    protected function findPemby($id)
    {
        if (($model = \app\models\CifpembyUpdateLog::findOne($id)) !== null)
        {

            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //ini untuk hapus data otor maintenance CIF Simpel
    protected function findSimpel($id)
    {
        if (($model = \app\models\CifsimpelUpdateLog::findOne($id)) !== null)
        {

            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Digunakan untuk mendapatkan data kabupaten/kota berdasarkan id provisi
     * Methode request yang digunakan dengan ajax
     * @return data kabupaten dalam tag html <option>
     */
    public function actionGetkabkot()
    {
        $request = Yii::$app->request;
        $id_prov = $request->post('id_prov', '');
        $id_kab_sel = $request->post('id_kab', '');

        $option = KabupatenKota::listKabKot($id_prov);

        if (count($option) > 0)
        {
            foreach ($option as $key => $value)
            {
                $selected = ($key == $id_kab_sel) ? 'selected' : '';
                echo "<option $selected value='" . $key . "'>" . $value . "</option>";
            }
        }
        else
        {
            echo "<option value=''>---Pilih Kabupaten Kota---</option>";
        }
    }

    public function actionGetkodepos($id)
    {
        echo KabupatenKota::tampilKodePos($id);
    }

    /**
     * Displays a single Customer model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionBacacif($cifno)
    {

        //mencari data dari T24 dulu.
        $process = Customer::bacaSmartCIFT24($cifno);

        if ($process['status'] == WsclientLog::STATOK)
        {
            $customer = Customer::findOne($cifno);

            if ($customer !== null)
            {
                echo WsclientLog::STATOK . "|" . $customer->short_name;
            }
            else
            {
                echo WsclientLog::STATERR . "|" . "Data Tidak ditemukan coba lagi";
            }
        }
        else
        {
            echo WsclientLog::STATERR . "|" . $process['msg'];
        }
    }

    public function actionGetcifdata($cifno)
    {

        $cariRekening = Customer::getAccountbyCifT24($cifno);
        $accounts = $cariRekening['daftarRek'];

        if (count($accounts) > 0)
        {
            foreach ($accounts as $account)
            {
                echo "<option value=" . $account['c0'] . ">" . $account['c0'] . "&nbsp;&nbsp;" . $account['c2'] . "</option>";
            }
        }
    }

    public function actionCeklookupcustomerlegalidno($legal_id_no, $legal_type)
    {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;

        if ($legal_type === "")
        {
            throw new \yii\web\HttpException(404, "Pilih Jenis Kartu Identitas");
        }
        if ($legal_id_no === "")
        {
            throw new \yii\web\HttpException(404, "No Kartu Identitas masih Kosong");
        }
        //return Customer::cekLegalId($legal_id_no);
        $retcek = json_decode(Customer::cekLegalId($legal_id_no));
        $cekdukcapil = true;
        if ($retcek->status === "found")
        {
            return json_encode([
                "status" => $retcek->status,
                "as_of_dt" => $retcek->as_of_dt . "",
                "cif_no" => $retcek->cif_no,
                "short_nm" => $retcek->short_nm,
                "legal_type" => $retcek->legal_type,
                "legal_id_no" => $retcek->legal_id_no,
                "jeniskartu" => "",
            ]);
        }

        if (!$cekdukcapil || $legal_type <> "01-KTP")
        {

            return json_encode([
                "status" => $retcek->status,
                "legal_id_no" => $retcek->legal_id_no,
                "jeniskartu" => "",
            ]);
        }

        $wsdl = Yii::$app->params['wsdldukcapil'];

        $searchnik = new Search();
        $searchnik->url = $wsdl;

        $model = $searchnik->get($legal_id_no, Yii::$app->user->identity->id);
        if (!$model)
        {
            throw new \yii\web\HttpException(404, $searchnik->errormsg);
        }

        //pendidikan terakhir
        $educat_other = '';
        if ($model->pddk_akh == 'DIPLOMA I/II')
        {
            $education = '104';
        }
        elseif ($model->pddk_akh == 'AKADEMI/DIPLOMA III/SARJANA MUDA')
        {
            $education = '105';
        }
        elseif ($model->pddk_akh == 'DIPLOMA IV/STRATA I')
        {
            $education = '107';
        }
        elseif ($model->pddk_akh == 'STRATA-II')
        {
            $education = '108';
        }
        elseif ($model->pddk_akh == 'STRATA-III')
        {
            $education = '109';
        }
        elseif ($model->pddk_akh == 'TAMAT SD/SEDERAJAT')
        {
            $education = '100';
        }
        elseif ($model->pddk_akh == 'SLTP/SEDERAJAT')
        {
            $education = '101';
        }
        elseif ($model->pddk_akh == 'SLTA/SEDERAJAT')
        {
            $education = '102';
        }
        else
        {
            $education = '199';
            if ($model->pddk_akh == 'TIDAK TERDEFINISI')
                $model->pddk_akh = '';
            $educat_other = $model->pddk_akh;
        }

        $retval = [
            "status" => $retcek->status,
            "legal_id_no" => $retcek->legal_id_no,
            "jeniskartu" => "01-KTP",
            "nama_lengkap" => strtoupper($model->nama_lengkap),
            "tmpt_lhr" => $model->tmpt_lhr,
            "tgl_lahir" => substr($model->tgl_lhr, 8, 2) . "-"
            . "" . substr($model->tgl_lhr, 5, 2) . "-" . substr($model->tgl_lhr, 0, 4),
            "jenis_klmin" => strtoupper($model->jenis_klmin),
            "nama_lgkp_ibu" => $model->nama_lgkp_ibu,
            "status_kawin" => $model->status_kawin,
            "alamat" => $model->alamat,
            "no_rt" => str_pad($model->no_rt, 3, "0", STR_PAD_LEFT),
            "no_rw" => str_pad($model->no_rw, 3, "0", STR_PAD_LEFT),
            "kel_name" => $model->kel_name,
            "kec_name" => $model->kec_name,
            "prop_name" => $model->prop_name,
            "kab_name" => $model->kab_name,
            "no_prop" => $model->no_prop,
            "no_kab" => $model->no_kab,
            "kode_pos" => $model->kode_pos,
            "syiar_noprop" => $model->syiar_noprop,
            "syiar_nokab" => $model->syiar_nokab,
            "syiar_agama" => $model->syiar_agama,
            //deni tambahan untuk cif lengkap 2017-05-07
            "ektp_created" => $model->ektp_created,
            "ektp_expiry" => '2049-12-31',
            "education" => $education,
            "educat_other" => $educat_other,
        ];

        return json_encode($retval);
    }

    public function actionTest($legal_id_no = "327509700595")
    {

        $json = Customer::cekLegalId($legal_id_no);

        return $json;
    }

    public function actionHapusupdatesmartcif($cifno)
    {
        $co_code = Yii::$app->user->identity->branch_cd;
        $model = CustomerUpdatelog::find()->where(['cif_no' => $cifno, 'status' => 'INAU', 'co_code' => Yii::$app->user->identity->branch_cd])->one();
        $cifno = $model->cif_no;

        if ($model != null)
        {
            $process = $model->hapusUpdateCIF();
            //var_dump($process); die;
            if ($process['status'] == WsclientLog::STATOK)
            {
                Yii::$app->session->setFlash('hapusUpdateCIFSuccess', '<div class="alert alert-success">' . $process['msg'] . '</div>');
                return $this->redirect(['customer/displaysmartcifotorupdate']);
            }
            else
            {
                Yii::$app->session->setFlash('hapusUpdateCIFFailed', '<div class="alert alert-danger">' . $process['msg'] . '</div>');
                return $this->redirect(
                                ['customer/otorupdatesmartcif',
                                    'id' => $model->id
                ]);
            }
        }
        else
        {
            throw new NotFoundHttpException('CIF ' . $cifno . ' tidak ditemukan.');
        }
    }

    public function actionHapusupdateciflong($id)
    {

        $request = Yii::$app->request;
        $session = Yii::$app->session;

        $model = $this->findLong($id);

        if ($model != null)
        {

            $process = $model->hapusUpdateciflong();


            if ($process['status'] == WsclientLog::STATOK)
            {
                $session->setFlash('hapusUpdateCIFSuccess', '<div class="alert alert-success">' . $process['msg'] . '</div>');
            }
            else
            {
                $session->setFlash('hapusUpdateCIFFailed', '<div class="alert alert-danger">' . $process['msg'] . '</div>');
            }
        }
        else
        {
            $session->setFlash('hapusUpdateCIFFailed', '<div class="alert alert-danger">' . "Data tidak ditemukan" . '</div>');
        }

        return $this->redirect(['customer/displaylongcifotorupdate']);
    }

    public function actionHapusupdatecifpemby($id)
    {

        $request = Yii::$app->request;
        $session = Yii::$app->session;

        $model = $this->findPemby($id);

        if ($model != null)
        {

            $process = $model->hapusUpdatecifpemby();


            if ($process['status'] == WsclientLog::STATOK)
            {
                $session->setFlash('hapusUpdateCIFSuccess', '<div class="alert alert-success">' . $process['msg'] . '</div>');
            }
            else
            {
                $session->setFlash('hapusUpdateCIFFailed', '<div class="alert alert-danger">' . $process['msg'] . '</div>');
            }
        }
        else
        {
            $session->setFlash('hapusUpdateCIFFailed', '<div class="alert alert-danger">' . "Data tidak ditemukan" . '</div>');
        }
        return $this->redirect(['customer/displaycifpembiayaanotorupdate']);
    }

    public function actionHapusupdatecifsimpel($id)
    {

        $request = Yii::$app->request;
        $session = Yii::$app->session;

        $model = $this->findSimpel($id);

        if ($model != null)
        {

            $process = $model->hapusUpdatecifsimpel();


            if ($process['status'] == WsclientLog::STATOK)
            {
                $session->setFlash('hapusUpdateCIFSuccess', '<div class="alert alert-success">' . $process['msg'] . '</div>');
            }
            else
            {
                $session->setFlash('hapusUpdateCIFFailed', '<div class="alert alert-danger">' . $process['msg'] . '</div>');
            }
        }
        else
        {
            $session->setFlash('hapusUpdateCIFFailed', '<div class="alert alert-danger">' . "Data tidak ditemukan" . '</div>');
        }
        return $this->redirect(['customer/displaycifsimpelotorupdate']);
    }

    public function actionUpdatelongcifsearch()
    {

        $request = Yii::$app->request;
        $session = Yii::$app->session;

        $model = new \app\models\Longcif(['scenario' => 'tampil']);

        if ($model->load($request->post()))
        {
            //mencari data dari T24 dulu.
            $process = \app\models\Longcif::bacalongCIFT24($model->id);
            
            //Pencarian data CIF pada T24.
            $data = array();
            
            try {
                if ($process['status'] == WsclientLog::STATOK)
                {
                    $data = json_decode($process['msgresp']);
                    $id = $data->params->cifinfo->contents->c0;
                    $name = $data->params->cifinfo->contents->c1;
                    $street = $data->params->cifinfo->contents->c2;
                    $distr_nm = $data->params->cifinfo->contents->c3;
                    $cust_type = $data->params->cifinfo->contents->c4;
                    $company_book = $data->params->cifinfo->contents->c5;
                    $status = $data->params->cifinfo->contents->c6;
                    $mnemonic = $data->params->cifinfo->contents->c7;
                    
                    if($cust_type == "Badan Usaha/Lembaga"){
                        $model = \app\models\LongcifBadan::findOne($model->id);
                        
                       
                    }else{
                        $model = \app\models\Longcif::findOne($model->id);
                    }
                }
                else
                {
                    $session->setFlash("msgnotfound", "<div class='alert alert-danger'>" . $process['msg'] . "</div>");
                }
            } catch (\Exception $e) {
                $msgerr = $e->getMessage();
                $logmodel->error_msg = $msgerr;
                $logmodel->status = WsclientLog::STATERR;
            }

            //Memeriksa state dari CIF, Apakah sedang aktif (ACTIVE)
            if ($model['local_state'] == \app\models\Longcif::STATE_ACTIVE)
            {
                $session->setFlash("ciffound", "OK");
                $session->setFlash("msgfound", "<div class='alert alert-success'>" . $process['msg'] . "</div>");
            }
            //Memeriksa state dari CIF, Apakah sedang dalam otorisasi (UPDATING_NAU)
            if ($model['local_state'] == \app\models\Longcif::STATE_UPDATING_NAU)
            {
                $process['msg'] = "Perubahan CIF sebelumnya belum di otorisasi, lakukan otorisasi terlebih dahulu !";
                $session->setFlash("msgupdating", "<div class='alert alert-danger'>" . $process['msg'] . "</div>");
            }
        }
//        var_dump($model->cust_type);die;
        return $this->render('longcif_search_update', ['model' => $model]);
    }

    public function actionUpdatelongcif($id)
    {
        $co_code = Yii::$app->user->identity->branch_cd;
        $model = $this->findModellong($id);
        $cust_type = $model->cust_type;
                 
            $model->scenario = "create_update";

            if ($model->load(Yii::$app->request->post()))
            {
                $newData = Yii::$app->request->post('Longcif');
                $newData['short_name'] = strtoupper($newData['short_name']);
                $newData['place_birth'] = strtoupper($newData['place_birth']);
                $newData['moth_maiden'] = strtoupper($newData['moth_maiden']);
                $newData['street'] = strtoupper($newData['street']);
                $newData['address'] = strtoupper($newData['address']);
                $newData['town_country'] = strtoupper($newData['town_country']);
                $newData['country'] = strtoupper($newData['country']);
                
                $oldData = \app\models\Longcif::filterUpdatableData($this->findModellong($id)->getAttributes(), $newData);
                $detailUpdate = \app\models\Longcif::createUpdateDetail($oldData, $newData);
                
                $process = \app\models\Longcif::inputUpdateCIFT24($id, $detailUpdate);

                $session = Yii::$app->session;

                if ($process['status'] == WsclientLog::STATOK)
                {
                    $session->setFlash('saveUpdateOK', '<div class="alert alert-success">' . $process['msg'] . '</div>');
                    return $this->redirect(['displaylongcifdatadiff', 'idlogupdate' => $process['idlogupdate']]);
                }
                else
                {
                    $session->setFlash('saveUpdateFailed', '<div class="alert alert-danger">' . $process['msg'] . '</div>');
                }
            }
            return $this->render('longcif_update', ['model' => $model,'cust_type'=> $cust_type]);
        
    }
    
    public function actionUpdatelongcifbadan($id)
    {
        $cocode = Yii::$app->user->identity->branch_cd;

        $model2 = $this->findModellongBadan($id);
        $cust_type = $model2->cust_type;

        $oldData = $model2->getAttributes();
        $model2->scenario = 'create_update';

        $model2->local_state = LongcifBadan::STATE_UPDATING_NAU;
        
        $models3 = LongcifBadanSusunanPengurus::find()->where(['bd_cif' => $id])->all();
        
        
        if ($models3 == null)
        {
            $models3 = [new LongcifBadanSusunanPengurus()];
        }

        if ($model2->load(Yii::$app->request->post()))
        {
            try {
                
                $newData = Yii::$app->request->post('LongcifBadan');
                $oldData = $this->findModellongBadan($id)->getAttributes(); 
                $session = Yii::$app->session;
                $models3 = Model::createMultiple(LongcifBadanSusunanPengurus::classname());
                Model::loadMultiple($models3, Yii::$app->request->post());

                $valid = $model2->validate();
                if ($valid)
                {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {

                        if ($flag = $model2->save(false))
                        {
                             //periksa apakah ada susunan pengurus;
                            $existSP = LongcifBadanSusunanPengurus::find()->where(['bd_cif'=>$id])->all();
                            
                            if($existSP != null){
                                LongcifBadanSusunanPengurus::deleteAllSP($id);
                            }
                            
                            foreach ($models3 as $model3)
                            {
                               
                                $model3->bd_cif = $id;
                                
                                if (!($flag = $model3->save(false)))
                                {
                                    $transaction->rollBack();
                                    break;
                                }                           
                            }
                        }

                        if ($flag)
                        {
                        $transaction->commit();
                        $newDataSP = Yii::$app->request->post('LongcifBadanSusunanPengurus');
                        
                        //proses kirim ke T24
                        $detailUpdateCIF = \app\models\Longcif::createUpdateDetailBadan($oldData, $newData);
                        $newSP = \app\models\LongcifBadanSusunanPengurus::flatUpdateSP($newDataSP);
                        $oldSP = \app\models\LongcifBadanSusunanPengurus::flatUpdateSP($existSP);
                        $detailUpdateSP = \app\models\Longcif::createUpdateDetailBadan($oldSP,$newSP);
                        $detailUpdate = array_merge($detailUpdateCIF,$detailUpdateSP);
                        
                        $process = \app\models\LongcifBadan::inputUpdateCIFT24($id,
                                                                               $model2,
                                                                               $newDataSP,$detailUpdate);
                        
                        return $this->redirect(['displaylongcifbadanupdate', 'id' => $model2->id]);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }else{
                    throw new \Exception(\app\common\helpers\Helpers::multiImplode($model2->getErrors()));
                }
            
            } catch (\Exception $e) {
              Yii::$app->session->addFlash('danger', $e->getMessage());  
            }
        }
        return $this->render('longcif_update', ['cust_type' => $cust_type, 'model2' => $model2, 'models3' => (empty($models3)) ? [new LongcifBadanSusunanPengurus()] : $models3]);
    }
    
    public function actionDisplaylongcifbadanupdate($id)
    {  
        $newData = \app\models\LongcifBadan::findOne($id);
        $newDataSP = LongcifBadanSusunanPengurus::find()->where(['bd_cif' => $id])->all();
        
        return $this->render('longcifbadan_view', ['id' => $id, 'newData' => $newData,'newDataSP' => $newDataSP]);
    }

    public function actionUpdatecifpemby($id)
    {

        $model = $this->findModellong($id);
        $model->scenario = "create_updatepb";
        $model->bmpk_violation = 'N';
        $model->bmpk_exceeding = 'N';
        $model->income_type = 'Fixed Income';
        $model->domicile = 'ID';

        if (strpos($model->net_asset, ",") > 0)
        {
            $model->net_asset = str_replace(',', '', $model->net_asset);
        }
        if (strpos($model->annual_sale, ",") > 0)
        {
            $model->annual_sale = str_replace(',', '', $model->annual_sale);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {

            $newData = Yii::$app->request->post('Longcif');
            $newData['short_name'] = strtoupper($newData['short_name']);
            $newData['place_birth'] = strtoupper($newData['place_birth']);
            $newData['moth_maiden'] = strtoupper($newData['moth_maiden']);
            $newData['street'] = strtoupper($newData['street']);
            $newData['address'] = strtoupper($newData['address']);
            $newData['town_country'] = strtoupper($newData['town_country']);
            $newData['country'] = strtoupper($newData['country']);
            //$newData['birth_incorp_date'] = date('Y-m-d', strtotime($newData['birth_incorp_date']));

            $oldData = \app\models\Longcif::filterUpdatableData($this->findModellong($id)->getAttributes(), $newData);
            $detailUpdate = \app\models\Longcif::createUpdateDetail($oldData, $newData);

            $process = \app\models\Longcif::inputUpdateCIFPemby($id, $detailUpdate);

            $session = Yii::$app->session;

            if ($process['status'] == WsclientLog::STATOK)
            {
                $session->setFlash('saveUpdateOK', '<div class="alert alert-success">' . $process['msg'] . '</div>');
                return $this->redirect(['displaycifpembydatadiff', 'idlogupdate' => $process['idlogupdate']]);
            }
            else
            {
                $session->setFlash('saveUpdateFailed', '<div class="alert alert-danger">' . $process['msg'] . '</div>');
            }
        }
        return $this->render('cifpemby_update', ['model' => $model]);
    }

    public function actionUpdatecifpembysearch()
    {

        $request = Yii::$app->request;
        $session = Yii::$app->session;

        $model = new \app\models\Longcif(['scenario' => 'tampil']);


        if ($model->load($request->post()))
        {

            //mencari data dari T24 dulu.
            $process = \app\models\Longcif::bacalongCIFT24($model->id);

            //Pencarian data CIF pada T24.
            $data = array();
            try {
                if ($process['status'] == WsclientLog::STATOK)
                {
                    //var_dump($process['status']);die();
                    $model = \app\models\Longcif::findOne($model->id);

                    $data = json_decode($process['msgresp']);

                    $id = $data->params->cifinfo->contents->c1;
                    $short_name = $data->params->cifinfo->contents->c2;
                    $address = $data->params->cifinfo->contents->c3;
                    $district_code = $data->params->cifinfo->contents->c4;
                    $cust_type = $data->params->cifinfo->contents->c5;
                    $company_book = $data->params->cifinfo->contents->c6;
                    $status = $data->params->cifinfo->contents->c7;
                }
                else
                {
                    $session->setFlash("msgnotfound", "<div class='alert alert-danger'>" . $process['msg'] . "</div>");
                }
            } catch (\Exception $e) {
                $msgerr = $e->getMessage();
                $logmodel->error_msg = $msgerr;
                $logmodel->status = WsclientLog::STATERR;
            }

            //Memeriksa state dari CIF, Apakah sedang aktif (ACTIVE)
            if ($model->local_state == \app\models\Longcif::STATE_ACTIVE)
            {
                $session->setFlash("ciffound", "OK");
                $session->setFlash("msgfound", "<div class='alert alert-success'>" . $process['msg'] . "</div>");
            }
            //Memeriksa state dari CIF, Apakah sedang dalam otorisasi (UPDATING_NAU)
            if ($model['local_state'] == \app\models\Longcif::STATE_UPDATING_NAU)
            {
                $process['msg'] = "Perubahan CIF sebelumnya belum di otorisasi, lakukan otorisasi terlebih dahulu !";
                $session->setFlash("msgupdating", "<div class='alert alert-danger'>" . $process['msg'] . "</div>");
            }
        }

        return $this->render('cifpemby_search_update', ['model' => $model]);
    }

    public function actionUpdatecifsimpelsearch()
    {

        $request = Yii::$app->request;
        $session = Yii::$app->session;

        $model = new \app\models\Longcif(['scenario' => 'tampil']);


        if ($model->load($request->post()))
        {

            //mencari data dari T24 dulu.
            $process = \app\models\Longcif::bacalongCIFT24($model->id);

            //Pencarian data CIF pada T24.
            $data = array();
            try {
                if ($process['status'] == WsclientLog::STATOK)
                {
                    //var_dump($process['status']);die();
                    $model = \app\models\Longcif::findOne($model->id);

                    $data = json_decode($process['msgresp']);

                    $id = $data->params->cifinfo->contents->c0;
                    $short_name = $data->params->cifinfo->contents->c1;
                    $address = $data->params->cifinfo->contents->c2;
                    $district_code = $data->params->cifinfo->contents->c3;
                    $cust_type = $data->params->cifinfo->contents->c4;
                    $company_book = $data->params->cifinfo->contents->c5;
                    $status = $data->params->cifinfo->contents->c6;
                }
                else
                {
                    $session->setFlash("msgnotfound", "<div class='alert alert-danger'>" . $process['msg'] . "</div>");
                }
            } catch (\Exception $e) {
                $msgerr = $e->getMessage();
                $logmodel->error_msg = $msgerr;
                $logmodel->status = WsclientLog::STATERR;
            }

            //Memeriksa state dari CIF, Apakah sedang aktif (ACTIVE)
            //var_dump($model['local_state']);die();
            if ($model->local_state == \app\models\Longcif::STATE_ACTIVE)
            {
                $session->setFlash("ciffound", "OK");
                $session->setFlash("msgfound", "<div class='alert alert-success'>" . $process['msg'] . "</div>");
            }
            //Memeriksa state dari CIF, Apakah sedang dalam otorisasi (UPDATING_NAU)
            if ($model['local_state'] == \app\models\Longcif::STATE_UPDATING_NAU)
            {
                $process['msg'] = "Perubahan CIF sebelumnya belum di otorisasi, lakukan otorisasi terlebih dahulu !";
                $session->setFlash("msgupdating", "<div class='alert alert-danger'>" . $process['msg'] . "</div>");
            }
        }

        return $this->render('cifsimpel_search_update', ['model' => $model]);
    }

    public function actionUpdatecifsimpel($id)
    {

        $model = $this->findModellong($id);
        $model->scenario = "create_updatesp";
        $model->xbrl_lbus = '9000';

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {

            $newData = Yii::$app->request->post('Longcif');
            $newData['short_name'] = strtoupper($newData['short_name']);
            $newData['place_birth'] = strtoupper($newData['place_birth']);
            $newData['moth_maiden'] = strtoupper($newData['moth_maiden']);
            $newData['street'] = strtoupper($newData['street']);
            $newData['address'] = strtoupper($newData['address']);
            $newData['town_country'] = strtoupper($newData['town_country']);
            $newData['country'] = strtoupper($newData['country']);
            //$newData['birth_incorp_date'] = date('Y-m-d', strtotime($newData['birth_incorp_date']));

            $oldData = \app\models\Longcif::filterUpdatableData($this->findModellong($id)->getAttributes(), $newData);
            $detailUpdate = \app\models\Longcif::createUpdateDetail($oldData, $newData);

            $process = \app\models\Longcif::inputUpdateCIFSimpel($id, $detailUpdate);

            $session = Yii::$app->session;

            if ($process['status'] == WsclientLog::STATOK)
            {
                $session->setFlash('saveUpdateOK', '<div class="alert alert-success">' . $process['msg'] . '</div>');
                return $this->redirect(['displaycifsimpeldatadiff', 'idlogupdate' => $process['idlogupdate']]);
            }
            else
            {
                $session->setFlash('saveUpdateFailed', '<div class="alert alert-danger">' . $process['msg'] . '</div>');
            }
        }
        return $this->render('cifsimpel_update', ['model' => $model]);
    }

    public function actionCreatecifbadan()
    {

        $session = Yii::$app->session;

        $model = new Customercorp(['scenario' => 'create_update']);
        $model->nationality = "ID";
        $model->reside_y_n = "Y";
        $model->same_as_resadd = "N";
        $model->contact_date = date("Y-m-d");
        $model->birth_incorp_date = date("Y-m-d", strtotime($model->birth_incorp_date));
        $model->account_officer = "9300"; //account_officer di syiar, untuk customer corp di set 9300.
        $model->company_book = Yii::$app->user->identity->branch_cd;
        $model->contact_date = date("Y-m-d");
        $model->taxable = "Y";
        $model->target = "9999";


        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {

            //membuat inputan menjadi huruf kapital
            $model->rt_rw = strtoupper($model->rt_rw);
            $model->short_name = strtoupper($model->short_name);
            $model->legal_id = strtoupper($model->legal_id);
            $model->legal_id_no = strtoupper($model->legal_id_no);
            $model->tax_reg_no = strtoupper($model->tax_reg_no);
            $model->street = strtoupper($model->street);
            $model->address = strtoupper($model->address);
            $model->town_country = strtoupper($model->town_country);
            $model->country = strtoupper($model->country);
            $model->introducer = strtoupper($model->introducer);
            $model->oth_acc_open_pr = strtoupper($model->oth_acc_open_pr);
            $model->oth_fund_source = strtoupper($model->oth_fund_source);

            //field local syiarexpress
            $model->local_created_date = date("Y-m-d");
            $model->local_inputter = Yii::$app->user->identity->id;
            $model->local_origin = Customer::ORIGIN_SYIAREX;
            $model->local_customer_type = Customer::CUST_TYPE_BADAN;
            $model->local_state = Customer::STATE_ACTIVE;
            
            $process = $model->bukaCIFbadanT24();
            if ($process['status'] == WsclientLog::STATOK)
            {

                $session->setFlash('state', 'onestop');
                $session->setFlash('createCIFSuccess', '<div class="alert alert-success">' . $process['msg'] . '</div>');
//                return $this->redirect([
//                            'account/redirect',
//                           'cifcorp_create',
//                            'cif_no' => $model->id,
//                            'account_title' => $model->short_name,
//                            'short_title' => $model->short_name
                return $this->render('cifcorp_success', ['model' => $model]);
            }
            else
            {
                $session->setFlash('createCIFFailed', '<div class="alert alert-danger">' . $process['msg'] . '</div>');
            }
        }

        return $this->render('cifcorp_create', ['model' => $model]);
    }

    public function actionCreatecifsimpel()
    {

        $session = Yii::$app->session;

        $model = new \app\models\Longcif(['scenario' => 'create_simpelcif']);
        $model->nationality = "ID";
        $model->reside_y_n = "Y";
        $model->same_as_resadd = "N";
        $model->contact_date = date("Y-m-d");
        $model->birth_incorp_date = date("Y-m-d", strtotime($model->birth_incorp_date));
        $model->account_officer = "9300"; //account_officer di syiar, untuk customer corp di set 9300.
        $model->company_book = Yii::$app->user->identity->branch_cd;
        $model->contact_date = date("Y-m-d");
        $model->taxable = "Y";
        $model->target = "9999";


        if ($model->load(Yii::$app->request->post()))
        {

            //membuat inputan menjadi huruf kapital
            $model->rt_rw = strtoupper($model->rt_rw);
            $model->short_name = strtoupper($model->short_name);
            $model->legal_id_no = strtoupper($model->legal_id_no);
            $model->street = strtoupper($model->street);
            $model->address = strtoupper($model->address);
            $model->town_country = strtoupper($model->town_country);
            $model->country = strtoupper($model->country);

            //field local syiarexpress
            $model->local_created_date = date("Y-m-d");
            $model->local_inputter = Yii::$app->user->identity->id;
            $model->local_origin = Customer::ORIGIN_SYIAREX;
            $model->local_customer_type = Customer::CUST_TYPE_INDIVIDU;
            $model->local_state = Customer::STATE_ACTIVE;

            $process = $model->bukaCIFsimpel();
            if ($process['status'] == WsclientLog::STATOK)
            {

                $session->setFlash('state', 'onestop');
                $session->setFlash('createCIFSuccess', '<div class="alert alert-success">' . $process['msg'] . '</div>');
//                return $this->redirect([
//                            'account/redirect',
//                           'cifcorp_create',
//                            'cif_no' => $model->id,
//                            'account_title' => $model->short_name,
//                            'short_title' => $model->short_name
                return $this->render('cifsimpel_success', ['model' => $model]);
            }
            else
            {
                $session->setFlash('createCIFFailed', '<div class="alert alert-danger">' . $process['msg'] . '</div>');
            }
        }

        return $this->render('cifsimpel_create', ['model' => $model]);
    }

    public function actionGetLokalT24()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $cust = new Customer();
        $msgresp = json_encode($cust->getLokalT24($id));
        return $msgresp;
    }

}
