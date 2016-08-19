<?php

/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 5/3/16
 * Time: 3:35 PM
 */

require_once  APPPATH.'third_party/twitteroauth/autoload.php';


use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY', 'frgOCGgw6NjIsp3Ao3XsWqiDP');
define('CONSUMER_SECRET', 'WbUSH7qEYUK04I9qh0cCQYNF79Xgwlwpdf57RP2Z6mTomsNeTv');
define('OAUTH_CALLBACK', 'http://dashboard.digitalglare.com.au/twitter/callBack');


class Twitter extends CI_Controller
{
    public function __construct()
    {


        parent::__construct();
        $this->load->model('twitterdata_model');

        //Live
        //$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

    }


    public function accounts()
    {
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);


        $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));



        $dataInsert = array(
            'user_id'=>$_SESSION['id'],
            'oauth_token'=>$request_token['oauth_token'],
            'oauth_token_secret'=> $request_token['oauth_token_secret'],
        );


        $this->twitterdata_model->add_temp_session($dataInsert);


        $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));


        $getTwitterAccount =  $this->twitterdata_model->getAccountList($_SESSION['id']);

        $data = array(
            'page'=>'auth',
            'url' => $url  ,
            'selectAccount'=> $getTwitterAccount
        );

        $this->load->view('header',$data);
        $this->load->view('twitter/authProfile');
        $this->load->view('footer');


    }

    public function callBack()
    {

        $request_token = [];

       $toke_data =  $this->twitterdata_model->get_temp_session($_SESSION['id']);


        if (isset($_REQUEST['oauth_token']) && $toke_data->oauth_token !== $_REQUEST['oauth_token']) {
            // Abort! Something is wrong.
            redirect(base_url().'twitter/accounts');
        }


        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET,$toke_data->oauth_token,$toke_data->oauth_token_secret);

        $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);


        $updateData = array(

            'twitter_id'=> $access_token['user_id'],
            'twitter_name'=> $access_token['screen_name'],
            'oauth_token'=> $access_token['oauth_token'],
            'oauth_token_secret'=> $access_token['oauth_token_secret'],
            'status'=>1

        );

        $this->twitterdata_model->add_new_Twitter($_SESSION['id'],$updateData);


        $this->twitterdata_model->deleteTemp($_SESSION['id']);





        redirect(base_url().'twitter/accounts');


    }

    public function dashboard()
    {

       $twitterData = $this->twitterdata_model->getTwitterAccount($_SESSION['id']);


       foreach($twitterData as $item){
           $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $item->oauth_token, $item->oauth_token_secret);

           $query = array(
               "q" => "@Google",
               'until'=>'2016-01-30',

           );

           $content = $connection->get("account/verify_credentials");


           $twitterRecord[] = array(
               'screen_name' => $content->screen_name,
               'followers_count' => $content->followers_count,
               'friends_count' => $content->friends_count,
               'favourites_count' => $content->favourites_count,
               'statuses_count' => $content->statuses_count,
           );
       }


        $data = array(

            'controller'=>'Twitter',
            'page'=>'Dashboard',
            'twitter'=> array(
                'twitterRecord'=>$twitterRecord,
                'sub'=> 'twitter'
            )
        );



        $this->load->view('header',$data);
        $this->load->view('twitter/dashboard');
        $this->load->view('footer');


    }

    public function deleteAccount($id)
    {
        $listAdded =  $this->twitterdata_model->delete($id,$_SESSION['id']);

        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/twitter/accounts';
        header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        exit;

    }





}