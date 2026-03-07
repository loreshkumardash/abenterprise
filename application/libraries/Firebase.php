<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once APPPATH . 'third_party/vendor/autoload.php'; // Ensure this path is correct

use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Auth\Middleware\AuthTokenMiddleware;
use Google\Auth\CredentialsLoader;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

class Firebase {
    private $CI;
    private $serviceAccountFile;
    private $projectID;

    public function __construct() {
        $this->CI =& get_instance();
        $this->serviceAccountFile = APPPATH . 'config/firebase-service-account.json'; // Path to JSON key file
        $this->projectID = "kr-developer-7af84"; // Replace with your Firebase Project ID
    }

    public function sendNotification($deviceToken, $title, $body, $data = [], $image = '') {
        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectID}/messages:send";

        // Load Google credentials properly
        putenv("GOOGLE_APPLICATION_CREDENTIALS={$this->serviceAccountFile}");
        $httpHandler = HttpHandlerFactory::build();
        $auth = ApplicationDefaultCredentials::getCredentials(['https://www.googleapis.com/auth/firebase.messaging'], $httpHandler);
        $token = $auth->fetchAuthToken($httpHandler);
        
        $accessToken = $token["access_token"] ?? '';

        if (!$accessToken) {
            return json_encode(['error' => 'Failed to obtain access token']);
        }

        // Ensure data is an associative array
        $dataPayload = array_merge(["default_page" => "home"], $data); // Default page to prevent empty errors

        // FCM payload
        $payload = [
            "message" => [
                "token" => $deviceToken,
                "notification" => [
                    "title" => $title,
                    "body" => $body,
                ],
                "data" => $dataPayload, // Correct format: key-value pairs
            ],
        ];

        // Include image in notification if provided
        if (!empty($image)) {
            $payload["message"]["notification"]["image"] = $image;
        }

        // HTTP headers
        $headers = [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json",
        ];

        // Send request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        // Debugging: Log response for troubleshooting
        if ($httpCode !== 200) {
            return json_encode([
                'error' => 'FCM request failed',
                'http_code' => $httpCode,
                'response' => $response,
                'curl_error' => $curlError
            ]);
        }

        return $response;
    }


}
?>
