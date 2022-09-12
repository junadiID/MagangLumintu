<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once "../../model/Modul.php";

if (!validate_input()) {
    http_response_code(400);
    $response = [
        "error" => true,
        "message" => "Input tidak valid"
    ];
    goto output;
}

$modul = new Modul();
$id = $_GET['id'];

try {
    $modul_tree = $modul->readSingleModulTree($id);
} catch (PDOException $e) {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal mendapatkan data"
    ];
    goto output;
}

if ($modul_tree) {
    $response = [
        "error" => false,
        "data" => $modul_tree
    ];
} else {
    http_response_code(404);
    $response = [
        "error" => true,
        "message" => "Modul tidak tersedia"
    ];
}

output: {
    echo json_encode($response);
}

function validate_input()
{
    return isset($_GET["id"]) && is_numeric($_GET["id"]);
}
