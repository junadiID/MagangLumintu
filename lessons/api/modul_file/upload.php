<?php
//Header
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    http_response_code(405);
    $response = [
        "error" => true,
        "message" => "'GET' method not allowed"
    ];
    goto output;
}

// validasi payload
if (!validate_input()) {
    http_response_code(400);
    $response = [
        "error" => true,
        "message" => "Inputan tidak valid. Pastikan inputan modul_id dan file sudah sesuai."
    ];
    goto output;
}

// cek modul_id exist
require_once "../../model/Modul.php";
$modul = new Modul();

try {
    $row = $modul->readSingleModul($_POST["modul_id"]);
    if (!$row) {
        http_response_code(404);
        $response = [
            "error" => true,
            "message" => "Modul ID tidak tersedia"
        ];
        goto output;
    }
} catch (PDOException $e) {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal validasi modul_id"
    ];
    goto output;
}

// cek apakah file berhasil upload di folder temp. value 0 artinya tidak error
$is_upload_not_error = $_FILES['file']['error'] == 0;
if (!$is_upload_not_error) {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal upload file ke direktori temp sever"
        // TODO message diganti jadi dictionary error code
    ];
    goto output;
}

$tmp_file_path = $_FILES['file']['tmp_name'];
$tmp_file_size = filesize($tmp_file_path);

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$tmp_file_type = finfo_file($finfo, $tmp_file_path);
finfo_close($finfo);

require_once "Uploader.php";
$upload_handler = new UploadHandler();

// cek mime type
if (!$upload_handler->isValidType($tmp_file_type)) {
    http_response_code(400);
    $response = [
        "error" => true,
        "message" => "Jenis file {$tmp_file_type} tidak diperbolehkan"
    ];
    goto output;
}

// cek size file apakah melebihi limit
if (!$upload_handler->isValidSize($tmp_file_size)) {
    http_response_code(400);
    $response = [
        "error" => true,
        "message" => "Size mencapai limit " . ($upload_handler->getMaxSize() / 1000000) . "MB"
    ];
    goto output;
}

// project root dir: '../../'
// base upload dir: '../../uploads/';
// file upload location: '../../uploads/{modul_id}/{file_name}'

$modul_id = $_POST['modul_id'];
$base_upload_dir = "../../uploads/";
$modul_file_dir = $base_upload_dir . $modul_id . "/";

//Buat direktori jika belum ada
if (!is_dir($modul_file_dir)) {
    if (is_writable("../../")) {
        if (!mkdir($modul_file_dir, 0777, true)) {
            http_response_code(500);
            $response = [
                "error" => true,
                "message" => "Gagal membuat folder"
            ];
            goto output;
        }
    } else {
        http_response_code(500);
        $response = [
            "error" => true,
            "message" => "Gagal membuat folder, cek access permission"
        ];
        goto output;
    }
}

//move uploaded file
$file_name = $_FILES['file']['name'];
$server_file_name = $upload_handler->appendFileNameWithDate($file_name);
$file_path = $modul_file_dir . $server_file_name;
$is_success_move = move_uploaded_file($tmp_file_path, $file_path);

if (!$is_success_move) {
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Server gagal memindahkan file"
    ];
    goto output;
}

// insert database
$data = [
    "modul_id" => $_POST['modul_id'],
    "file_name" => $file_name,
    "file_size" => $tmp_file_size,
    "file_type" => $tmp_file_type,
    "file_url" => "uploads/" . $modul_id . "/" . $server_file_name

];

/*
di root folder lessons
echo realpath("api/");
/media/fe1/Repo-Data/lumintu_lms/lessons/api
*/

require_once "../../model/ModulFile.php";
$modul_file = new ModulFile();

try {
    $insert_id = $modul_file->insertFileData($data);
} catch (PDOException $e) {
    // hapus file
    if (file_exists($file_path)) {
        unlink($file_path);
    }
    http_response_code(500);
    $response = [
        "error" => true,
        "message" => "Gagal insert data tabel"
    ];
    goto output;
}

// cek apakah data file masuk database
if (!$insert_id) {
    //delete file
    if (file_exists($file_path)) {
        unlink($file_path);
    }

    $response = [
        "error" => true,
        "message" => "Gagal insert data file ke database"
    ];
    goto output;
}

$response = [
    "error" => false,
    "data" => [
        "insertedId" => $insert_id,
        "fileName" => $file_name,
        "fileUrl" => $data["file_url"]
    ]
];


output: {
    echo json_encode($response);
}

function validate_input()
{
    return isset($_POST["modul_id"]) && is_numeric($_POST["modul_id"]) &&
        isset($_FILES["file"]) && !empty($_FILES["file"]["name"]);
}
