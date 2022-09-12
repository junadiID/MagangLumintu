<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if (!validate_input()) {
    http_response_code(400);
    $response = [
        "error" => true,
        "message" => "Data ID tidak valid"
    ];
    goto output;
}

require_once "../../model/Modul.php";
$modul = new Modul();
$id = $_GET['id'];

try {
    $row = $modul->searchByParentId($id);
} catch (PDOException $e) {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal mendapatkan data"
    ];
    goto output;
}

// row bisa aja empty
$response = [
    "error" => false,
    "data" => $row
];

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
    "data": [
        {
            "id": "5",
            "modul_name": "PHP Dasar",
            "status": "draft",
            "parent_id": "1",
            "batch_id": null
        },
        {
            "id": "6",
            "modul_name": "PHP Intermediate",
            "status": "draft",
            "parent_id": "1",
            "batch_id": null
        },
        {
            "id": "7",
            "modul_name": "PHP Advanced",
            "status": "draft",
            "parent_id": "1",
            "batch_id": null
        }
    ]
}
*/
