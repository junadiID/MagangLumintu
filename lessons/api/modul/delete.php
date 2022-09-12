<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    http_response_code(405);
    $response = [
        "error" => true,
        "message" => "'GET' method not allowed"
    ];
    goto output;
}

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
$id = $_POST["id"];

try {
    $delete_id = $modul->deleteModulById($id);
} catch (PDOException $e) {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal menghapus modul"
    ];
    goto output;
}

if ($delete_id) {
    $response = [
        "error" => false,
        "message" => "Berhasil hapus modul",
        "deletedId" => $delete_id
    ];
} else {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal menghapus modul"
    ];
}

output: {
    echo json_encode($response);
}

function validate_input()
{
    return isset($_POST["id"]) && is_numeric($_POST["id"]);
}

/*
Contoh response yg berhasil:
{
    "error": false,
    "message": "Berhasil hapus modul",
    "deletedId": "31"
}
*/