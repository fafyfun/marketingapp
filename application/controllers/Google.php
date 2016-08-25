<?php

/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 3/30/16
 * Time: 11:52 AM
 */
require_once APPPATH . 'third_party/google-api-php-client-2.0.0-RC6/vendor/autoload.php';


class Google extends CI_Controller
{

    private $client;

    public function __construct()
    {

        parent::__construct();
        $this->load->model('googledbsave_model');

        $this->client = new Google_Client();
        $this->client->setAuthConfigFile(FCPATH . 'client_secrets.json');


    }

    public function index()
    {

        $this->form_validation->set_rules('start', 'Start', 'required');
        $this->form_validation->set_rules('end', 'End', 'required');


        if ($this->form_validation->run() === false) {

            $start = '30daysAgo';
            $end = 'today';

            $showStart = date('d-m-Y', strtotime('-30 days'));
            $showEnd = date('d-m-Y');

        } else {

            $originalStartDate = $this->input->post('start');
            $start = date("Y-m-d", strtotime($originalStartDate));

            $originalEndDate = $this->input->post('end');
            $end = date("Y-m-d", strtotime($originalEndDate));

            $showStart = $this->input->post('start');
            $showEnd = $this->input->post('end');

        }


        $client = new Google_Client();
        $client->setAuthConfigFile('client_secrets.json');
        $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

        $get_prof = $this->googledbsave_model->get_google_cred($_SESSION['id']);


        if (!empty($get_prof->access_token)) {

            $access_token = array(
                'access_token' => $get_prof->access_token,
                'token_type' => $get_prof->token_type,
                'expires_in' => $get_prof->expires_in,
                'created' => $get_prof->created
            );

            $this->client->setAccessToken($access_token);

            if ($this->client->isAccessTokenExpired()) {

                $this->client->refreshToken($get_prof->refresh_token);
                $access_token = $this->client->getAccessToken();

                $update_token = array(

                    'access_token' => $access_token['access_token'],
                    'token_type' => $access_token['token_type'],
                    'expires_in' => $access_token['expires_in'],
                    'created' => $access_token['created']
                );

                $get_prof = $this->googledbsave_model->update_google_cred($_SESSION['id'], $update_token);

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

            foreach ($getProfileId as $pID) {

                $profile = $pID->web_id;
                $profileSavedName = $pID->namePro;

                $results = $this->getResults($analytics, $profile, $start, $end);

                $resultsSearchEngine = $this->getSearchEngine($analytics, $profile, $start, $end);
                $operatingSystems = $this->getDevice($analytics, $profile, $start, $end);
                $visitorType = $this->getVisitorType($analytics, $profile, $start, $end);


                $resultData[] = $this->printResults($results, $resultsSearchEngine, $operatingSystems, $visitorType, $profile,$profileSavedName);

            }


            $data = array(
                'controller' => 'Google',
                'page' => 'Dashboard',
                'showStart' => $showStart,
                'showEnd' => $showEnd,
                'google' => array(
                    'resultData' => $resultData,
                    'sub' => 'Google'
                )

            );


        } else {


            $data = array(
                'controller' => 'Google',
                'page' => 'Dashboard',
                'showStart' => $showStart,
                'showEnd' => $showEnd,
                'google' => array(
                    'resultData' => "",
                    'sub' => 'Google'
                )

            );
        }

        $this->load->view('header', $data);
        $this->load->view('google/dashboard');
        $this->load->view('footer');

    }


    public function callback()
    {
        $this->client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/google/callback');
        $this->client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
        $this->client->setAccessType("offline");
        // Handle authorization flow from the server.
        if (!isset($_GET['code'])) {
            $auth_url = $this->client->createAuthUrl();
            header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));

        } else {
            $this->client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $this->client->getAccessToken();

            if (isset($_SESSION['access_token']['refresh_token'])) {
                $this->googledbsave_model->create_google_cred($_SESSION['id'], $_SESSION['access_token']);
            } else {
                $this->googledbsave_model->create_google_cred($_SESSION['id'], $_SESSION['access_token']);
                $this->revokeToken();

                $_SESSION['has_error'] = 1;
                $_SESSION['error_message'] = "Cannot Syncronise Account Properly... Please Authenticate Again";
            }


            $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/google/getProfileIDs';
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));

        }
    }

    public function getProfileIDs()
    {

        $get_prof = $this->googledbsave_model->get_google_cred($_SESSION['id']);

        if (empty($get_prof)) {
            $data = array(
                'controller' => 'Google',
                'page' => 'getId',
                'profile' => NULL,
            );
        } else {

            $access_token = array(
                'access_token' => $get_prof->access_token,
                'token_type' => $get_prof->token_type,
                'expires_in' => $get_prof->expires_in,
                'created' => $get_prof->created
            );


            $this->client->setAccessToken($access_token);


            if ($this->client->isAccessTokenExpired()) {

                $this->client->refreshToken($get_prof->refresh_token);


                $access_token = $this->client->getAccessToken();

                $update_token = array(

                    'access_token' => $access_token['access_token'],
                    'token_type' => $access_token['token_type'],
                    'expires_in' => $access_token['expires_in'],
                    'created' => $access_token['created']
                );

                $get_prof = $this->googledbsave_model->update_google_cred($_SESSION['id'], $update_token);

            }


            // Create an authorized analytics service object.
            $analytics = new Google_Service_Analytics($this->client);


            try {

                $accounts = $analytics->management_accounts->listManagementAccounts();

                if (count($accounts->getItems()) > 0) {
                    $items = $accounts->getItems();
                    $arrayProfiel = array();



                    foreach ($items as $value) {

                        $arrayProfiel[] = array(
                            'id' => $value ['id'],
                            'name' => $value ['name'],
                        );
                    }
                } else {
                    throw new Exception('No accounts found for this user.');
                }

                if ($this->input->post()) {

                    $accountId = $this->input->post('profile');
                    $propId = $this->input->post('property');
                    $propName = $this->input->post('namePro');

                    $webPropID = $this->getWebPropId($analytics, $accountId, $propId);

                    $profData = array(
                        'account_id' => $accountId,
                        'prop_id' => $propId,
                        'web_id' => $webPropID,
                        'namePro' => $propName,
                        'status' => 1,
                    );

                    $result = $this->googledbsave_model->create_google_prof($_SESSION['id'], $profData);

                    if ($result['error'] == 0) {
                        if ($result['response']) {
                            $data['error_message'] = "Profile Successfully Added";
                            $data['error_response'] = "1";
                        } else {
                            $data['error_message'] = "Something went wrong, Try again";
                            $data['error_response'] = "0";
                        }

                    } elseif ($result['error'] == 1) {
                        $data['error_message'] = "Profile already added";
                        $data['error_response'] = "0";
                    }


                }

            } catch (\Exception $e) {


                $e->getMessage();

                $error = json_decode($e->getMessage());


                $arrayProfiel['error'] = array(
                    'error' => 1,
                    'message' => $error->error->message
                );


            }


            $data['controller'] = 'Google';
            $data['page'] = 'getId';
            $data['profile'] = $arrayProfiel;


        }

        $getProfileList = $this->googledbsave_model->getProfileList($_SESSION['id']);

        if (!empty($getProfileList)) {
            $data['selectProfile'] = $getProfileList;
        } else {
            $data['selectProfile'] = NULL;
        }


        $this->load->view('header', $data);
        $this->load->view('google/getId');
        $this->load->view('footer');


    }

    public function revokeToken()
    {

        $get_prof = $this->googledbsave_model->get_google_cred($_SESSION['id']);

        $result = $this->client->revokeToken(array('access_token' => $get_prof->access_token));

        $this->googledbsave_model->remove_access($_SESSION['id']);

        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/google/getProfileIDs';
        header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));

    }

    public function getWebProfileId()
    {

        $get_prof = $this->googledbsave_model->get_google_cred($_SESSION['id']);


        $access_token = array(
            'access_token' => $get_prof->access_token,
            'token_type' => $get_prof->token_type,
            'expires_in' => $get_prof->expires_in,
            'created' => $get_prof->created
        );


        $this->client->setAccessToken($access_token);

        if ($this->client->isAccessTokenExpired()) {


            $this->client->refreshToken($get_prof->refresh_token);
            $access_token = $this->client->getAccessToken();

            $update_token = array(

                'access_token' => $access_token['access_token'],
                'token_type' => $access_token['token_type'],
                'expires_in' => $access_token['expires_in'],
                'created' => $access_token['created']
            );

            $get_prof = $this->googledbsave_model->update_google_cred($_SESSION['id'], $update_token);

        }


        // Create an authorized analytics service object.
        $analytics = new Google_Service_Analytics($this->client);

        $prof_id = $_POST['prof_id'];


        $properties = $analytics->management_webproperties->listManagementWebproperties($prof_id);

        if (count($properties->getItems()) > 0) {

            $items = $properties->getItems();

            $arrayProp = array();

            foreach ($items as $webProp) {

                $arrayProp[] = array(
                    'id' => $webProp->getId(),
                    'name' => $webProp->getName(),
                );

            }

        }

        echo json_encode($arrayProp);

        exit;

    }

    public function getWebPropId(&$analytics, $accountId, $propertyId)
    {
        // Get the list of views (profiles) for the authorized user.
        $profiles = $analytics->management_profiles
            ->listManagementProfiles($accountId, $propertyId);

        if (count($profiles->getItems()) > 0) {
            $items = $profiles->getItems();
            return ($items[0]->getId());

            // Return the first view (profile) ID.
            //return $items[0]->getId();
        } else {
            throw new Exception('No views (profiles) found for this user.');
        }

    }

    public function getResults($analytics, $profileId, $start, $end)
    {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $start,
            $end,
            'ga:users,ga:pageviews,ga:bounceRate,ga:avgSessionDuration,ga:sessions,ga:percentNewSessions', array('dimensions' => 'ga:date'));
    }


    public function getVisitorType($analytics, $profileId, $start, $end)
    {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $start,
            $end,
            'ga:sessions', array('dimensions' => 'ga:userType'));


    }

    public function getDevice($analytics, $profileId, $start, $end)
    {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $start,
            $end,
            'ga:sessions', array('dimensions' => 'ga:operatingSystem'));
    }

    public function getSearchEngine($analytics, $profileId, $start, $end)
    {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $start,
            $end,
            'ga:exits', array('filters' => 'ga:medium==cpa,ga:medium==cpc,ga:medium==cpm,ga:medium==cpp,ga:medium==cpv,ga:medium==organic,ga:medium==ppc'));
    }

    public function getKeyWord($analytics, $profileId, $start, $end)
    {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $start,
            $end,
            'ga:sessions,ga:percentNewSessions', array('dimensions' => 'ga:keyword'));
    }

    public function getLandingPage($analytics, $profileId, $start, $end)
    {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $start,
            $end,
            'ga:sessions,ga:percentNewSessions', array('dimensions' => 'ga:landingPagePath', 'sort' => '-ga:sessions', 'max-results' => 10));
    }

    public function getCountryList($analytics, $profileId, $start, $end)
    {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $start,
            $end,
            'ga:sessions,ga:percentNewSessions', array('dimensions' => 'ga:country', 'sort' => '-ga:sessions', 'max-results' => 10));
    }

    public function printResults(&$results, &$resultsSearchEngine, &$operatingSystems, &$visitorType, $profile,$profileSavedName)
    {


        if (count($resultsSearchEngine->getRows()) > 0) {
            $searchEngineResult = $resultsSearchEngine->getRows();
            $searchEngine = $searchEngineResult[0][0];
        } else {
            $searchEngine = 0;
        }

        if (count($visitorType->getRows()) > 0) {
            $visitorResultType = $visitorType->getRows();
            $visitor = $visitorResultType;
        } else {
            $visitor = 0;
        }

        if (count($operatingSystems->getRows()) > 0) {
            $deviceList = $operatingSystems->getRows();
            $deviceBreak = $deviceList;
        } else {
            $deviceBreak = 0;
        }
        if (count($operatingSystems->getRows()) > 0) {
            $searchEngineResult = $resultsSearchEngine->getRows();
            $searchEngine = $searchEngineResult[0][0];
        } else {
            $searchEngine = 0;
        }

        // Parses the response from the Core Reporting API and prints
        // the profile name and total sessions.
        if (count($results->getRows()) > 0) {

            // Get the profile name.
            $profileName = $profileSavedName;

            $totalRecords = $results->getTotalsForAllResults();


            // Get the entry for the first entry in the first row.
            $rows = $results->getRows();

            //var_dump($rows);

            $valueRange = array();
            $numUser = array();
            $numPageViews = array();

            foreach ($rows as $records) {


                $dateTimestamp = strtotime($records[0]);

                $valueRange [] = $dateTimestamp;

                $numUser[] = array($dateTimestamp * 1000, (Int)$records[1]);
                $numPageViews[] = array($dateTimestamp * 1000, (Int)$records[2]);

            }

            $data = array(
                // 'valueRange'=>  json_encode( $valueRange),
                'numUser' => json_encode($numUser),
                'numPageViews' => json_encode($numPageViews),
                'profileName' => $profileName,
                'totalRecords' => $totalRecords,
                'searchEngine' => $searchEngine,
                'deviceBreak' => $deviceBreak,
                'visitor' => $visitor,
                'profile' => $profile,
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

    public function details($profile_id)
    {

        $this->form_validation->set_rules('start', 'Start', 'required');
        $this->form_validation->set_rules('end', 'End', 'required');


        if ($this->form_validation->run() === false) {

            $start = '30daysAgo';
            $end = 'today';

            $showStart = date('d-m-Y', strtotime('-30 days'));
            $showEnd = date('d-m-Y');

        } else {

            $originalStartDate = $this->input->post('start');
            $start = date("Y-m-d", strtotime($originalStartDate));

            $originalEndDate = $this->input->post('end');
            $end = date("Y-m-d", strtotime($originalEndDate));

            $showStart = $this->input->post('start');
            $showEnd = $this->input->post('end');

        }


        $get_prof = $this->googledbsave_model->get_google_cred($_SESSION['id']);


        $access_token = array(
            'access_token' => $get_prof->access_token,
            'token_type' => $get_prof->token_type,
            'expires_in' => $get_prof->expires_in,
            'created' => $get_prof->created
        );


        $this->client->setAccessToken($access_token);

        if ($this->client->isAccessTokenExpired()) {


            $this->client->refreshToken($get_prof->refresh_token);
            $access_token = $this->client->getAccessToken();

            $update_token = array(

                'access_token' => $access_token['access_token'],
                'token_type' => $access_token['token_type'],
                'expires_in' => $access_token['expires_in'],
                'created' => $access_token['created']
            );

            $get_prof = $this->googledbsave_model->update_google_cred($_SESSION['id'], $update_token);

        }

        $analytics = new Google_Service_Analytics($this->client);

        $profile = $profile_id;

        $getProfileDBData = $get_prof = $this->googledbsave_model->getProfileData( $profile, $_SESSION['id']);



        $results = $this->getResults($analytics, $profile, $start, $end);


        $resultsSearchEngine = $this->getSearchEngine($analytics, $profile, $start, $end);
        $operatingSystem = $this->getDevice($analytics, $profile, $start, $end);
        $visitorType = $this->getVisitorType($analytics, $profile, $start, $end);

        $keywordList = $this->getKeyWord($analytics, $profile, $start, $end);
        $landingPages = $this->getLandingPage($analytics, $profile, $start, $end);
        $getCountryList = $this->getCountryList($analytics, $profile, $start, $end);




        if (count($keywordList->getRows()) > 0) {
            $keywordResult = $keywordList->getRows();
            $keyword = $keywordResult;
        } else {
            $keyword = 0;
        }
        if (count($getCountryList->getRows()) > 0) {
            $countryList = $getCountryList->getRows();
            $country = $countryList;
        } else {
            $country = 0;
        }

        if (count($landingPages->getRows()) > 0) {
            $landingResult = $landingPages->getRows();
            $landing = $landingResult;
        } else {
            $landing = 0;
        }

        if (count($resultsSearchEngine->getRows()) > 0) {
            $searchEngineResult = $resultsSearchEngine->getRows();
            $searchEngine = $searchEngineResult[0][0];
        } else {
            $searchEngine = 0;
        }

        if (count($visitorType->getRows()) > 0) {
            $visitorResultType = $visitorType->getRows();
            $visitor = $visitorResultType;
        } else {
            $visitor = 0;
        }

        if (count($operatingSystem->getRows()) > 0) {
            $deviceList = $operatingSystem->getRows();
            $deviceBreak = $deviceList;
        } else {
            $deviceBreak = 0;
        }



        /*        // Parses the response from the Core Reporting API and prints
                // the profile name and total sessions.
                if (count($results->getRows()) > 0) {*/

        // Get the profile name.
        $profileName = $getProfileDBData->namePro;

        $totalRecords = $results->getTotalsForAllResults();


        // Get the entry for the first entry in the first row.
        $rows = $results->getRows();

        //var_dump($rows);

        $valueRange = array();
        $numUser = array();
        $numPageViews = array();

        $flag =1;

        foreach ($rows as $records) {


            $dateTimestamp = strtotime($records[0]);

            if($records[1]!=0 || $records[1]!=0){
                $numUser[] = array($dateTimestamp * 1000, (Int)$records[1]);
                $numPageViews[] = array($dateTimestamp * 1000, (Int)$records[2]);

                $flag =1;

            }else{
                $flag =0;

            }



        }


        $data = array(
            'controller' => 'Google',
            'page' => 'Details',
            'valueRange' => json_encode($valueRange),
            'numUser' => json_encode($numUser),
            'numPageViews' => json_encode($numPageViews),
            'profileName' => $profileName,
            'totalRecords' => $totalRecords,
            'searchEngine' => $searchEngine,
            'deviceBreak' => $deviceBreak,
            'visitor' => $visitor,
            'keyword' => $keyword,
            'landing' => $landing,
            'country' => $country,
            'showStart' => $showStart,
            'showEnd' => $showEnd,
            'flag'=>$flag,
        );

        $this->load->view('header', $data);
        $this->load->view('google/details');
        $this->load->view('footer');
    }


    public function deleteAcc($id)
    {

        $listAdded = $this->googledbsave_model->delete($id, $_SESSION['id']);

        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/google/getProfileIDs';
        header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        exit;

    }

}