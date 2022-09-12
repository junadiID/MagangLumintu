<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    http_response_code(405);
    $response = [
        "error" => true,
        "message" => "Use 'Post' instead of 'GET'"
    ];
    goto output;
}

if (!validate_input()) {
    http_response_code(400);
    $response = [
        "error" => true,
        "message" => "Data input tidak valid"
    ];
    goto output;
}

$data = [
    "id" => $_POST['id'],
    "modul_name" => $_POST['modul_name'],
    "modul_description" => !isset($_POST['modul_description']) ? "" : $_POST['modul_description'],
    "modul_weight" => !isset($_POST['modul_weight']) ? null : $_POST['modul_weight'],
    "status" => $_POST['status'],
    "parent_id" => !isset($_POST['parent_id']) ? null : $_POST['parent_id'],
    "batch_id" => !isset($_POST['batch_id']) ? null : $_POST['batch_id'],
];

require_once "../../model/Modul.php";
$modul = new Modul();

try {
    $update_id = $modul->updateModul($data);
} catch (PDOException $e) {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal update modul"
    ];
    goto output;
}

if ($update_id) {
    $response = [
        "error" => false,
        "message" => "Berhasil ubah modul",
        "updatedId" => $update_id
    ];
} else {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal update modul"
    ];
}

output: {
    echo json_encode($response);
}

//PERLU DICEK LAGI UNTUK KOLOM LAINNYA
function validate_input()
{
    return isset($_POST['id']) && is_numeric($_POST['id']) && isset($_POST['modul_name']) && $_POST['modul_name'] && isset($_POST['status']) && is_numeric($_POST['status']);
}

/*
Valid ketika
- terdapat key id
- value id tidak empty
- terdapat key modul_name
- value modul_name tidak empty
- terdapat key status
- value status tidak empty
*/

/*
Contoh response yang berhasil:
{
    "error": false,
    "message": "Berhasil ubah modul",
    "insertedId": "30"
}
*/
