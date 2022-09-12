<?php

require_once 'core/init.php';

if (!$user->is_loggedIn()) {
    Session::flash('login', 'Anda harus login terlebih dahulu');
    Redirect::to('login');
}


if (!$user->is_admin(Session::get('email')) && !$user->is_mentor(Session::get('email')) ) {
    Redirect::to('403');
}

$value = $_GET["user_email"];

$user->delete_user("user", "user_email", $value);

Session::flash("users", "Akun Berhasil dihapus");
Redirect::to('users');


?>