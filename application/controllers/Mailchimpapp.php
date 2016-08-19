<?php

/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 7/11/16
 * Time: 12:18 PM
 */

require_once APPPATH.'third_party/mailchimp/MailChimp.php';

use \DrewM\MailChimp\MailChimp;

class Mailchimpapp extends CI_Controller
{
    private $api_key;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mailchimp_model');

    }

    public function list_forms()
    {

        $this->form_validation->set_rules('api_key', 'API Key', 'required');

        if ($this->form_validation->run() === false) {

            $data['error'] = validation_errors();

        }else {

            if ($this->input->post()) {

                $api_key = $this->input->post('api_key');


                $profData = array(
                    'api_key' => $api_key,
                    'status' => 1,
                );

                $result = $this->mailchimp_model->create_mailchimp_list($_SESSION['id'], $profData);

                if ($result['error'] == 0) {
                    if ($result['response']) {
                        $data['error_message'] = "Page Successfully Added";
                        $data['error_response'] = "1";
                    } else {
                        $data['error_message'] = "Something went wrong, Try again";
                        $data['error_response'] = "0";
                    }

                } elseif ($result['error'] == 1) {
                    $data['error_message'] = "Page already added";
                    $data['error_response'] = "0";
                }

            }
        }

        $listAdded =  $this->mailchimp_model->getList($_SESSION['id']);



        $data['list']= $listAdded;
        $data['page']= 'MailChimp';

        $this->load->view('header');
        $this->load->view('mailchimp/save',$data);
        $this->load->view('footer',$data);


    }

    public function campaign_list($id)
    {

        $listAdded =  $this->mailchimp_model->getAPI($_SESSION['id']);

        $mailchim = new MailChimp($listAdded->api_key);

        $result = $mailchim->get('campaigns');


        $data = array(
           'list'=> $result['campaigns'],
            'page'=> 'MailChimp'
        );


        $this->load->view('header',$data);
        $this->load->view('mailchimp/campaign');
        $this->load->view('footer');


    }

    public function view_campaign_report($id)
    {

        $listAdded =  $this->mailchimp_model->getAPI($_SESSION['id']);

        $mailchim = new MailChimp($listAdded->api_key);


        $result = $mailchim->get('campaigns/'.$id);

        $report = $mailchim->get('reports/'.$id);

        $data = array(
            'list'=> $result,
            'report'=> $report,
            'page'=> 'MailChimp'
        );


        $this->load->view('header',$data);
        $this->load->view('mailchimp/report');
        $this->load->view('footer');

    }

    public function delete_list($id)
    {

        $listAdded =  $this->mailchimp_model->delete($id,$_SESSION['id']);

        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/mailchimpapp/list_forms';
        header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        exit;



    }



}