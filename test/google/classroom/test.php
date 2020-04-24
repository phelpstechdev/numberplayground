<?php
require_once('../../../assets/api/google-php/vendor/autoload.php');

session_start();
/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Classroom API PHP Quickstart');
    $client->setScopes(Google_Service_Classroom::CLASSROOM_COURSES_READONLY);
    $client->setAuthConfig('client_secret_811519910005-mgi1lgkvpjfr7mk2gbqmh7i10e49sckj.apps.googleusercontent.com.json');
    $client->setRedirectUri('https://' . $_SERVER['HTTP_HOST'] . '/apps/numberplayground/test/google/classroom/test.php');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            if (!isset($_GET['code'])) {
                $auth_url = $client->createAuthUrl();
                header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
            } else {

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                $client->setAccessToken($accessToken);
    
                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
                
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0755, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}


// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Classroom($client);
$pageToken = NULL;
$courses = array();

do {
  $params = array(
    'pageSize' => 100,
    'pageToken' => $pageToken
  );
  $response = $service->courses->listCourses($params);
  $courses = array_merge($courses, $response->courses);
  $pageToken = $response->nextPageToken;
} while (!empty($pageToken));

if (count($courses) == 0) {
  print "No courses found.\n";
} else {
  print "Courses:\n";
  foreach ($courses as $course) {
    printf("%s (%s)\n", $course->name, $course->id);
  }
}
?>