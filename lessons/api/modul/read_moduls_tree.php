<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once "../../model/Modul.php";

try {
    $modul = new Modul();
    $moduls_tree = $modul->readModulTree(null);
} catch (PDOException $e) {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal mendapatkan data"
    ];
    goto output;
}

if ($moduls_tree || empty($modul_tree)) {
    $response = [
        "error" => false,
        "data" => $moduls_tree
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
            "modul_name": "PHP",
            "child": [
                {
                    "id": "5",
                    "modul_name": "PHP Dasar",
                    "child": [
                        {
                            "id": "8",
                            "modul_name": "PHP Control Flow"
                        },
                        {
                            "id": "9",
                            "modul_name": "PHP Variable"
                        }
                    ]
                },
                {
                    "id": "6",
                    "modul_name": "PHP Intermediate",
                    "child": [
                        {
                            "id": "10",
                            "modul_name": "PHP Array"
                        },
                        {
                            "id": "11",
                            "modul_name": "PHP Object"
                        }
                    ]
                },
                {
                    "id": "7",
                    "modul_name": "PHP Advanced",
                    "child": [
                        {
                            "id": "12",
                            "modul_name": "PHP File Handling"
                        },
                        {
                            "id": "13",
                            "modul_name": "PHP File Upload"
                        }
                    ]
                }
            ]
        },
        {
            "id": "2",
            "modul_name": "Javascript",
            "child": [
                {
                    "id": "14",
                    "modul_name": "Javascript Basic",
                    "child": [
                        {
                            "id": "17",
                            "modul_name": "Javascript Syntax"
                        },
                        {
                            "id": "18",
                            "modul_name": "Javascript Variable"
                        },
                        {
                            "id": "19",
                            "modul_name": "Javascript Control"
                        }
                    ]
                },
                {
                    "id": "15",
                    "modul_name": "Javascript Intermediate"
                },
                {
                    "id": "16",
                    "modul_name": "Javascript Advanced",
                    "child": [
                        {
                            "id": "20",
                            "modul_name": "JSON"
                        },
                        {
                            "id": "21",
                            "modul_name": "AJAX"
                        }
                    ]
                },
                {
                    "id": "30",
                    "modul_name": "Update Tes"
                }
            ]
        }
    ]
}
*/
