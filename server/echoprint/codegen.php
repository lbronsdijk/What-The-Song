<?php

// check ffmpeg version
$ffmpeg = trim(shell_exec('which ffmpeg'));

if (empty($ffmpeg))
{
    die('ffmpeg not available');
}

// execute echoprint-codegen bin through php
// using ./echoprint-codegen
$json = shell_exec('./echoprint-codegen audio.mp3');

echo '<h1>Codegen result:</h1>';
print_r($json);

//echonest api call
$url = "http://developer.echonest.com/api/v4/song/identify";
$api_key = 'YZ5AQSBJDZXKCJ8A8';

$data = array(
    'api_key' => $api_key,
    'query' => $json
);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

$result = curl_exec($ch);

echo '<h1>Echonest result:</h1>';
print_r($result);