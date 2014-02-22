<?php

require_once( 'config.php') ;
require_once( 'google-api-php-client-read-only/src/Google_Client.php' );
require_once( 'google-api-php-client-read-only/src/contrib/Google_AnalyticsService.php' );

// create client object and set app name
$client = new Google_Client();
$client->setApplicationName(APP_NAME); // name of your app

// set assertion credentials
$client->setAssertionCredentials(
  new Google_AssertionCredentials(

    APP_EMAIL, // email you added to GA

    array('https://www.googleapis.com/auth/analytics.readonly'),

    file_get_contents(PATH_TO_PRIVATE_KEY_FILE)  // keyfile you downloaded

));

// other settings
$client->setClientId(CLIENT_ID);           // from API console
$client->setAccessType('offline_access');  // this may be unnecessary?

// create service and get data
$service = new Google_AnalyticsService($client);

$analytics_id	= 'ga:69152654'; // my profile id
$startDate		= date('Y-m-d', strtotime('-1 month'));
$endDate		= date('Y-m-d');
$metrics		= 'ga:uniqueEvents';
$optParams		= array( 'dimensions' => 'ga:eventLabel', 'sort' => '-ga:uniqueEvents' );

try {
    $results = $service->data_ga->get( $analytics_id, $startDate, $endDate, $metrics, $optParams );
    echo json_encode( $results );
} catch(Exception $e) {
    echo 'There was an error : - ' . $e->getMessage();
}
die();