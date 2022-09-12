<?php

require_once 'core/init.php';

if (!$user->is_loggedIn()) {
    Session::flash('login', 'Anda harus login terlebih dahulu');
    Redirect::to('login');
}


if (!$user->is_admin(Session::get('email')) && !$user->is_mentor(Session::get('email')) ) {
    Redirect::to('403');
}

$errors = array();

// Delete batch
$id = $_GET["batch_id"];

$batch->delete_batch($id);

Session::flash("batch", "Batch Berhasil dihapus");
Redirect::to('batch');


?>