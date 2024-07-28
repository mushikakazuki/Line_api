<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once('./env.php');

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;


$channelToken = YOUR_CHANNEL_ACCESS_TOKEN;
$channelSecret = YOUR_CHANNEL_SECRET;

$httpClient = new CurlHTTPClient($channelToken);
$bot = new LINEBot($httpClient, ['channelSecret' => $channelSecret]);

// Webhookからのリクエストを取得
$input = file_get_contents('php://input');
$events = json_decode($input, true);

if (!is_null($events['events'])) {
    foreach ($events['events'] as $event) {
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            $replyToken = $event['replyToken'];
            $text = $event['message']['text'];
            $responseText = "You said: " . $text;

            // メッセージを送信
            $textMessageBuilder = new TextMessageBuilder($responseText);
            $response = $bot->replyMessage($replyToken, $textMessageBuilder);

            if (!$response->isSucceeded()) {
                error_log('Failed! ' . $response->getHTTPStatus() . ' ' . $response->getRawBody());
            }
        }
    }
}

echo "OK";