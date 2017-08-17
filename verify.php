<?php
$access_token = 'N8yg/hFYYNKm8P4z0isjQ0CcnW1IZyIWqzYBwjvmNxr/ZLXw0lx6VaTlnT/cJVxqiYe/kxtOZanKAQye4UvoUYx+QQsD10Egl5x6L/RCPcExUrqnfIvGEfNk6JcXQ/5zWNV2EXwQ52RBupyF6s2JaQdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v2/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
