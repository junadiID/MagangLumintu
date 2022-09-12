<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once "../../model/ModulFile.php";
$modul_file = new ModulFile();

try {
    $rows = $modul_file->readAllFiles();
} catch (PDOException $e) {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal mendapatkan data"
    ];
    goto output;
}

if ($rows || empty($rows)) {
    $response = [
        "error" => false,
        "data" => $rows
    ];
} else {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal mendapatkan data"
    ];
}

output: {
    echo json_encode($response);
}
