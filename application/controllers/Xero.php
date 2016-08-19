<?php

/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 7/18/16
 * Time: 12:00 PM
 */
require_once  APPPATH.'third_party/xero-lib/XeroOAuth.php';


define("XRO_APP_TYPE", "Private");
define("OAUTH_CALLBACK", "oob");

class Xero extends CI_Controller
{
    private $useragent = "XeroOAuth-PHP Private App Test";
    private $credintials = array();
    private $XeroOAuth ;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('xero_model');

       $cred_value =  $this->xero_model->get_credential($_SESSION['id']);

        if(!empty($cred_value)){

            $signatures = array(
                'consumer_key' => $cred_value->consumer_key,
                'shared_secret' => $cred_value->shared_secret,
                // API versions
                'core_version' => '2.0',
                'payroll_version' => '1.0',
                'file_version' => '1.0'
            );

            $signatures ['rsa_private_key'] =  APPPATH.'/uploads/'.$_SESSION['id'] .'.pem';
            $signatures ['rsa_public_key'] =  APPPATH.'/uploads/'.$_SESSION['id'] .'.cer';


            $this->XeroOAuth = new XeroOAuth (array_merge(array(
                'application_type' => XRO_APP_TYPE,
                'oauth_callback' => OAUTH_CALLBACK,
                'user_agent' => $this->useragent
            ), $signatures));

            $initialCheck = $this->XeroOAuth->diagnostics();

            if (count($initialCheck) > 0) {
                // you could handle any config errors here, or keep on truckin if you like to live dangerously
                foreach ($initialCheck as $check) {
                    echo 'Error: ' . $check . PHP_EOL;
                }
            }else {
                $this->credintials =  array(
                    'oauth_token' => $this->XeroOAuth->config ['consumer_key'],
                    'oauth_token_secret' => $this->XeroOAuth->config ['shared_secret'],
                    'oauth_session_handle' => ''
                );
            }

        }

    }

    public function addaccount()
    {

        $data = array();

        $this->form_validation->set_rules('consumer_key', 'Consumer Key', 'required');
        $this->form_validation->set_rules('shared_secret', 'Shared Secret', 'required');
        //$this->form_validation->set_rules('userpem', '(.pem) File', 'required');
        //$this->form_validation->set_rules('uercer', '(.cer) File', 'required');



        $cred_value =  $this->xero_model->get_credential($_SESSION['id']);
        $data['account'] =   $cred_value;

        if($cred_value){
            $this->XeroOAuth->config['access_token'] = $this->credintials['oauth_token'];
            $this->XeroOAuth->config['access_token_secret'] = $this->credintials['oauth_token_secret'];

            $response = $this->XeroOAuth->request('GET',$this->XeroOAuth->url('Organisation', 'core'), array('page' => 0));
            if ($this->XeroOAuth->response['code'] == 200) {
                $organisation = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);

                $data['acc_name'] = $organisation->Organisations->Organisation->Name;
            }



        }else{
            $data['account'] = "";
        }


        if ($this->input->post()) {

            $consumer_key = $this->input->post('consumer_key');
            $shared_secret = $this->input->post('shared_secret');

            if ($this->form_validation->run() === false) {

                echo 'error';
            } else {
                $uploadError = 0;

                $config['upload_path'] =  APPPATH.'/uploads/';

                $config['file_name'] = $_SESSION['id'];

                $config['overwrite'] = TRUE;

                $this->load->library('upload', $config);

                $this->upload->initialize($config);

                $this->upload->set_allowed_types('*');

                $data['upload_data'] = '';


                //if not successful, set the error message
                if (!$this->upload->do_upload('userpem')) {
                    $data = array('msg' => $this->upload->display_errors());
                    var_dump($this->upload->display_errors());
                    $uploadError = 0;

                } else { //else, set the success message
                    $data = array('msg' => "Upload success!");
                    $data['upload_data'] = $this->upload->data();
                    $uploadError = 1;
                }


                if (!$this->upload->do_upload('uercer')) {
                    $data = array('msg' => $this->upload->display_errors());
                    var_dump($this->upload->display_errors());
                    $uploadError = 0;
                } else { //else, set the success message
                    $data = array('msg' => "Upload success!");
                    $data['upload_data'] = $this->upload->data();
                    $uploadError = 1;
                }

                if ($uploadError == 1) {

                    $pageData = array(
                        'user_id' => $_SESSION['id'],
                        'consumer_key' => $consumer_key,
                        'shared_secret' => $shared_secret,
                        'status' => '1',
                    );

                    $this->xero_model->add_xero_account($_SESSION['id'], $pageData);
                }


            }

        }


        $this->load->view('header');
        $this->load->view('xero/addAccount', $data);
        $this->load->view('footer', $data);

    }

    public function set_account_type()
    {
        $sales = array();
        $expense = array();

        $cred_value =  $this->xero_model->getAccount($_SESSION['id']);
        if($this->credintials){

            $this->XeroOAuth->config['access_token'] =$this->credintials['oauth_token'];
            $this->XeroOAuth->config['access_token_secret'] = $this->credintials['oauth_token_secret'];
//$XeroOAuth->config['session_handle'] = $oauthSession['oauth_session_handle'];


//if (isset($_REQUEST['accounts']))  {
            //$response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('Accounts', 'core'), array('Where' => $_REQUEST['where']));
            $response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('Accounts', 'core'));
            if ($this->XeroOAuth->response['code'] == 200) {
                $accounts = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
                //echo "There are " . count($accounts->Accounts[0]). " accounts in this Xero organisation, the first one is: </br>";

                //var_dump($accounts->Accounts->Accounts);



                foreach ($accounts->Accounts->Account as $item) {

                    if($item->Type=="SALES" || $item->Type=="REVENUE"|| $item->Type=="Other Income" ){
                        $sales[] = $item;
                    }elseif($item->Type=="EXPENSE" || $item->Type=="DIRECT COSTS" || $item->Type=="Overhead"|| $item->Type=="Depreciation" ){
                        $expense[] = $item;
                    }
                }

            } else {
                $this->outputError($this->XeroOAuth);
                echo 'error';
            }

        }



        if ($this->input->post()) {

            $sales_id_list = $this->input->post('sales_id');
            $sales_name_list = $this->input->post('sales_name');

            $expenses_id_list = $this->input->post('expenses_id');
            $expenses_name_list = $this->input->post('expenses_name');

            foreach($sales_id_list as $row => $value){


                if(!$value==0){
                    $account_id = $value;
                    $account_name = $sales_name_list[$row];

                    $accountID = explode("_",$account_id);


                    $insertData = array(
                        'account_id'=>$accountID[0],
                        'account_code'=>$accountID[1],
                        'account_name'=>$account_name,
                        'type'=>'SALES',
                        'status'=>1,
                    );


                    $result =  $this->xero_model->insertCode($insertData);
                }




            }

            foreach($expenses_id_list as $row => $value){

                if(!$value==0){
                $account_id = $value;
                $account_name = $expenses_name_list[$row];

                $accountID = explode("_",$account_id);


                $insertData = array(
                    'account_id'=>$accountID[0],
                    'account_code'=>$accountID[1],
                    'account_name'=>$account_name,
                    'type'=>'EXPENSE',
                    'status'=>1,
                );


                $result =  $this->xero_model->insertCode($insertData);

                }

            }



        }

        $data = array(

            'sales'=>$sales,
            'expense'=>$expense,
            'accounts'=>$cred_value,
            'page'=>'Xero',

        );

        $this->load->view('header');
        $this->load->view('xero/set_account', $data);
        $this->load->view('footer', $data);

    }


   public function outputError($XeroOAuth)
    {
        echo 'Error: ' . $XeroOAuth->response['response'] . PHP_EOL;
        pr($XeroOAuth);
    }

    public function index()
    {

        $cred_value =  $this->xero_model->getAccount($_SESSION['id']);

        $account_codes = array();
        $acc_types = array();


        $row_id = 0;

        foreach($cred_value as  $row){

            $account_codes[$row_id]['code'] = $row->account_code;
            $account_codes[$row_id]['name'] = $row->account_name;
            $account_codes[$row_id]['amount'] = 0.0;
            $account_codes[$row_id]['type'] =$row->type;

            if (!in_array($row->type, $acc_types)) {
                $acc_types[]=$row->type;
            }

            $row_id++;
        }

        $this->form_validation->set_rules('start', 'Start', 'required');
        $this->form_validation->set_rules('end', 'End', 'required');

        if ($this->form_validation->run() === false) {

            $start=date('Y, m, d', strtotime('-6 months'));;
            $end= date('Y, m, d');

        } else {

            $start = date('Y, m, d', strtotime($this->input->post('start')));
            $end = date('Y, m, d', strtotime($this->input->post('end'))); ;
        }




        if($this->credintials) {

            $this->XeroOAuth->config['access_token'] = $this->credintials['oauth_token'];
            $this->XeroOAuth->config['access_token_secret'] = $this->credintials['oauth_token_secret'];

            $response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('Invoices', 'core'), array('page'=>'1','where'=>'Date >= DateTime('.$start.') && Date < DateTime('.$end.')'));
            if ($this->XeroOAuth->response['code'] == 200) {
                $invoices = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);

                foreach($invoices->Invoices->Invoice as $item){

                    if( $item->Status!="VOIDED" && $item->Status!="DELETED" ){


                        foreach($item->LineItems->LineItem as $row){

                            //  var_dump($item);

                            foreach($account_codes as $key => $aCode){

                                if($aCode['code'] == $row->AccountCode ){

                                    (float) $account_codes[$key]['amount'] = (float) $account_codes[$key]['amount']  + (float) $row->LineAmount;

                                }
                            }
                        }

                    }
                }
            } else {
                outputError($this->XeroOAuth);
            }

        }

        $new_list = array();

        foreach($account_codes as $row){

            foreach($acc_types as $key => $value){

                if($value==$row['type']){

                    $new_list[$key]['type']=$value;
                    $new_list[$key]['code'][]=$row['code'];
                    if(empty($row['name']))
                        $new_list[$key]['name'][]=$row['code'];
                    else
                        $new_list[$key]['name'][]=$row['name'];

                    $new_list[$key]['amount'][]=$row['amount'];
                }

            }

        }

        $data = array(
            'account_data'=> $new_list,
            'page'=> 'Xero_Index',
        );

        $this->load->view('header');
        $this->load->view('xero/dashboard', $data);
        $this->load->view('footer', $data);



    }







}