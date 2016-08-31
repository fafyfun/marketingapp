<?php

/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 4/12/16
 * Time: 10:58 AM
 */

require_once  APPPATH.'third_party/facebook/autoload.php';

class Facebook extends CI_Controller
{

    private $fb;

    public function __construct()
    {

        parent::__construct();
        $this->load->model('facebookdata_model');

        //Live

       $this->fb = new Facebook\Facebook([
            'app_id' => '578281415664110',
            'app_secret' => '1004aed9b66c6d11f5e8b0dd1bc0f5ba',
            'default_graph_version' => 'v2.5',
        ]);

        //test
/*        $this->fb = new Facebook\Facebook([
            'app_id' => '613008685524716',
            'app_secret' => '97c8b5656a59ae20af3f9b35db2a2550',
            'default_graph_version' => 'v2.5',
        ]);*/


    }

    public function geturl()
    {


     }

    public function fbCallback()
    {
        foreach ($_COOKIE as $k=>$v) {
            if(strpos($k, "FBRLH_")!==FALSE) {
                $_SESSION[$k]=$v;
            }
        }

        $helper = $this->fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        $fb_access_code =  $accessToken->getValue();

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $this->fb->getOAuth2Client();


        if (! $accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($fb_access_code);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
                exit;
            }
        }


        $_SESSION['fb_access_code'] = $accessToken->getValue();

        $this->facebookdata_model->create_facebook_access($_SESSION['id'],$_SESSION['fb_access_code']);

        header('Location:'.base_url().'facebook/selectProfile');

    }

    public function selectProfile()
    {

        $data = array();

        $codeSet =$this->facebookdata_model->getFBAccessCode($_SESSION['id']);




        if(empty($codeSet)){


            $helper = $this->fb->getRedirectLoginHelper();

            $permissions = ["email,manage_pages,read_insights"]; // Optional permissions
            $loginUrl = $helper->getLoginUrl(base_url().'facebook/fbCallback', $permissions);

            foreach ($_SESSION as $k=>$v) {
                if(strpos($k, "FBRLH_")!==FALSE) {
                    if(!setcookie($k, $v)) {
                        //what??
                    } else {
                        $_COOKIE[$k]=$v;
                    }
                }
            }


            $data = array(

                'link'=> htmlspecialchars($loginUrl),
                'page'=>'selectProfile',

            );

        }else{

            try {
                // Returns a `Facebook\FacebookResponse` object
                $response = $this->fb->get('/me?fields=id,name,accounts', $codeSet->accessToken);
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            $graphObject = $response->getDecodedBody();


            $pages = $graphObject['accounts']['data'];

            $data = array(
                'page'=>'selectProfile',
                'pages' => $pages  ,
            );

            if ($this->input->post()){

                $pageId =  $this->input->post('page');

                foreach($pages as $row){



                    if($row['id']==$pageId){

                        $pageData =  array(
                            'user_id'      => $_SESSION['id'],
                            'page_name'      => $row['name'],
                            'page_access'   => $row['access_token'],
                            'page_id' => $row['id'],
                            'status' =>'1',
                        );

                        $result =  $this->facebookdata_model->create_facebook_page($_SESSION['id'],$pageData);

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

            }

        }


        $data['facebookPages'] =   $this->facebookdata_model->getfacebookpagelist($_SESSION['id']);

        $data['breadcrumb'] = array(

            'icon'=> 'fa-facebook',
            'head_url'=>'/facebook/dashboard',
            'title'=> 'Facebook Analytics',
            'sub'=>'Add Page',
            'date'=> 0
        );


        $this->load->view('header',$data);
        $this->load->view('facebook/selectprofile');
        $this->load->view('footer');
    }

    public function dashboard()
    {
        $this->form_validation->set_rules('start', 'Start', 'required');
        $this->form_validation->set_rules('end', 'End', 'required');


        if ($this->form_validation->run() === false) {

            $start=date('Y-m-d', strtotime('-30 days'));;
            $end= date('Y-m-d');

            $showStart = date('d-m-Y', strtotime('-30 days'));
            $showEnd = date('d-m-Y');

        } else {

            $start = $this->input->post('start');
            $end = $this->input->post('end');


            $showStart = $this->input->post('start');
            $showEnd = $this->input->post('end');
        }


        $pageDetailsDB =  $this->facebookdata_model->getfacebookpage($_SESSION['id']);


        $fbDashboardRecords = array();
        $numOfProfile = 0;


        foreach ($pageDetailsDB as $item) {

            try {
                // Returns a `Facebook\FacebookResponse` object
                //$response = $this->fb->get('/me?fields=id,name,accounts', $_SESSION['fb_access_code']);
                //since=2011-07-01&until=2012-08-08&

                $fbReachlist = $this->fb->get('/'.$item->page_id.'/insights/page_impressions_unique/day?since='.$start.'&until='.$end, $item->page_access);
                $fbLikelist = $this->fb->get('/'.$item->page_id.'/insights/page_fans?since='.$start.'&until='.$end, $item->page_access);
                $fbReport = $this->fb->get('/'.$item->page_id.'/insights/page_consumptions_unique,page_views_total/day?since='.$start.'&until='.$end, $item->page_access);
                $fbLike = $this->fb->get('/'.$item->page_id.'/insights/page_fans?since='.$start.'&until='.$end, $item->page_access);
                // $response = $fb->get('/180239072010753/posts', 'CAAIN8aJcYe4BAHZBvjgoZCe7kMJCe1Wu3U2D752aO8IJ8hFMrgCWcIR3XScK5yYxcG21vNkL3KKAICV8HlOp6AXp7YnUHXKuNZA8Nx8c2leZAvUbZALUjgpzagoZC0u78kBhAOjkqtafHDaZAkVZAWZByiL50FXbY3wvs7dzwqJBXAV8DYwg64sdGgiLKces496X1O4jUzXRaDQZDZD');

            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            $reachlist = $fbReachlist->getDecodedBody();
            $likelist = $fbLikelist->getDecodedBody();
            $fbDashReport = $fbReport->getDecodedBody();
            $fbDashLike = $fbLike->getDecodedBody();

            /*       echo '<pre>';
        print_r($fbReport);*/


            $totalLikes = $fbDashLike['data'][0]['values']['2']['value'];
            $page_engaged_users = 0;
            $page_views_total = 0;

            //print_r($reachlist['data'][0]['values']);
            // print_r($likelist['data'][0]['values']);

            $reachTableList = array();
            $dateRange = array();
            $likeTableList = array();
            $totalReach=0;

            foreach ($reachlist['data'][0]['values'] as $row){

                $dateMonth = new DateTime($row['end_time']);
                $dateDimeStamp= $dateMonth->getTimestamp();

                $reachTableList[] =array($dateDimeStamp*1000,$row['value']);

                $totalReach = $totalReach+$row['value'];

            }

            foreach ($likelist['data'][0]['values'] as $row){

                $dateMonth = new DateTime($row['end_time']);
                $dateDimeStamp= $dateMonth->getTimestamp();


                $likeTableList[] =array($dateDimeStamp*1000,$row['value']);

            }

            foreach ($fbDashReport['data'][0]['values'] as $row){

                $page_engaged_users = $page_engaged_users+$row['value'];

            }

            foreach ($fbDashReport['data'][1]['values'] as $row){

                $page_views_total = $page_views_total+$row['value'];

            }

            $fbDashboardRecords[$numOfProfile] = array(
                'profileName'=>$item->page_name,
                'profileId'=>$item->page_id,
                'totalReach'=>$totalReach,
                'totalLike'=>$totalLikes,
                //'valueRange'=>json_encode($dateRange),
                'like'=>json_encode($likeTableList),
                'reach'=>json_encode($reachTableList),
                'page_engaged_users' => $page_engaged_users,
                'page_views_total' => $page_views_total,


            );

            $numOfProfile ++;


        }


/*        var_dump(json_encode($reachTableList));
        var_dump(json_encode($likeTableList));
        var_dump(json_encode($dateRange));*/

        $data = array(

            'controller'=>'Facebook',
            'page'=>'Dashboard',
            'showStart' => $showStart,
            'showEnd' => $showEnd,
            'fb'=> array(
                'fbDashboardRecords'=>$fbDashboardRecords,
                'sub'=> 'FB'
            )
        );

        $data['breadcrumb'] = array(

            'icon'=> 'fa-facebook',
            'head_url'=>'',
            'title'=> 'Facebook Analytics',
            'sub'=>'',
            'date'=> 1
        );


        $this->load->view('header',$data);
        $this->load->view('facebook/dashboard');
        $this->load->view('footer');

    }


    public function details($profileId)
    {





        $this->form_validation->set_rules('start', 'Start', 'required');
        $this->form_validation->set_rules('end', 'End', 'required');


        if ($this->form_validation->run() === false) {

            $start=date('Y-m-d', strtotime('-30 days'));;
            $end= date('Y-m-d');


            $showStart = date('d-m-Y', strtotime('-30 days'));
            $showEnd = date('d-m-Y');

        } else {

            $start = $this->input->post('start');
            $end = $this->input->post('end');

            $showStart = $this->input->post('start');
            $showEnd = $this->input->post('end');
        }


        $pageDetailsDB =  $this->facebookdata_model->getacessCode($profileId,$_SESSION['id']);


        try {

            $fbReachlist = $this->fb->get('/'.$profileId.'/insights/page_impressions_unique/day?since='.$start.'&until='.$end, $pageDetailsDB->page_access);
            $fbLikelist = $this->fb->get('/'.$profileId.'/insights/page_fans?since='.$start.'&until='.$end, $pageDetailsDB->page_access);
            $fbReport = $this->fb->get('/'.$profileId.'/insights/page_consumptions_unique,page_views_total/day?since='.$start.'&until='.$end, $pageDetailsDB->page_access);
            $fbLike = $this->fb->get('/'.$profileId.'/insights/page_fans?since='.$start.'&until='.$end, $pageDetailsDB->page_access);

            $post = $this->fb->get('/'.$profileId.'/posts?limit=10', $pageDetailsDB->page_access);

        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            //echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
           // echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }





        $reachlist = $fbReachlist->getDecodedBody();
        $likelist = $fbLikelist->getDecodedBody();
        $fbDashReport = $fbReport->getDecodedBody();
        $fbDashLike = $fbLike->getDecodedBody();
        $topPost = $post->getDecodedBody();

             /*  echo '<pre>';
                print_r($topPost);*/




        $totalLikes = $fbDashLike['data'][0]['values']['2']['value'];
        $page_engaged_users = 0;
        $page_views_total = 0;


        //print_r($reachlist['data'][0]['values']);
        // print_r($likelist['data'][0]['values']);

        $reachTableList = array();
        $dateRange = array();
        $likeTableList = array();
        $totalReach=0;

        foreach ($reachlist['data'][0]['values'] as $row){

            $dateMonth = new DateTime($row['end_time']);
            $dateDimeStamp= $dateMonth->getTimestamp();

            $reachTableList[] =array($dateDimeStamp*1000,$row['value']);

            $totalReach = $totalReach+$row['value'];

        }

        foreach ($likelist['data'][0]['values'] as $row){

            $dateMonth = new DateTime($row['end_time']);
            $dateDimeStamp= $dateMonth->getTimestamp();


            $likeTableList[] =array($dateDimeStamp*1000,$row['value']);
        }


        foreach ($fbDashReport['data'][0]['values'] as $row){

            $page_engaged_users = $page_engaged_users+$row['value'];

        }

        foreach ($fbDashReport['data'][1]['values'] as $row){

            $page_views_total = $page_views_total+$row['value'];

        }


        $postArray = array();

        $i = 0;

        foreach($topPost['data'] as $row){



            $postArray[$i] = array(
                'message'=>   $row['message'],
                'time'=> $row['created_time'],
                'id'=> $row['id'],
            );

            try {

                $likesAndReach = $this->fb->get('/'.$row['id'].'/insights/post_impressions_unique,post_reactions_like_total', $pageDetailsDB->page_access);

                $likeAndReach = $likesAndReach->getDecodedBody();

                $postArray[$i]['reach'] =  $likeAndReach['data'][0]['values']['0']['value'];
                $postArray[$i]['like'] =  $likeAndReach['data'][1]['values']['0']['value'];



            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            $i++;


        }



        uasort($postArray, function($a, $b) {
            return $a['reach'] - $b['reach'];
        });


        /*      var_dump(json_encode($reachTableList));
                var_dump(json_encode($likeTableList));
                var_dump(json_encode($dateRange));*/

        $data = array(
            'profileName'=>$pageDetailsDB->page_name,
            'page'=>'Facebook',
            'totalReach'=>$totalReach,
            'totalLike'=>$totalLikes,
            'postList'=>array_reverse($postArray),
            //'valueRange'=>json_encode($dateRange),
            'like'=>json_encode($likeTableList),
            'reach'=>json_encode($reachTableList),
            'page_engaged_users' => $page_engaged_users,
            'page_views_total' => $page_views_total,
            'resultData' => $reachTableList,
            'showStart' => $showStart,
            'showEnd' => $showEnd,
        );

        $data['breadcrumb'] = array(

            'icon'=> 'fa-facebook',
            'head_url'=>'/facebook/dashboard',
            'title'=> 'Facebook Analytics',
            'sub'=>$pageDetailsDB->page_name,
            'date'=> 1
        );

        $this->load->view('header', $data);
        $this->load->view('facebook/moreDetails');
        $this->load->view('footer');

    }

    public function removeApp()
    {
        $codeSet =$this->facebookdata_model->getFBAccessCode($_SESSION['id']);

        $ret = $this->fb->delete('/me/permissions',array(),$codeSet->accessToken);


        $this->facebookdata_model->remove_access($_SESSION['id']);

        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/facebook/selectProfile';
        header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        exit;
    }


    public function deleteAction($id)
    {
        $listAdded =  $this->facebookdata_model->delete($id,$_SESSION['id']);

        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/facebook/selectProfile';
        header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        exit;

    }


}