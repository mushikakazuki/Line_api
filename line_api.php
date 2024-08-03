<?php
require_once('./env.php');

function post_message($message){

    $data = http_build_query( [ 'message' => $message ], '', '&');

    $options = [
        'http'=> [
            'method'=>'POST',
            'header'=>'Authorization: Bearer ' . LINE_API_TOKEN . "\r\n"
                    . "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => $data,
            ]
        ];

    $context = stream_context_create($options);
    file_get_contents(LINE_API_URL, false, $context);
}

post_message('テスト投稿4');