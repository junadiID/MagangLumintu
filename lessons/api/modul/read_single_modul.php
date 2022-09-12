<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once "../../model/Modul.php";

if (!validate_input()) {
    http_response_code(400);
    $response = [
        "error" => true,
        "message" => "Data ID tidak valid"
    ];
    goto output;
}

$id = $_GET['id'];
$modul = new Modul();

try {
    $row = $modul->readSingleModul($id);
} catch (PDOException $e) {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal mendapatkan data"
    ];
    goto output;
}

if ($row) {
	$row['modul_description'] = htmlspecialchars_decode($row['modul_description']);
    $response = [
        "error" => false,
        "data" => $row
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

/*
Contoh response yang berhasil:
{
    "error": false,
    "data": {
        "id": "2",
        "status": "draft",
        "modul_name": "Javascript",
        "parent_id": null,
        "batch_id": null
    }
}
*/
