<?php

require_once "core/init.php";
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

if ( $user->is_loggedIn() ) {
    Redirect::to('account-settings');
}

$errors = array();


// Mengecek Method yang di Request
if ( isset($_POST['submit']) ) {
    
    // Mengecek token csrf yang di request
    if ( Token::check( $_POST['token'] ) ) { 

        // Memanggil fungsi validation object
        $validation = new Validation();

        // Lakukan pengecekan form yang di input user
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
            'password_verify' => array(
                        'required' => true,
                        'match' => 'password',
                        ),
        ));


        if ($user->check_email($_POST['email'])) { // Mengecek email apakah sudah terdaftar atau belum di Database

            $info[] = "Akun email sudah terdaftar";
    
        } else if ($user->check_username($_POST['username'])) { // Mengecek username apakah sudah terdaftar atau belum di Database

            $info[] = "Username sudah terdaftar";

        } else { 

            if ($validation->passed()) { // Jika validasi berhasil, baris dibawah ini akan dieksekusi

                $token = base64_encode(random_bytes(32)); // Generate random base64, untuk token reset password / email verifikasi user

                /* Memanggil fungsi send_mail() dan Menyimpan data sementara user, 
                untuk kegunaan mengirim Token reset password dan Email Verifikasi ke akun Email user */
                $user->verifikasi_account(array(
                    'user_email' => $_POST['email'],
                    'user_token' => $token,
                    'date_created' => time()
                ));

                // Baris berikut untuk melakukan proses pengiriman Email ke kaun Email user 
                $mail->Subject = "Selamat Datang di Lumintu Learning!"; // subject untuk pesan email yang dikirim.
                $mail->addAddress($_POST['email'], $_POST['username']); // email tujuan pesan dikirim.
                $email_template = 'templates/activation.html'; // template pengiriman pesan email
                $mail->Body = file_get_contents($email_template); 
                $mail->addEmbeddedImage('assets/img/logo.png', 'image_cid');  // gambar yang di butuhkan untuk dimasukan ke pesan email
                $link = ($_SERVER['HTTP_HOST'] . "/login.php" . "?email=" . $_POST['email'] . "&token=" . urlencode($token)); // link yang akan dikirim ke user
                $username = $_POST['username']; 

                $key = array('{link}', '{username}');
                $value = array($link, strtoupper($username));
                $mail->Body = str_replace($key, $value,  $mail->Body); // Memasukan pesan ke dalam mail->body dari pesan email


                if (!$mail->send()) {
                    // Jika email tidak terkirim blok ini akan dieksekusi

                    $errors[] = "Pesan tidak dapat dikirim, coba lagi beberapa saat.";
                    // echo 'Mailer Error: ' . $mail->ErrorInfo;
                }               
                else {
                    // Jika email berhasil terkirim blok ini akan dieksekusi
                    // Memanggil fungsi register_user, untuk menambahkan input dari user ke Database
                    $user->register_user(array(
                        'user_username' => $_POST['username'],
                        'user_email' => $_POST['email'],
                        'user_password' => password_hash($_POST['password'], PASSWORD_BCRYPT), // Hash password yang di input user
                        'date_created' => time()
                    ));

                    $email = $_POST['email'];
                    Session::flash("login", "Selamat akun berhasil dibuat, Silahkan verifikasi email anda - <b>$email</b>");
                    Redirect::to('login');
                }

            } else {
                // Jika validasi form inputan user gagal, baris ini akan dijalankan
                $errors = $validation->errors();
            }
        }    
    }

}

$title_page = "Register"; // title halaman register

include_once "templates/header.php"; // templating: include file templates/header.php ke file register.php

?>

    <link href="assets/css/custom-auth.css" rel="stylesheet" /> <!-- File Custom CSS -->
  </head>

<body style="background-image: url('assets/img/background.jpg')">
    <div class="overlay">
        <div class="loading">
            <div id="loader">
                <div id="shadow"></div>
                <div id="box"></div>
            </div>
            <h4>Loading...</h4>
        </div>
    </div>
    <div class="container px-8 max-w-md mx-auto sm:max-w-xl md:max-w-5xl lg:flex lg:max-w-full lg:p-0">
        <div class="lg:p-16 lg:flex-1">
            <h2 class="text-4xl font-bold  tracking-wider sm:text-4xl">
                Lumintu Learning
            </h2>
            <h3 class="text-2xl font-semibold tracking-wider mt-3">
                Daftar
            </h3> 

            <!-- Jika terdapat error, pesan error akan ditampilkan pada alert -->
            <?php if ( !empty($errors) ) { ?>

                <?php foreach ($errors as $error) : ?>
                    <div id="alert-2" class="flex p-4 mb-4 mt-5 bg-red-100 rounded-lg dark:bg-red-200" role="alert">
                        <svg class="flex-shrink-0 w-5 h-5 text-red-700 dark:text-red-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        <div class="ml-3 text-sm font-medium text-red-700 dark:text-red-800">
                            <?php echo $error; ?>
                        </div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-red-200 dark:text-red-600 dark:hover:bg-red-300" data-dismiss-target="#alert-2" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                <?php endforeach; ?>

            <?php } ?>

            <!-- Jika terdapat info, pesan info akan ditampilkan pada alert -->
            <?php if ( !empty($info) ) { ?>

                <?php foreach ($info as $info) : ?>
                    <div id="alert-1" class="flex p-4 mb-4 mt-5 bg-blue-100 rounded-lg dark:bg-blue-200" role="alert">
                        <svg class="flex-shrink-0 w-5 h-5 text-blue-700 dark:text-blue-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        <div class="ml-3 text-sm font-medium text-blue-700 dark:text-blue-800">
                            <?php echo $info; ?>
                        </div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-blue-100 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex h-8 w-8 dark:bg-blue-200 dark:text-blue-600 dark:hover:bg-blue-300" data-dismiss-target="#alert-1" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                <?php endforeach; ?>

            <?php } ?>

            <form method="post" id="register-form">
                <div>
                    <!-- 
                        Generate random token yang akan dikirim bersamaan dengan form saat user melakukan submit.
                        Token berguna untuk mengamankan dari CSRF
                     -->
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                </div>
                <div class="mt-5">
                    <div>
                        <label class="block" for="username">Nama pengguna<label>
                        <input type="text" placeholder="Nama pengguna" name="username" id="username"
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600 text-black required:" required>
                    </div>
                    <div class="mt-4">
                        <label class="block" for="email">Email<label>
                        <input type="email" placeholder="Alamat email" name="email" id="email"
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600 text-black required:" required>
                    </div>

                    <div class="mt-4">
                        <label class="block" for="password">Kata sandi<label>
                        <div id="passwordInput">
                            <input type="password" placeholder="Kata sandi minimal adalah 8 Karakter" name="password" id="password"
                                class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600 text-black required:" required>
                        </div>
                        
                        <!-- Password Strength -->
                        <b>
                            <div id="passwordStrength">
                                <span id="poor"></span>
                                <span id="weak"></span>
                                <span id="strong"></span>
                            </div>
                            <div id="passwordInfo"></div>
                        </b>
                    </div>

                    <div class="mt-4">
                        <label class="block" for="password_verify">Ulangi kata sandi<label>
                        <input type="password" placeholder="Kata sandi minimal adalah 8 Karakter" name="password_verify" id="password_verify"
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600 text-black required:" required>
                    </div>
                    <br>
                    <!-- TODO: Perlu tanya SA -->
                    <!-- <span class="text-white">Dengan mendaftar, kamu setuju dengan syarat dan ketentuan kami </span> -->
                    <div class="flex mt-3">
                        <button class="w-full px-6 py-2 mt-4 text-white bg-[#b6833b] rounded-full hover:bg-[#c5985f]" name="submit"  onclick="CheckLength('InputPassword')">Daftar</button>
                    </div>
                    <div class="mt-6 text-white">
                        Sudah punya akun?
                        <a class="text-white font-bold underline" href="login.php">
                            Masuk
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <div class="hidden lg:flex lg:w-1/2 my-auto p-36">
            <img src="assets/img/register.png" class="animate-bounce lg:mt-10 lg:h-full lg:w-full">
        </div>
    </div>

<?php include_once "templates/footer.php" ?> <!--templating: include file templates/header.php ke file register.php-->