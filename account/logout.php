<?php 

require_once "core/init.php";

unset($_SESSION['email']);
unset($_SESSION['jwt']);
unset($_SESSION['expiry']);
unset($_SESSION['user_data']);
Redirect::to('login');