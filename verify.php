<?php
$access_token = '74kiMVdmBmqYDxxxEEhQpWAgmDbUjFfKeBvOHjxmGzssBMKls3vhepEAo5FEKZ6f7gTLrlu3rubAV4veK312nYL9sKtC3PD/S4/3To8t/AsXobuQUzV/Uo7MrNcWWT/f0XET3PgwdBrFGJISS2KuCgdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;