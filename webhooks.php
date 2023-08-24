<?php
require __DIR__ . '/vendor/autoload.php'; // Load Composer's autoloader
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Now you can access environment variables using $_ENV or $_SERVER
// Facebook Webhook Verification
$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'mysecretver') {
  echo $challenge;
}
// ACCESS TOKENFROM env
$access_token = $_ENV['PAGE_ACCESS_TOKEN'];
// ACCESS PaGE ID env
$page_id = $_ENV['PAGE_ID'];


// Handle Incoming Webhook Events
$input = json_decode(file_get_contents('php://input'), true);

// $recipient_id = $input['entry'][0]['messaging'][0]['sender']['id'];
$recipient_id = $input['entry'][0]['messaging'][0]['sender']['id'];

$api_version = 'v17.0'; // Replace with the latest API version, e.g., v13.0

// $api_version = 'v2.6'; // Replace with the desired API version

$greeting_data = array(
  "get_started" => array(
    "payload" => "get start"
  ),
  "greeting" => array(
    array(
      "locale" => "default",
      "text" => "Hello {{user_first_name}}!, Tap get started to start chatting with District management bot"
    )
  )
);

$url = "https://graph.facebook.com/$api_version/me/messenger_profile?access_token=$access_token";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($greeting_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);

if ($response !== false) {
} else {
  // Error setting greeting text
  echo "Error setting greeting text.";
}



$message_rec = $input['entry'][0]['messaging'][0]['message']['text'];
$payload = $input['entry'][0]['messaging'][0]['postback']['payload']; // Retrieve the payload

// ...

if ($payload === 'get start') {

  $payload_data = array(
    "recipient" => array(
      "id" => $recipient_id
    ),
    "message" => array(
      "attachment" => array(
        "type" => "template",
        "payload" => array(
          "template_type" => "button",
          "text" => "How can i help you?",
          "buttons" => array(
            array(
              "type" => "postback",
              "payload" => "menubot",
              "title" => "Get Menus"
            ),
            array(
              "type" => "postback",
              "payload" => "other",
              "title" => "Rate Us"
            ),
            array(
              "type" => "postback",
              "payload" => "otherbtn",
              "title" => "Other"
            ),
            // Add other button configurations here
          )
        )
      )
    )
  );


  $url = "https://graph.facebook.com/$api_version/me/messages?access_token=$access_token";

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload_data));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


  $response = curl_exec($ch);

  curl_close($ch);
} elseif ($payload === 'menubot') {
  // Handle other cases or default behavior
  $payload_data = array(
    "recipient" => array(
      "id" => $recipient_id
    ),
    "message" => array(
      "attachment" => array(
        "type" => "template",
        "payload" => array(
          "template_type" => "button",
          "text" => "Choose one",
          "buttons" => array(
            array(
              "type" => "web_url",
              "url" => "http://districtmanagement.net/d24menu/",
              "title" => "Breakfast to Breakfast"
            ),
            array(
              "type" => "web_url",
              "url" => "http://districtmanagement.net/d24menu/",
              "title" => "Dstrkt24"
            ),
            array(
              "type" => "web_url",
              "url" => "http://districtmanagement.net/d24menu/",
              "title" => "Mad Cub"
            ),
            // Add other button configurations here
          )
        )
      )
    )
  );


  $url = "https://graph.facebook.com/$api_version/me/messages?access_token=$access_token";

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload_data));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


  $response = curl_exec($ch);

  curl_close($ch);
} elseif ($payload === 'otherbtn') {
  $payload_data = array(
    "recipient" => array(
      "id" => $recipient_id
    ),
    "message" => array(
      "attachment" => array(
        "type" => "template",
        "payload" => array(
          "template_type" => "button",
          "text" => "How can i help you?",
          "buttons" => array(
            array(
              "type" => "postback",
              "payload" => "madev",
              "title" => "Mad Club Events"
            ),
            array(
              "type" => "postback",
              "payload" => "madres",
              "title" => "Mad Reservation"
            ),
            array(
              "type" => "postback",
              "payload" => "brCall",
              "title" => "Call Branches"
            ),
            // Add other button configurations here
          )
        )
      )
    )
  );


  $url = "https://graph.facebook.com/$api_version/me/messages?access_token=$access_token";

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload_data));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


  $response = curl_exec($ch);

  curl_close($ch);
}
