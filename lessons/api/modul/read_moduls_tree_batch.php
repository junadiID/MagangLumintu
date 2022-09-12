<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if (!validate_input()) {
    http_response_code(400);
    $response = [
        "error" => true,
        "message" => "Input tidak valid"
    ];
    goto output;
}

require_once "../../model/Modul.php";
$modul = new Modul();
$batch_id = $_GET["batch_id"];

try {
    $modul_tree = $modul->readModulTreeByBatch($batch_id);
} catch (PDOException $e) {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal mendapatkan data"
    ];
    goto output;
}

if ($modul_tree || empty($modul_tree)) {
    $response = [
        "error" => false,
        "data" => $modul_tree
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

function validate_input()
{
    return isset($_GET["batch_id"]) && is_numeric($_GET["batch_id"]);
}
