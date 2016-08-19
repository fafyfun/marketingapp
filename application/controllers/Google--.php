<?php

/**
 * Created by PhpStorm.
 * User: fawaz
 * Date: 3/30/16
 * Time: 11:52 AM
 */
require_once APPPATH . '/third_party/google-api-php-client-2.0.0-RC6/vendor/autoload.php';


class Google extends CI_Controller
{

    private $client;

    public function __construct()
    {

        parent::__construct();
        $this->load->model('google_model');


    }

    public function checkAuth()
    {
// Create the client object and set the authorization configuration
// from the client_secretes.json you downloaded from the developer console.
        $client = new Google_Client();
        $client->setAuthConfigFile('client_secrets.json');
        $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);



// If the user has already authorized this app then get an access token
// else redirect to ask the user to authorize access to Google Analytics.
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            // Set the access token on the client.
            $client->setAccessToken($_SESSION['access_token']);



            // Create an authorized analytics service object.
            $analytics = new Google_Service_Analytics($client);
            echo '<pre>';
            print_r($analytics);
            // Get the first view (profile) id for the authorized user.
            $profile = $this->getFirstProfileId($analytics);

            // Get the results from the Core Reporting API and print the results.
            $results = getResults($analytics, $profile);
            printResults($results);
        } else {
            /*$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/google/oauth2callback.php';
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));*/
            getAuth();
        }
    }


    public function callback()
    {



        // Create the client object and set the authorization configuration
// from the client_secrets.json you downloaded from the Developers Console.
        $client = new Google_Client();
        $client->setAuthConfigFile('client_secrets.json');
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/dashboard/google/callback');
        $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

// Handle authorization flow from the server.
        if (!isset($_GET['code'])) {
            $auth_url = $client->createAuthUrl();
            header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        } else {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/dashboard/google/checkAuth';
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }

    }

    public function getFirstprofileId(&$analytics)
    {
        // Get the user's first view (profile) ID.

        // Get the list of accounts for the authorized user.
        $accounts = $analytics->management_accounts->listManagementAccounts();

        var_dump($accounts);

        if (count($accounts->getItems()) > 0) {
            $items = $accounts->getItems();
            $firstAccountId = $items[0]->getId();

            // Get the list of properties for the authorized user.
            $properties = $analytics->management_webproperties
                ->listManagementWebproperties($firstAccountId);


            if (count($properties->getItems()) > 0) {
                $items = $properties->getItems();


                $firstPropertyId = $items[0]->getId();

                // Get the list of views (profiles) for the authorized user.
                $profiles = $analytics->management_profiles
                    ->listManagementProfiles($firstAccountId, $firstPropertyId);

                if (count($profiles->getItems()) > 0) {
                    $items = $profiles->getItems();

                    // Return the first view (profile) ID.
                    return $items[0]->getId();

                } else {
                    throw new Exception('No views (profiles) found for this user.');
                }
            } else {
                throw new Exception('No properties found for this user.');
            }
        } else {
            throw new Exception('No accounts found for this user.');
        }
    }


}