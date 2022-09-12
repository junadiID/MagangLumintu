<?php

require_once "Model.php";

require "../vendor/autoload.php";

// Import library
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__ . "../"));
$dotenv->load();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit();
}

$headers = getallheaders();

// Check the request with Header Auth
if (!isset($headers['Authorization'])) {
    http_response_code(401);
    exit();
}

$user = new User();

// Get Token
list(, $token) = explode(' ', $headers['Authorization']);


try {
    // Decode the token be JSON 
    $payload = JWT::decode($token, new Key($_ENV['ACCESS_TOKEN_SECRET'], 'HS256'));
    if ($_GET) {
        $batch = $user->get_batchs($_GET['batch_id']);
    }
    else {
        $batch = $user->get_batch();
    }
    echo json_encode([
        'success' => true,
        "batch" => $batch,

    ]);



}
catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'data' => null,
        'message' => 'Data gagal diload'
    ]);
    http_response_code(401);
    exit();
}
