<?php

require_once 'core/init.php';
require 'vendor/autoload.php';

use Dotenv\Dotenv;

// Load dotenv
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

if ( isset($_POST['submit']) ) {
    if ( Token::check( $_POST['token'] ) ) {

        // Call Validation Object

        $validation = new Validation();

        // Check Method
        $validation = $validation->check(array(
            'email' => array(
                        'required' => true,
                        'min' => 6,
                        ),
        ));

        // Menguji email apakah sudah atau belum terdaftar di Database
        if ($user->check_email($_POST['email'])) {

            // Check Passed
            if ($validation->passed()) {    

                $token = base64_encode(random_bytes(32));

                $user->verifikasi_account(array(
                    'user_email' => $_POST['email'],
                    'user_token' => $token,
                    'date_created' => time()
                ));

                // email verifikasi dibuat disini
                $mail->Subject = "Reset Password - Lumintu Learning";
                $mail->addAddress($_POST['email'], $_POST['username']);
                $email_template = 'templates/reset_password.html';
                $mail->Body = file_get_contents($email_template);
                $mail->addEmbeddedImage('assets/img/logo.png', 'image_cid'); 
                // Dibuat disini untuk link Verifikasi yg Kirim ke Email
                $link = ($_SERVER['HTTP_HOST'] . "/password-reset.php" . "?email=" . $_POST['email'] . "&token=" . urlencode($token));

                $mail->Body = str_replace("{link}", $link,  $mail->Body);

                if (!$mail->send()) {
                    $errors[] = "Message could not be sent.";
                }
                
                else {
                    $email = $_POST['email'];
                    Session::flash("login", "Link sudah dikirim untuk reset password - $email");
                    Redirect::to('login');
                }
                

            } else {
                $errors = $validation->errors();
            }
    
        } else {

            $errors[] = "Email belum terdaftar";
            
        }    
    }

}

$title_page = "Forgot Password";

require_once "templates/header.php";

?>

<!-- File Custom CSS -->
<link href="assets/css/custom-auth.css" rel="stylesheet" />
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
    <div class="flex items-center justify-center min-h-screen px-10">
        <div class="px-8 py-8 text-left bg-white rounded-lg md:w-1/2 lg:w-1/2">
            <div class="text-center">
                <a href="index.php"><img class="w-[180px] logo-gradit md:ml-48 mb-6" src="assets/logo/logo_lumintu.png" alt="Logo In Career"></a>
                <h3 class="text-2xl font-bold text-gray-600 mb-8">Reset kata sandi</h3>
            </div>
            
            <?php if ( !empty($errors) ) { ?>

                <?php foreach ($errors as $error) : ?>
                    <div id="alert-1" class="flex p-4 mb-4 mt-5 bg-blue-100 rounded-lg dark:bg-blue-200" role="alert">
                        <svg class="flex-shrink-0 w-5 h-5 text-blue-700 dark:text-blue-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        <div class="ml-3 text-sm font-medium text-blue-700 dark:text-blue-800">
                            <?php echo $error; ?>
                        </div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-blue-100 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex h-8 w-8 dark:bg-blue-200 dark:text-blue-600 dark:hover:bg-blue-300" data-dismiss-target="#alert-1" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                <?php endforeach; ?>

            <?php } ?>

            <form action="" method="post">
                <div>
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                </div>
                <div class="mt-4">
                    <div class="mt-4">
                        <label class="block text-black" for="email">Masukkan alamat email terverifikasi akun pengguna Anda dan kami akan mengirimkan link untuk reset password.<label>
                                <input type="email" id="email" name="email"
                                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600 text-black" required>
                    </div>
                    <div class="flex flex-col">
                        <button name="submit"
                            class="px-6 w-auto py-2 mt-6 text-white bg-[#b6833b] rounded-md hover:bg-[#c5985f]">Submit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

<?php require_once "templates/footer.php" ?>