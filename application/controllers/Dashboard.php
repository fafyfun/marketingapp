<?php

/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 3/30/16
 * Time: 11:53 AM
 */

require_once APPPATH.'third_party/google-api-php-client-2.0.0-RC6/vendor/autoload.php';
require_once  APPPATH.'third_party/facebook/autoload.php';

class Dashboard extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model('googledbsave_model');

        $this->client = new Google_Client();
        $this->client->setAuthConfigFile(FCPATH.'client_secrets.json');


        $this->load->model('facebookdata_model');

        $this->fb = new Facebook\Facebook([
            'app_id' => '578281415664110',
            'app_secret' => '1004aed9b66c6d11f5e8b0dd1bc0f5ba',
            'default_graph_version' => 'v2.5',
        ]);

    }

    public function index()
    {
        $data = new stdClass();

        // validation not ok, send validation errors to the view

        $data = array();

        $data['google'] = $this->checkAuth();

        $data['fb'] = $this->getDashboard();

        $data['page'] = "Dashboard";


        $this->load->view('header');
        $this->load->view('dashboard/index', $data);
        $this->load->view('footer',$data);
    }

    public function checkAuth(){


        $client = new Google_Client();
        $client->setAuthConfigFile('client_secrets.json');
        $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

        $get_prof = $this->googledbsave_model->get_google_cred($_SESSION['id']);



        $access_token = array(
            'access_token'      => $get_prof->access_token,
            'token_type'   => $get_prof->token_type,
            'expires_in' => $get_prof->expires_in,
            'created' => $get_prof->created
        );


        $this->client->setAccessToken($access_token);

        if ( $this->client->isAccessTokenExpired()) {



            $this->client->refreshToken($get_prof->refresh_token);
            $access_token =  $this->client->getAccessToken();

            $update_token = array(

                'access_token'      => $access_token['access_token'],
                'token_type'   => $access_token['token_type'],
                'expires_in' => $access_token['expires_in'],
                'created' => $access_token['created']
            );

            $get_prof = $this->googledbsave_model->update_google_cred($_SESSION['id'],$update_token);

        }


        $getProfileId = $this->googledbsave_model->getProfile($_SESSION['id']);



        // Set the access token on the client.
        $client->setAccessToken($access_token);

        // Create an authorized analytics service object.
        $analytics = new Google_Service_Analytics($client);

        // Get the first view (profile) id for the authorized user.
        //$profile = $this->getFirstProfileId($analytics);
        //$profile = 9300436;
        // Get the results from the Core Reporting API and print the results.

        $resultData = array();

        foreach($getProfileId as $pID){

            $profile = $pID->web_id;

            $results = $this->getResults($analytics, $profile);

            $resultsSearchEngine = $this->getSearchEngine($analytics, $profile);
            $operatingSystems= $this->getDevice($analytics, $profile);
            $visitorType= $this->getVisitorType($analytics, $profile);


            $resultData[] =   $this->printResults($results,$resultsSearchEngine,$operatingSystems,$visitorType,$profile);

        }

        $data = array(
            'sub'=>"Google",
            'resultData' => $resultData
        );

        return $data;

        //$this->load->view('header');
        //$this->load->view('dashboard/index', $data);
        //$this->load->view('footer', $data);





    }

    public function getResults($analytics,$profileId)
    {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            '30daysAgo',
            'today',
            'ga:users,ga:pageviews,ga:bounceRate,ga:avgSessionDuration,ga:sessions,ga:percentNewSessions',array('dimensions'=>'ga:date'));
    }


    public function getVisitorType($analytics,$profileId)
    {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            '30daysAgo',
            'today',
            'ga:sessions',array('dimensions'=>'ga:userType'));


    }

    public function getDevice($analytics,$profileId)
    {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            '30daysAgo',
            'today',
            'ga:sessions',array('dimensions'=>'ga:operatingSystem'));
    }

    public function getSearchEngine($analytics,$profileId)
    {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            '30daysAgo',
            'today',
            'ga:exits',array('filters'=>'ga:medium==cpa,ga:medium==cpc,ga:medium==cpm,ga:medium==cpp,ga:medium==cpv,ga:medium==organic,ga:medium==ppc'));
    }

    public function getKeyWord($analytics,$profileId)
    {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            '30daysAgo',
            'today',
            'ga:sessions,ga:percentNewSessions',array('dimensions'=>'ga:keyword'));
    }

    public function getLandingPage($analytics,$profileId)
    {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            '30daysAgo',
            'today',
            'ga:sessions,ga:percentNewSessions',array('dimensions'=>'ga:landingPagePath','sort'=>'-ga:sessions','max-results'=>10));
    }

    public function getCountryList($analytics,$profileId)
    {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            '30daysAgo',
            'today',
            'ga:sessions,ga:percentNewSessions',array('dimensions'=>'ga:country','sort'=>'-ga:sessions','max-results'=>10));
    }

    public function printResults(&$results,&$resultsSearchEngine,&$operatingSystems,&$visitorType,$profile)
    {


        if(count($resultsSearchEngine->getRows()) > 0){
            $searchEngineResult = $resultsSearchEngine->getRows();
            $searchEngine = $searchEngineResult[0][0];
        }else{
            $searchEngine = 0;
        }

        if(count($visitorType->getRows()) > 0){
            $visitorResultType = $visitorType->getRows();
            $visitor = $visitorResultType;
        }else{
            $visitor = 0;
        }

        if(count($operatingSystems->getRows()) > 0){
            $deviceList = $operatingSystems->getRows();
            $deviceBreak = $deviceList;
        }else{
            $deviceBreak = 0;
        }
        if(count($operatingSystems->getRows()) > 0){
            $searchEngineResult = $resultsSearchEngine->getRows();
            $searchEngine = $searchEngineResult[0][0];
        }else{
            $searchEngine = 0;
        }

        // Parses the response from the Core Reporting API and prints
        // the profile name and total sessions.
        if (count($results->getRows()) > 0) {

            // Get the profile name.
            $profileName = $results->getProfileInfo()->getProfileName();

            $totalRecords = $results->getTotalsForAllResults();


            // Get the entry for the first entry in the first row.
            $rows = $results->getRows();

            //var_dump($rows);

            $valueRange = array();
            $numUser = array();
            $numPageViews = array();

            foreach($rows as $records){

                $arr2 = str_split($records[0],4);
                $arr3 = str_split($arr2[1],2);

                $valueRange[] = $arr3[0]."/".$arr3[1];
                $numUser[] = $records[1];
                $numPageViews[] = $records[2];

            }


            $data = array(
                'valueRange'=>  json_encode( $valueRange),
                'numUser'=>  json_encode( $numUser),
                'numPageViews'=>  json_encode( $numPageViews),
                'profileName'=>$profileName,
                'totalRecords'=>$totalRecords,
                'searchEngine'=>$searchEngine,
                'deviceBreak'=>$deviceBreak,
                'visitor'=>$visitor,
                'profile'=>$profile,
            );


            return $data;


            /*            $sessions = $rows[0][0];

                        // Print the results.
                        print "<p>First view (profile) found: $profileName</p>";
                        print "<p>Total sessions: $sessions</p>";*/
        } else {
            print "<p>No results found.</p>";
        }
    }

    ////////////////////Facebook

    public function getDashboard()
    {
        $pageDetailsDB =  $this->facebookdata_model->getfacebookpage($_SESSION['id']);


        $dateFor30days = date('Y-m-d', strtotime('-30 days'));
        $today = date('Y-m-d');

        $fbDashboardRecords = array();
        $numOfProfile = 0;


        foreach ($pageDetailsDB as $item) {

            try {
                // Returns a `Facebook\FacebookResponse` object
                //$response = $this->fb->get('/me?fields=id,name,accounts', $_SESSION['fb_access_code']);
                //since=2011-07-01&until=2012-08-08&

                $fbReachlist = $this->fb->get('/'.$item->page_id.'/insights/page_impressions_unique/day?since='.$dateFor30days, $item->page_access);
                $fbLikelist = $this->fb->get('/'.$item->page_id.'/insights/page_fans?since='.$dateFor30days, $item->page_access);
                $fbReport = $this->fb->get('/'.$item->page_id.'/insights/page_consumptions_unique,page_views_total/day?since='.$dateFor30days, $item->page_access);
                $fbLike = $this->fb->get('/'.$item->page_id.'/insights/page_fans', $item->page_access);
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

                $reachTableList[] =$row['value'];
                $totalReach = $totalReach+$row['value'];

            }

            foreach ($likelist['data'][0]['values'] as $row){

                $dateMonth = new DateTime($row['end_time']);


                $likeTableList[] =$row['value'];
                $dateRange[]=$dateMonth->format('m/d');

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
                'valueRange'=>json_encode($dateRange),
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

            'fbDashboardRecords'=>$fbDashboardRecords,
            'sub'=>'FB',


        );

        return $data;


    }

}