<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once "../../model/Modul.php";

try {
    $modul = new Modul();
    $rows = $modul->readSuperModuls();
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

/*
Contoh response yang berhasil:
{
    "error": false,
    "data": [
        {
            "id": "1",
            "status": "draft",
            "modul_name": "PHP",
            "parent_id": null,
            "batch_id": null
        },
        {
            "id": "2",
            "status": "draft",
            "modul_name": "Javascript",
            "parent_id": null,
            "batch_id": null
        }
    ]
}
*/
