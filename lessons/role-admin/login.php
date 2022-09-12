<?php

session_start();

// if (isset($_POST['login'])) {
//     require dirname(__FILE__) . "/Model/Users.php";
//     $objUser = new Users;
//     $login = $objUser->loginUser($_POST);

//     if ($login['is_ok']) {
//         $_SESSION['user'] = $login['data'];
//         switch ($login['data']['role']) {
//             case 1:
//                 header("location: ./Role/Student/index.php");
//                 break;
//             case 2:
//                 header("location: ./Role/Mentor/index.php");
//                 break;
//             default:
//                 # code...
//                 break;
//         }
//     }
// }

if(isset($_POST['login'])) {
    require_once "./api/get_api_data.php";

    $userData = array();

    $dataFromApi = json_decode(http_request("https://i0ifhnk0.directus.app/items/user"));

    for($i = 0; $i < count($dataFromApi->{'data'}); $i++) {        
        if($dataFromApi->{'data'}[$i]->{'user_username'} == $_POST['username']) {
            array_push($userData, $dataFromApi->{'data'}[$i]);
        }
    }

    if($userData[0]->{'user_password'} == $_POST['password']) {
        $_SESSION['user'] = $userData[0];
        switch($_SESSION['user']->{'role_id'}) {
            case 1:
                break;
            case 2:
                header("location: ./Role/Mentor/index.php");
                break;
            case 3:
                header("location: ./Role/Student/index.php");
                break;
            default:
                break;
        };
    }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/swiper-bundle.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    

    <title>Form Login</title>
    <style>
    .forgot:hover
    {
        color:#CCA274 !important;
    }
    .btn-primary
    {
        background-color: #DDB07F !important;
        border-color: #DDB07F !important;
    }
    .btn-primary:hover
    {
        background-color: #CCA274 !important;
        border-color: #CCA274 !important;
    }
    .btn-primary:active
    {
        background-color: #CCA274 !important;
        border-color: #CCA274 !important;
    }
    .btn-primary:visited
    {
        background-color: #CCA274 !important;
        border-color: #CCA274 !important;
    }

    </style>
  </head>
  <body class="gradient-background">

    <section class="form-login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 d-flex align-items-center mt-5 mt-lg-0">
                    <div class="container custom--px">
                        <div class="logo text-center">
                          <h4>FORM LOGIN</h4>
                          <img class="w-[130px] logo-prokid" src="../Img/logo/Logo-prokid.png" alt="Logo In Career">
                        </div>
                        <div class="header-title text-center">
                          <h2>Join for the Bright Future</h2>
                          <small class="text-muted">In Career is an LMS that focuses on career development in IT from Lumintu Logic with participants aged 25 years and over, who want to develop their careers in the IT field. </small>
                        </div>
                        <form method="post" action="#" class="mt-5">
                          <div class="container d-flex justify-content-between align-content-center form-group">
                            <div class="input-group">
                              <input type="text" name="username" id="username" required >
                              <label for="username">Enter your Username</label>
                            </div>
                            <div class="box d-flex align-items-center">
                              <i class="fas fa-at"></i>
                            </div>
                          </div>
                          <br>
                          <div class="container d-flex justify-content-between align-content-center form-group">
                            <div class="input-group">
                              <input type="password" name="password" id="password" required>
                              <label for="password">Enter your Password</label>
                            </div> 
                          </div>
                          <!-- <div class="container d-flex justify-content-between align-content-center form-group  mt-4">
                            <select class="form-select" aria-label="Default select example">
                              <option selected>Select Role</option>
                              <option value="Students">Student</option>
                              <option value="Company">Company</option>
                              <option value="Mentor">Mentor</option>
                            </select>
                          </div> -->
                          <div class="container d-flex justify-content-end align-content-center form-group mt-3">
                              <!-- <div class="check-group">
                                <input type="checkbox" name="remember"> &nbsp; Remember Me
                              </div> -->
                              <a href="forgotpassword.html"style="color:#DDB07F;" class="forgot">Forgot the Password</a>
                          </div>
                          <div class="container mt-5">
                            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                          </div>
                          
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="js/swiper-bundle.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>