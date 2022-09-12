<?php

require_once 'core/init.php';

require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer();

$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Host = 'in-v3.mailjet.com';
$mail->SMTPAuth = true;
$mail->Username = $_ENV['MAILJET_PUBLIC_KEY'];
$mail->Password = $_ENV['MAILJET_PRIVATE_KEY'];
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('email_pengirim', 'no-reply');

$mail->isHTML(true);

if (!$user->is_loggedIn()) {
    Session::flash('login', 'Anda harus login terlebih dahulu');
    Redirect::to('login');
}


if (!$user->is_admin(Session::get('email')) && !$user->is_mentor(Session::get('email'))) {
    Redirect::to('403');
}

$user_data = $user->get_data(Session::get('email'));

if ($_GET) {
    $_user = $user->get_data($_GET['user_email']);
}

$errors = array();

if (isset($_POST['submit'])) {
    if (Token::check($_POST['token'])) {


        $validation = new Validation();

        $validation = $validation->check(array(
            'username' => array(
                'required' => true,
                'max' => 50,
            ),
            'email' => array(
                'required' => true,
                'min' => 6,
            ),
            'password' => array(
                'required' => true,
                'min' => 8,
            ),
            'role' => array(
                'required' => true,
            ),
            'batch' => array(
                'required' => true,
            ),
        ));

        if ($_GET) {
            $role = $_POST['role'];
            $batch = $_POST['batch'];

            $user->update_user(array(
                'user_username' => $_POST['username'],
                'user_email' => $_POST['email'],
                'role_id' => (int)$role,
                'batch_id' => (int)$batch,
            ), $_POST['email']);

            Session::flash("users", "Data berhasil diubah!");
            Redirect::to("users");
        } else {


            if ($validation->passed()) {
                $token = base64_encode(random_bytes(32));
                $role = $_POST['role'];
                $batch = $_POST['batch'];

                $user->verifikasi_account(array(
                    'user_email' => $_POST['email'],
                    'user_token' => $token,
                    'date_created' => time()
                ));

                $mail->Subject = "Silahkan Verifikasi Email";
                $mail->addAddress($_POST['email'], $_POST['username']);
                $email_template = 'templates/activation.html';
                $mail->Body = file_get_contents($email_template);
                $mail->addEmbeddedImage('assets/img/logo.png', 'image_cid');

                $link = ($_SERVER['HTTP_HOST'] . "/login.php" . "?email=" . $_POST['email'] . "&token=" . urlencode($token));
                $username = $_POST['username']; 

                $key = array('{link}', '{username}');
                $value = array($link, strtoupper($username));
                $mail->Body = str_replace($key, $value,  $mail->Body);

                if (!$mail->send()) {
                    
                    $errors[] = "Pesan tidak dapat dikirim, coba lagi beberapa saat.";
                } else {
                    $user->register_user(array(
                        'user_username' => $_POST['username'],
                        'user_email' => $_POST['email'],
                        'user_password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                        'role_id' => (int)$role,
                        'batch_id' => (int)$batch,
                        'date_created' => time()
                    ), $_POST['email']);

                    Session::flash("users", "Data berhasil ditambah!");
                    Redirect::to("users");
                }
            } else {
                $errors = $validation->errors();
            }
        }
    }
}


$roles = $user->get_roles(); 
$batch = $batch->get_batch(); 

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/icons/logo.ico" type="image/x-icon">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    <title><?php if ($_GET) :  ?> Edit user <?php else : ?> Add user <?php endif; ?>| Lumintu Classsroom</title>

    <!-- Flowbite CSS -->
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.1/dist/flowbite.min.css" />

    <!-- Icon Getbootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <!-- CDN TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        montserrat: ["Montserrat"],
                    },
                    colors: {
                        "dark-green": "#1E3F41",
                        "light-green": "#659093",
                        "cream": "#DDB07F",
                        "cgray": "#F5F5F5",
                    }
                }
            }
        }
    </script>
    <style>
        .in-active {
            width: 80px !important;
            padding: 20px 15px !important;
            transition: .5s ease-in-out;
        }

        .in-active ul li p {
            display: none !important;
        }

        .in-active ul li a {
            padding: 15px !important;
        }

        .in-active h2,
        .in-active h4,
        .in-active .logo-gradit {
            display: none !important;
        }

        .hidden {
            display: none !important;
        }

        .sidebar {
            transition: .5s ease-in-out;
        }
    </style>

</head>

<body>
    <div class="flex items-center">

        <?php require_once 'templates/sidebar.php' ?>


        <!-- Right side -->
        <div class="bg-gray-100 w-full h-screen px-10 py-6 flex flex-col gap-y-6 overflow-y-scroll">
            <!-- Header / Profile -->
            <div class="flex items-center gap-x-4 justify-end">
                <p class="text-dark-green font-semibold text-sm">
                    <?php echo $user_data['user_email'] ?>
                </p>
                <div x-data="{ open: false }" @mouseleave="open = false" class="relative">
                    <button @mouseover="open = true">
                        <img class="w-10" src="assets/icons/default_profile.svg" alt="Profile Image">
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open" class="absolute right-0 w-48 bg-white rounded-md">
                        <a href="account-settings.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-400 hover:text-white">
                            Account Settings
                        </a>
                    </div>
                </div>
            </div>

            <!-- Breadcrumb -->
            <div class="flex justify-between">
                <a href="users.php" class="text-[#bd9161] bg-gray-50 hover:bg-[#bd9161] border border-[#bd9161] hover:text-white focus:ring-4 focus:outline-none focus:ring-[#DDB07F] font-medium rounded-lg text-sm px-5 py-1.5 text-center inline-flex items-center mr-2">
                    <svg class="w-6 h-6 mr-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                    </svg>
                    Back
                </a>
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="dashboard.php" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                            <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <li class="inline-flex items-center">
                        <a href="users.php" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                            <svg width="18" height="18" viewBox="0 0 25 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_92_870)">
                                    <path d="M21.1209 5.412C21.1206 6.30054 20.8996 7.17535 20.4774 7.9592C20.0553 8.74306 19.4449 9.41186 18.7002 9.90658C17.9555 10.4013 17.0994 10.7067 16.2074 10.7959C15.3155 10.885 14.4151 10.7552 13.5857 10.4178C14.5869 10.0098 15.4432 9.31601 16.0459 8.42464C16.6485 7.53327 16.9702 6.4845 16.9702 5.41153C16.9702 4.33856 16.6485 3.2898 16.0459 2.39843C15.4432 1.50706 14.5869 0.813302 13.5857 0.405261C14.4151 0.0678512 15.3156 -0.0619823 16.2077 0.0272223C17.0997 0.116427 17.9559 0.421926 18.7006 0.916749C19.4453 1.41157 20.0557 2.0805 20.4778 2.86448C20.8999 3.64846 21.1207 4.52338 21.1209 5.412Z" fill="#1E3F41" />
                                    <path d="M25.0001 20H20.8489C20.8489 15.5956 17.7444 12.6312 13.5857 11.8959C14.2713 11.7738 14.9666 11.7125 15.6632 11.7128C20.8217 11.7128 25.0001 14.8882 25.0001 20Z" fill="#1E3F41" />
                                    <path d="M9.33873 10.8231C12.354 10.8231 14.7983 8.40044 14.7983 5.41196C14.7983 2.42349 12.354 0.000854492 9.33873 0.000854492C6.32349 0.000854492 3.87915 2.42349 3.87915 5.41196C3.87915 8.40044 6.32349 10.8231 9.33873 10.8231Z" fill="#1E3F41" />
                                    <path d="M0 20C0 14.8882 4.1812 11.7128 9.33877 11.7128C14.4963 11.7128 18.6785 14.8845 18.6785 19.9963" fill="#1E3F41" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_92_870">
                                        <rect width="25" height="20" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <span class="pl-3">Users</span>
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-400 md:ml-2 dark:text-gray-500">Add user</span>
                        </div>
                    </li>
                </ol>
            </div>

            <?php if (!empty($errors)) { ?>

                <?php foreach ($errors as $error) : ?>
                    <div id="alert-1" class="flex p-4 bg-blue-100 rounded-lg dark:bg-blue-200" role="alert">
                        <svg class="flex-shrink-0 w-5 h-5 text-blue-700 dark:text-blue-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-3 text-sm font-medium text-blue-700 dark:text-blue-800">
                            <?php echo $error; ?>
                        </div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-blue-100 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex h-8 w-8 dark:bg-blue-200 dark:text-blue-600 dark:hover:bg-blue-300" data-dismiss-target="#alert-1" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                <?php endforeach; ?>

            <?php } ?>

            <?php if (Session::exists('user-add')) { ?>

                <div id="alert-1" class="flex p-4 mb-4 mt-5 bg-blue-100 rounded-lg dark:bg-blue-200" role="alert">
                    <svg class="flex-shrink-0 w-5 h-5 text-blue-700 dark:text-blue-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3 text-sm font-medium text-blue-700 dark:text-blue-800">
                        <?php echo Session::flash('user-add'); ?>
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-blue-100 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex h-8 w-8 dark:bg-blue-200 dark:text-blue-600 dark:hover:bg-blue-300" data-dismiss-target="#alert-1" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

            <?php } ?>

            <div class="sm:col-span-2 bg-white rounded-md p-8 shadow-sm md:mb-40">
                <h3 class="text-2xl pb-5"><?php if ($_GET) :  ?> Edit user <?php else : ?> Add user <?php endif; ?></h3>
                <div class="pl-12 pr-12 pt-4 pb-12 bg-gray-50 rounded-lg" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form class="space-y-6" method="POST">
                        <div>
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                            <input type="text" name="user_id" hidden value="<?php echo $_user['user_id'] ?>">
                        </div>

                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                            <input type="text" name="username" id="username" placeholder="username" value="<?php echo $_user['user_username'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input type="email" name="email" id="email" <?php if ($_GET) : ?> readonly <?php endif; ?> placeholder="alamat email" value="<?php echo $_user['user_email'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <?php if (!$_GET) : ?>
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                                <input type="password" name="password" id="password" placeholder="kata sandi" value="<?php echo $_user['user_password'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <div class="flex flex-row justify-between mt-2">
                                    <button type="button" class="text-[#bd9161]" onclick="genPassword()">Generate</button>
                                    <button type="button" id="button" class="text-[#bd9161]" onclick="copyPassword()">Copy</button>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div>
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role</label>
                            <select id="role" name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="<?php echo $_user['role_id'] ?>"><?php echo $_user['role_id'] ?></option>
                                <?php foreach ($roles as $_roles) : ?>
                                    <option value="<?php echo $_roles['role_id'] ?>"><?php echo $_roles['role_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="batch" class="block mb-2 text-sm font-medium text-gray-900">Batch</label>
                            <select id="batch" name="batch" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="<?php echo $_user['batch_id'] ?>"><?php echo $_user['batch_id'] ?></option>
                                <?php foreach ($batch as $_batch) : ?>
                                    <option value="<?php echo $_batch['batch_id'] ?>"><?php echo $_batch['batch_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" name="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
        <script defer src="https://unpkg.com/alpinejs@3.2.4/dist/cdn.min.js"></script>
        <script>
            let btnToggle = document.getElementById('btnToggle');
            let sidebar = document.querySelector('.sidebar');
            btnToggle.onclick = function() {
                sidebar.classList.toggle('in-active');
            }

            // For Generate Password
            var password = document.getElementById("password");

            function genPassword() {
                var chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                var passwordLength = 12;
                var password = "";
                for (var i = 0; i <= passwordLength; i++) {
                    var randomNumber = Math.floor(Math.random() * chars.length);
                    password += chars.substring(randomNumber, randomNumber + 1);
                }
                document.getElementById("password").value = password;
            }

            function copyPassword() {
                var copyText = document.getElementById("password");
                copyText.select();
                navigator.clipboard.writeText(copyText.value);
                document.execCommand("copy");
            }
        </script>
</body>

</html>