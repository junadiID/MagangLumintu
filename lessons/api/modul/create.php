<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once "../../model/Modul.php";

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
    "modul_name" => $_POST['modul_name'],
    "modul_description" => !isset($_POST['modul_description']) ? "" : $_POST['modul_description'],
    "modul_weight" => !isset($_POST['modul_weight']) ? null : $_POST['modul_weight'],
    "status" => !isset($_POST['status']) ? 0 : $_POST['status'],
    "parent_id" => !isset($_POST['parent_id']) ? null : $_POST['parent_id'],
    "batch_id" => !isset($_POST['batch_id']) ? null : $_POST['batch_id'],
];

try {
    $modul = new Modul();
    $insert_id = $modul->createModul($data);
} catch (PDOException $e) {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal menambahkan modul"
    ];
    goto output;
}

if ($insert_id) {
    $response = [
        "error" => false,
        "message" => "Berhasil tambah modul",
        "insertedId" => $insert_id
    ];
    goto output;
} else {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal menambahkan modul"
    ];
    goto output;
}

output: {
    echo json_encode($response);
}

//PERLU DICEK LAGI UNTUK KOLOM LAINNYA
function validate_input()
{
    return isset($_POST['modul_name']) && $_POST['modul_name'] && isset($_POST['status']) && is_numeric($_POST['status']);
}
/*
Valid ketika
- terdapat key modul_name
- value modul_name tidak empty
- terdapat key status
- value status tidak empty
*/

/*
Contoh response success:
{
    "error": false,
    "message": "Berhasil tambah modul",
    "insertedId": "31"
}
*/
