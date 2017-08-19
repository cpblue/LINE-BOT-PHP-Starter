<?php

require_once '../vendor/autoload.php';


$access_token = 'N8yg/hFYYNKm8P4z0isjQ0CcnW1IZyIWqzYBwjvmNxr/ZLXw0lx6VaTlnT/cJVxqiYe/kxtOZanKAQye4UvoUYx+QQsD10Egl5x6L/RCPcExUrqnfIvGEfNk6JcXQ/5zWNV2EXwQ52RBupyF6s2JaQdB04t89/1O/w1cDnyilFU=';
$chanel_secret = '761b5b0c998b4c7cc139552adfaece2a';


try {
	$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
	$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $chanel_secret]);
  //If the exception is thrown, this text will not be shown
  echo 'initial bot successfully';
}

//catch exception
catch(Exception $e) {
  echo 'Unable to init bot with error Message: ' .$e->getMessage();
}


// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {

		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			// $messages = [
			// 	'type' => 'text',
			// 	'text' => $text
			// ];

			// // Make a POST Request to Messaging API to reply to sender
			// $url = 'https://api.line.me/v2/bot/message/reply';
			// $data = [
			// 	'replyToken' => $replyToken,
			// 	'messages' => [$messages],
			// ];
			// $post = json_encode($data);
			// $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			// $ch = curl_init($url);
			// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		 //      $proxy = 'velodrome.usefixie.com:80';
		 //      $proxyauth = 'fixie:aViCdpri3CDEA4v';
		 //      curl_setopt($ch, CURLOPT_PROXY, $proxy);
		 //      curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
			// $result = curl_exec($ch);
			// curl_close($ch);
			// echo $result . "\r\n";

			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
			$response = $bot->replyMessage($replyToken, $textMessageBuilder);
			if ($response->isSucceeded()) {
			    echo 'Succeeded!';
			    return;
			}

			// Failed
			echo $response->getHTTPStatus() . ' ' . $response->getRawBody();

		}
	}
}
echo "OK";



