<?php

require_once "Model.php";

require "../vendor/autoload.php";

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

if (!isset($headers['Authorization'])) {
    http_response_code(401);
    exit();
}

$user = new User();

list(, $token) = explode(' ', $headers['Authorization']);

try {
    $payload = JWT::decode($token, new Key($_ENV['ACCESS_TOKEN_SECRET'], 'HS256'));
    $user_data = $user->get_data($payload->{ 'email'});
    $users = $user->get_users($user_data['batch_id']);
    echo json_encode([
        'success' => true,
        "user" => $users,
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
