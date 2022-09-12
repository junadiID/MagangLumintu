<?php
if (!validate_input()) {
    echo "
    <script>
        alert('Parameter tidak valid');
        location.replace('formData.php');
    </script>";
    die;
}

$token = $_GET["token"];
$expiry = $_GET["expiry"];

// var_dump($_GET["expiry"]);
// die;

$userData = json_decode(http_request("https://lumintulearning.tech/account/api/user.php", $token));
if (!$userData) {
    echo "
    <script>
        alert('Gagal mendapatkan data user');
        location.replace('formData.php');
    </script>";
    die;
}

// var_dump($userData);die;

session_start();
$_SESSION['user_data'] = $userData;
$_SESSION['expiry'] = $expiry;
// setcookie('X-LUMINTU-REFRESHTOKEN', $token, strtotime($expiry));

if (!isset($_SESSION['user_data'])) {
    echo "
    <script>
        alert('Gagal set Session');
        location.replace('formData.php');
    </script>";
    die;
}
// var_dump($_SESSION['user_data']);die;

if (!setcookie('X-LUMINTU-REFRESHTOKEN', $token, strtotime($expiry))) {
// if (!isset($_COOKIE['X-LUMINTU-REFRESHTOKEN'])) {
    echo "
    <script>
        alert('Gagal set Cookie');
        location.replace('formData.php');
    </script>";
    die;
}
// var_dump($_COOKIE['X-LUMINTU-REFRESHTOKEN']);die;

            switch ($userData->{'user'}->{'role_id'}) {
                case 1:
                    // Admin
                    header("location: role-admin/list-modul.php");
                    break;
                case 2:
                    // Mentor
                    header("location: role-mentor/list-modul.php");
                    break;
                default:
                    echo "
                    <script>
                        alert('Akses ditolak!');
                        location.replace('https://lumintulearning.tech/account/login.php');
                    </script>";
                    break;
            }

function validate_input()
{
    return isset($_GET["token"]) && $_GET["token"] && isset($_GET["expiry"]) && $_GET["expiry"];
}

function http_request($url, $token)
{
    $ch = curl_init();
    $auth = "Authorization: Bearer " . $token;

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $auth));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $out = curl_exec($ch);

    curl_close($ch);
    return $out;
}