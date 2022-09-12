<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: * ');
header('Content-Type: application/json');

require_once "../../model/ModulFile.php";

if (!validate_input()) {
    http_response_code(400);
    $response = [
        "error" => true,
        "message" => "Data ID tidak valid"
    ];
    goto output;
}

$id = $_GET['id'];
$modul_file = new ModulFile();
try {
    $row = $modul_file->readFilesByModul($id);
} catch (PDOException $e) {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal mendapatkan data"
    ];
    goto output;
}

if ($row || empty($row)) {
    $response = [
        "error" => false,
        "data" => $row
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
    return isset($_GET["id"]) && is_numeric($_GET["id"]);
}
