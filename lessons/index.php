<?php
session_start();
if (!isset($_SESSION['user_data'])) { //if login in session is not set
    header("Location: https://lumintulearning.tech/account/login.php");
    die;
}

if (!isset($_COOKIE['X-LUMINTU-REFRESHTOKEN'])) {
    unset($_SESSION['user_data']);
    header("Location: https://lumintulearning.tech/account/login.php");
    die;
}

$role = $_SESSION['user_data']->user->role_id;
switch ($role) {
    case 1:
        //admin
        header("location: ../role-admin/list-modul.php");
        break;
    case 2:
        // Mentor
        header("location: ../role-mentor/list-modul.php");
        break;
    default:
        echo "
        <script>
            alert('Akses ditolak!');
            location.replace('https://lumintulearning.tech/account/login.php');
        </script>";
        break;
}
?>
