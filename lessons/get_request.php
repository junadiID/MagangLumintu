<?php

function http_request($url, $token) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    $auth = "Authorization: Bearer " . $token;

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $auth));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $out = curl_exec($ch);

    curl_close($ch);

    return $out;
}