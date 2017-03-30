<?php
$access_token = '74kiMVdmBmqYDxxxEEhQpWAgmDbUjFfKeBvOHjxmGzssBMKls3vhepEAo5FEKZ6f7gTLrlu3rubAV4veK312nYL9sKtC3PD/S4/3To8t/AsXobuQUzV/Uo7MrNcWWT/f0XET3PgwdBrFGJISS2KuCgdB04t89/1O/w1cDnyilFU=';

$method = $_GET['method'];

echo $method;

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events']) && $method == 'reply') {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
            $userId = $event['source']['userId'];
			$text = $event['message']['text'] . " | (" . $userId.")";
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages1 = [
				'type' => 'text',
				'text' => $text
			];
            $messages2 = [
				'type' => 'text',
				'text' => 'ทดสอบข้อความที่สอง'
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
                //'to' => $userId,
				'messages' => [$messages1],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}else if($method == 'push'){
    $userId = 'U52aa62da4aa11ce1697d7cc38564bcbb';
    $text = "คุณคือผู้โชคดี";
    // Build message to reply back
    $messages1 = [
        'type' => 'text',
        'text' => $text
    ];
    $messages2 = [
        'type' => 'text',
        'text' => 'ทดสอบข้อความที่สอง'
    ];

    // Make a POST Request to Messaging API to reply to sender
    $url = 'https://api.line.me/v2/bot/message/push';
    $data = [
        //'replyToken' => $replyToken,
        'to' => $userId,
        'messages' => [$messages1],
    ];
    $post = json_encode($data);
    $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    echo $result . "\r\n";
}
echo "OK";