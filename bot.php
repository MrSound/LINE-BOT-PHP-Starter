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
				'messages' => [$messages1,$messages2],
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
    $full_name = $_GET['full_name'];
    $mobile = $_GET['mobile'];

    $userId = 'sound014';
    $userId_Nui = 'U52aa62da4aa11ce1697d7cc38564bcbb';
    $userId_Kae = 'Uc2f5b7ab2bdd1f1ec6ffbd66b296a22d';
    $userId_Tee = 'Ucd6f7e10e8d5a1da2626636ca6d43139';
    $userId_Code = 'Ud8c8c659e98e4d3a8321048b4c0272ea';
    $text = "ข้อความอัตโนมัติแจ้งเตือนการ Register : ".$full_name." เบอร์โทร ".$mobile;
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
    $url_multi = 'https://api.line.me/v2/bot/message/multicast';
    $data = [
        //'replyToken' => $replyToken,
        'to' => [$userId_Nui,$userId_Kae,$userId_Tee,$userId_Code],
        'messages' => [$messages1],
    ];
    $post = json_encode($data);
    $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

    $ch = curl_init($url_multi);
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