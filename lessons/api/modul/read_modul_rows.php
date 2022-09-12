<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once "../../model/Modul.php";

try {
    $modul = new Modul();
    $moduls_tree = $modul->readAllModulRows();
} catch (PDOException $e) {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal mendapatkan data"
    ];
    goto output;
}

// bisa aja empty
if ($moduls_tree || empty($moduls_tree)) {
    $response = [
        "error" => false,
        "data" => $moduls_tree
    ];
    goto output;
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
