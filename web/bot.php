<?php

require_once '../vendor/autoload.php';

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;

$access_token = getenv('LINEBOT_ACCESS_TOKEN');
$chanel_secret = getenv('LINEBOT_CHANNEL_SECRET');


try {
	$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
	$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $chanel_secret]);
  //If the exception is thrown, this text will not be shown
  // echo 'initial bot successfully';
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

			// //Build message to reply back
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
		      // $proxy = 'velodrome.usefixie.com:80';
		      // $proxyauth = 'fixie:aViCdpri3CDEA4v';
		      // curl_setopt($ch, CURLOPT_PROXY, $proxy);
		      // curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
			// $result = curl_exec($ch);
			// curl_close($ch);
			// echo $result . "\r\n";

			try {
			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
			$response = $bot->replyMessage($replyToken, $textMessageBuilder);
			if ($response->isSucceeded()) {
			    echo 'Succeeded!';
			    return;
			}
			}

			//catch exception
			catch(Exception $e) {
				// Failed
				// echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
			  echo 'fail to reply: ' .$e->getMessage();
			}





		}
	}
}
echo "OK";



