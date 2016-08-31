<?php

/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 5/26/16
 * Time: 4:43 PM
 */

require_once  APPPATH.'third_party/vision6/api.class.php';

class Vision6 extends CI_Controller
{

    private $url = 'http://www.vision6.com.au/api/jsonrpcserver';
    private $api_key = '928e2672fde2fff9e65beccb520f10cb928f2376801d0cf3d99c82dc520f1c02';
    private $api;


    public function __construct()
    {
        parent::__construct();
        $this->load->model('visionsix_model');

        $listAdded =  $this->visionsix_model->getList($_SESSION['id']);


        if($listAdded[0]->api_key){
            $this->api = new Api($this->url, $listAdded[0]->api_key, '3.0');
        }else{
            $this->api = new Api($this->url, $this->api_key, '3.0');
        }


    }

    public function campaign_list()
    {

        $search_criteria = array();

        $batches = $this->api->invokeMethod('searchBatches', $search_criteria);

        $data = array(
            'list'=> $batches,
            'page'=> 'Vision6'
        );

        $data['breadcrumb'] = array(

            'icon'=> 'fa-envelope-o',
            'head_url'=>'',
            'title'=> 'Vision6',
            'sub'=>'',
            'date'=> 0
        );


        $this->load->view('header',$data);
        $this->load->view('vision6/campaign');
        $this->load->view('footer');



    }

    public function get_campaign_stats($id)
    {

        $statistics = $this->api->invokeMethod('getBatchStatistics', $id);


        $data = array(
            'stats'=> $statistics,
            'id'=>$id,
            'page'=> 'Campaign'
        );

        $data['breadcrumb'] = array(

            'icon'=> 'fa-envelope-o',
            'head_url'=>'/vision6/campaign_list',
            'title'=> 'Vision6',
            'sub'=>'Campaign Id: '.$id,
            'date'=> 0
        );

        $this->load->view('header',$data);
        $this->load->view('vision6/campaign_stats');
        $this->load->view('footer');


    }

    public function list_forms()
    {
        $this->form_validation->set_rules('api_key', 'API Key', 'required');
        $this->form_validation->set_rules('list_id', 'List Id', 'required');
    /*    $this->form_validation->set_rules('list_name', 'List Name', 'required');
        $this->form_validation->set_rules('folder_name', 'Folder Name', 'required');*/

        if ($this->form_validation->run() === false) {
            $data['error'] = validation_errors();
        }else{
            if ($this->input->post()){

                $api_key =  $this->input->post('api_key');
                $list_id =  $this->input->post('list_id');
                $list_name =  $this->input->post('list_name');
                $folder_name =  $this->input->post('folder_name');

                $profData =  array(
                    'api_key'      => $api_key,
                    'list_id'   => $list_id,
                    'list_name' => $list_name,
                    'folder_name' => $folder_name,
                    'status' =>1,
                );

                $result =  $this->visionsix_model->create_vision6_list($_SESSION['id'],$profData);

                if($result['error']==0){
                    if($result['response']){
                        $data['error_message']= "Page Successfully Added";
                        $data['error_response']= "1";
                    }else{
                        $data['error_message']= "Something went wrong, Try again";
                        $data['error_response']= "0";
                    }

                }elseif($result['error']==1){
                    $data['error_message']= "Page already added";
                    $data['error_response']= "0";
                }

            }

        }


        $listAdded =  $this->visionsix_model->getList($_SESSION['id']);


        $search_criteria =  array();

        foreach ($listAdded as $item){

            $search_criteria[] =  array('id', 'exactly', $item->list_id);
            $search_criteria[] =  'OR';

        }

        if(!empty($listAdded)){
            $lists = $this->api->invokeMethod('searchLists', $search_criteria, 0, 0, 'name', 'ASC');
        }


        $data['list']= $lists;
        $data['page']= 'Vision6';

        $data['breadcrumb'] = array(

            'icon'=> 'fa-envelope-o',
            'head_url'=>'/vision6/campaign_list',
            'title'=> 'Vision6',
            'sub'=>'Add List',
            'date'=> 0
        );


        $this->load->view('header',$data);
        $this->load->view('vision6/list');
        $this->load->view('footer');


    }

    public function list_contact($id){

       // $list_id = 230974;

        $contact_list = array();



        $contacts =  $this->api->invokeMethod('searchContacts', $id, array(), 0, 0, '', '');


        if(isset($_POST['optionsRadios'])){

            $_SESSION['optionsRadios'] = $_POST['optionsRadios'] ;
        }


            if ($_SESSION['optionsRadios']=='inputs'){

                foreach($contacts as $item){



                    unset($item['creation_time']);
                    unset($item['webform_id']);
                    unset($item['subscribed_via']);
                    unset($item['is_active']);
                    unset($item['last_modified_time']);
                    unset($item['is_unsubscribed']);
                    unset($item['is_bounce_deactivated']);
                    unset($item['last_message_time']);
                    unset($item['last_open_time']);
                    unset($item['last_click_time']);
                    unset($item['double_opt_in']);
                    unset($item['double_opt_in_time']);
                    unset($item['double_opt_in_time']);



                    $contact_list[] = $item;


                }
            }else{
                $contact_list = $contacts;
            }




        $data = array(
            'contacts'=> $contact_list,
            'page'=> 'Vision6'
        );

        $this->load->view('header');
        $this->load->view('vision6/contact',$data);
        $this->load->view('footer',$data);

    }

    public function account_list()
    {
        $listAdded =  $this->visionsix_model->getList($_SESSION['id']);


        $search_criteria =  array();

        foreach ($listAdded as $item){

            $search_criteria[] =  array('id', 'exactly', $item->list_id);
            $search_criteria[] =  'OR';

        }

        if(!empty($listAdded)){
            $lists = $this->api->invokeMethod('searchLists', $search_criteria, 0, 0, 'name', 'ASC');
        }


        $data['list']= $lists;
        $data['page']= 'Vision6';

        $data['breadcrumb'] = array(

            'icon'=> 'fa-envelope-o',
            'head_url'=>'/vision6/campaign_list',
            'title'=> 'Vision6',
            'sub'=>'List',
            'date'=> 0
        );


        $this->load->view('header',$data);
        $this->load->view('vision6/account_list');
        $this->load->view('footer');

    }

    public function delete_list($id)
    {

        $listAdded =  $this->visionsix_model->delete($id,$_SESSION['id']);

        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/vision6/list_forms';
        header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        exit;
    }



}