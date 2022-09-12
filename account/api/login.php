<?php

require_once "Model.php";

require "../vendor/autoload.php";

use Firebase\JWT\JWT;
use Dotenv\Dotenv;

// Load dotenv
$dotenv = Dotenv::createImmutable(dirname(__DIR__ . "../"));
$dotenv->load();

// CORS Configuration to Allow request
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

// Just Allow Request Method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit();
}

// GET Request from User
$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$role = $data->role;
$password = $data->password;


// Check request without Body
if (!isset($email) || !isset($password)) {
  http_response_code(400);
  exit();
}

$user = new User();

if ($user->check_email($email)) {
  if ($user->login_user($email, $password)) {

    // Expired time for Token
    $expired_time = time() + (60 * 60);

    $payload = [
      'email' => $email,
      'exp' => $expired_time
    ];

    // Generate Token JWT
    $access_token = JWT::encode($payload, $_ENV['ACCESS_TOKEN_SECRET'], 'HS256');

    // Response to user
    echo json_encode([
      'success' => true,
      'data' => [
        'accessToken' => $access_token,
        'expiry' => date(DATE_ISO8601, $expired_time)
      ],
      'message' => 'Login berhasil!'
    ]);

    // Extended expired time for refresh token be 1 Hour
    $payload['exp'] = time() + (60 * 60);
    $refresh_token = JWT::encode($payload, $_ENV['REFRESH_TOKEN_SECRET'], 'HS256');

    // Save refresh token in cookie
    setcookie('X-LUMINTU-REFRESHTOKEN', $refresh_token, $payload['exp'], '', '', false, true);

  }
  else {

    header('Content-Type: application/json');

    echo json_encode([
      'success' => false,
      'data' => null,
      'message' => 'Email atau password tidak sesuai'
    ]);
    exit();

  }

}
else {

  header('Content-Type: application/json');

  echo json_encode([
    'success' => false,
    'data' => null,
    'message' => 'Email belum terdaftar'
  ]);
  exit();
}

?>