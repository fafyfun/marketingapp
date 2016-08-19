<?php

/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 3/30/16
 * Time: 11:52 AM
 */
require_once APPPATH.'/third_party/google-api-php-client-2.0.0-RC6/vendor/autoload.php';


class Google extends CI_Controller
{

    private $client;

    public function __construct()
    {

        parent::__construct();
        $this->load->model('google_model');

        $this->client = new Google_Client();
        $this->client->setAuthConfigFile(FCPATH.'client_secrets.json');


    }

    public function checkAuth(){


        $this->client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            // Set the access token on the client.
            $this->client->setAccessToken($_SESSION['access_token']);

            var_dump($_SESSION['access_token']);

            // Create an authorized analytics service object.
            $analytics = new Google_Service_Analytics($this->client);

            var_dump($analytics);

            // Get the first view (profile) id for the authorized user.
            //$profile = $this->getProfileIDs($analytics);

            $profile = 9300436;

            // Get the results from the Core Reporting API and print the results.
            $results = $this->getResults($analytics, $profile);
            $resultsSearchEngine = $this->getSearchEngine($analytics, $profile);
            $operatingSystem = $this->getDevice($analytics, $profile);
            $visitorType = $this->getVisitorType($analytics, $profile);
            $this-> printResults($results,$resultsSearchEngine,$operatingSystem,$visitorType);
        } else {
            $this->callback();
        }
    }


    public function callback()
    {
        $this->client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/dashboard/google/callback');
        $this->client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
        $this->client->setAccessType("offline");
        // Handle authorization flow from the server.
        if (! isset($_GET['code'])) {
            $auth_url =$this->client->createAuthUrl();
            header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));

        } else {
            $this->client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $this->client->getAccessToken();

            $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/dashboard/google/checkAuth';
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));

        }
    }

    public function getProfileIDs(&$analytics)
    {
        // Get the user's first view (profile) ID.

        // Get the list of accounts for the authorized user.
        $accounts = $analytics->management_accounts->listManagementAccounts();

        if (count($accounts->getItems()) > 0) {
            $items = $accounts->getItems();
            $firstAccountId = $items[0]->getId();

            // Get the list of properties for the authorized user.
            $properties = $analytics->management_webproperties
                ->listManagementWebproperties($firstAccountId);



            if (count($properties->getItems()) > 0) {


                $items = $properties->getItems();

                foreach($items as $webProp){
                    var_dump($webProp->getName());
                    var_dump($webProp->getId());
                    $this->getWebPropId($analytics,$firstAccountId,$webProp->getId());
                }
                exit;
            } else {
                throw new Exception('No properties found for this user.');
            }
        } else {
            throw new Exception('No accounts found for this user.');
        }
    }

    public function getWebPropId(&$analytics,$accountId,$propertyId)
    {
        // Get the list of views (profiles) for the authorized user.
        $profiles = $analytics->management_profiles
            ->listManagementProfiles($accountId, $propertyId);

        if (count($profiles->getItems()) > 0) {
            $items = $profiles->getItems();
            print_r( $items[0]->getId());
            // Return the first view (profile) ID.
            //return $items[0]->getId();
        } else {
            throw new Exception('No views (profiles) found for this user.');
        }

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

    public function printResults(&$results,&$resultsSearchEngine,&$operatingSystems,&$visitorType)
    {

        /*       echo '<pre>';
                print_r($visitorType);
                exit;*/


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
                'page'=>'Dashboard',
                'valueRange'=>  json_encode( $valueRange),
                'numUser'=>  json_encode( $numUser),
                'numPageViews'=>  json_encode( $numPageViews),
                'profileName'=>$profileName,
                'totalRecords'=>$totalRecords,
                'searchEngine'=>$searchEngine,
                'deviceBreak'=>$deviceBreak,
                'visitor'=>$visitor,
            );

            $this->load->view('header');
            $this->load->view('dashboard/index', $data);
            $this->load->view('footer', $data);



            /*            $sessions = $rows[0][0];

                        // Print the results.
                        print "<p>First view (profile) found: $profileName</p>";
                        print "<p>Total sessions: $sessions</p>";*/
        } else {
            print "<p>No results found.</p>";
        }
    }

    public function details()
    {

        $this->client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {


            echo ' <pre>';
            print_r($_SESSION['access_token']);

            // Set the access token on the client.
            $this->client->setAccessToken($_SESSION['access_token']);

            $this->client->refreshToken($_SESSION['access_token']['refresh_token']);

            $_SESSION['access_token'] =  $this->client->getAccessToken();

        }

        echo ' <pre>';
        print_r($_SESSION['access_token']);
        exit;

        $analytics = new Google_Service_Analytics($this->client);

        $profile = 9300436;


        $results = $this->getResults($analytics, $profile);


        $resultsSearchEngine = $this->getSearchEngine($analytics, $profile);
        $operatingSystem = $this->getDevice($analytics, $profile);
        $visitorType = $this->getVisitorType($analytics, $profile);

        $keywordList = $this->getKeyWord($analytics, $profile);
        $landingPages = $this->getLandingPage($analytics, $profile);
        $getCountryList = $this->getCountryList($analytics, $profile);


        if(count($keywordList->getRows()) > 0){
            $keywordResult = $keywordList->getRows();
            $keyword = $keywordResult;
        }else{
            $keyword = 0;
        }
        if(count($getCountryList->getRows()) > 0){
            $countryList = $getCountryList->getRows();
            $country = $countryList;
        }else{
            $country = 0;
        }

        if(count($landingPages->getRows()) > 0){
            $landingResult = $landingPages->getRows();
            $landing = $landingResult;
        }else{
            $landing = 0;
        }

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

        if(count($operatingSystem->getRows()) > 0){
            $deviceList = $operatingSystem->getRows();
            $deviceBreak = $deviceList;
        }else{
            $deviceBreak = 0;
        }



        /*        // Parses the response from the Core Reporting API and prints
                // the profile name and total sessions.
                if (count($results->getRows()) > 0) {*/

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
            'page'=>'Dashboard',
            'valueRange'=>  json_encode( $valueRange),
            'numUser'=>  json_encode( $numUser),
            'numPageViews'=>  json_encode( $numPageViews),
            'profileName'=>$profileName,
            'totalRecords'=>$totalRecords,
            'searchEngine'=>$searchEngine,
            'deviceBreak'=>$deviceBreak,
            'visitor'=>$visitor,
            'keyword'=>$keyword,
            'landing'=>$landing,
            'country'=>$country,
        );

        $this->load->view('header');
        $this->load->view('google/details',$data);
        $this->load->view('footer', $data);
    }

}