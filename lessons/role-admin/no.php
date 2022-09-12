<?php
// MEMULAI SESSION

// KEAMANAN HALAMAN BACK-END IDENTIFIKASI USER [START]
// PENGECEKAN USER APAKAH SUDAH LOGIN DENGAN AKUN YANG SESUAI ATAU BELUM SEBELUM MEMASUKI HALAMAN INI
// $loginPath = "../../login.php";
// if (!isset($_COOKIE['X-LUMINTU-REFRESHTOKEN'])) {
//     unset($_SESSION['user_data']);
//     header("location: " . $loginPath);
// }

// if (!isset($_SESSION['user_data'])) {
//     header("location: " . $loginPath);
//     die;
// }


session_start();
if (!isset($_SESSION['user_data'])) { //if login in session is not set
    header("Location: https://account.lumintulogic.com/login.php");
}






    switch ($userData->{'user'}->{'role_id'}) {
        case 1:
            // Admin
            header("location: list-modul.php");
            break;
        case 2:
            // Mentor
            echo "
            <script>
                alert('Akses ditolak!');
                location.replace('../role-mentor/list-modul.php');
            </script>";
            break;
        default:
        echo "
        <script>
            alert('Akses ditolak!');
            location.replace('../role-mentor/list-modul.php');
        </script>";
        break;
    }







$ch4 = curl_init();
// $url3 = '192.168.18.136:8000/api/users.php';
$url3 = 'https://account.lumintulogic.com/api/batch.php';
curl_setopt($ch4, CURLOPT_URL, $url3);
$headr = array();
$accesstoken = $_COOKIE['X-LUMINTU-REFRESHTOKEN'];
$headr[] = 'Content-length: 0';
$headr[] = 'Content-type: application/json';
$headr[] = 'Authorization: OAuth ' . $accesstoken;
curl_setopt($ch4, CURLOPT_HTTPHEADER, $headr);
curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch4, CURLOPT_FAILONERROR, true);
$batch1 = curl_exec($ch4);

if ($batch1 === false) {

    $take1 = [
        "batch" => []
    ];
    $take1['batch'] = [

        [
            "batch_id" => "1",
            "batch_name" => "Batch 1 Advance Web Development - GradIT",
            "batch_start_date" => "2022-05-10",
            "batch_end_date" => "2022-05-27"
        ],
        [
            "batch_id" => "3",
            "batch_name" => "Batch 1 IoT - ProKidz",
            "batch_start_date" => "2022-05-10",
            "batch_end_date" => "2022-05-27"
        ],
        [
            "batch_id" => "4",
            "batch_name" => "Batch 1 Big Data - In Career",
            "batch_start_date" => "2022-05-10",
            "batch_end_date" => "2022-05-27"
        ],
        [
            "batch_id" => "5",
            "batch_name" => "Batch 1 Web Development - Code Cation",
            "batch_start_date" => "2022-05-10",
            "batch_end_date" => "2022-05-27"
        ],
        [
            "batch_id" => "6",
            "batch_name" => "Batch 2 - Usability Testing",
            "batch_start_date" => "2022-05-17",
            "batch_end_date" => "2022-06-17"
        ],
        [
            "batch_id" => "7",
            "batch_name" => "TestX",
            "batch_start_date" => "2022-05-11",
            "batch_end_date" => "2022-05-25"
        ],
        [
            "batch_id" => "8",
            "batch_name" => "Batch UAT",
            "batch_start_date" => "2022-06-04",
            "batch_end_date" => "2022-06-11"
        ]

    ];
} else {
    $take1 = json_decode($batch1, true);
}
curl_close($ch4);
// var_dump($_SESSION["user_data"]);
// $row = $_SESSION["user_data"];
// // print_r($_SESSION["user_data"]);
// die;

$user_batch_id = ($_SESSION["user_data"]->user->batch_id);

// $urlf = 'https://lessons.lumintulogic.com/api/modul/read_moduls_tree_batch.php?batch_id=' . $user_batch_id; //filter pake batch_id
$urlf = 'https://lessons.lumintulogic.com/api/modul/read_moduls_tree.php';
// $urlf = 'https://lessons.lumintulogic.com/api/modul/read_modul_rows.php';
$datajs = file_get_contents($urlf);
$json = json_decode($datajs, TRUE);

// var_dump($json);
// die;    

$ambil = 'https://lessons.lumintulogic.com/api/modul/read_modul_rows.php';
$datafile = file_get_contents($ambil);
$jsonFile = json_decode($datafile, TRUE);



$ch3 = curl_init();
$url2 = 'https://account.lumintulogic.com/api/users.php';
// $url2 = 'https://i0ifhnk0.directus.app/items/batch';
curl_setopt($ch3, CURLOPT_URL, $url2);
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
$batch = curl_exec($ch3);
if ($e = curl_error($ch3)) {
    echo $e;
} else {
    $take = json_decode($batch, true);
}
curl_close($ch3);




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../asset/img/logo/favicon.png" />
    <link rel="stylesheet" href="../asset/style/output.css" type="text/css">

    <title>Prokid</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />
    <script src="https://kit.fontawesome.com/cb5fcec140.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.1/dist/flowbite.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/intro.js/minified/introjs.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />

    <!-- Tailwindcss -->
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
                    },
                    fontSize: {
                        'xs': '.65rem',
                        'sm': '.875rem',
                        'tiny': '.875rem',
                        'base': '1rem',
                        'lg': '1.125rem',
                        'xl': '1.25rem',
                        '2xl': '1.5rem',
                        '3xl': '1.875rem',
                        '4xl': '2.25rem',
                        '5xl': '3rem',
                        '6xl': '4rem',
                        '7xl': '5rem',
                    }
                }
            }
        }
    </script>
    <style>
        * {
            font-family: 'Montserrat', sans-serif;
        }

        /* Remove default bullets */
        ul,
        #myUL {
            list-style-type: none;
        }

        /* Remove margins and padding from the parent ul */
        #myUL {
            margin: 0;
            padding: 0;

        }

        /* Style the caret/arrow */
        .caret {
            cursor: pointer;
            user-select: none;
            /* Prevent text selection */
        }

        /* Create the caret/arrow with a unicode, and style it */
        .caret::before {
            content: "\271B";
            color: rgb(0, 0, 0);
            font-weight: bold;
            display: inline-block;
            margin-right: 8px;
            transition: 0.5s;

        }

        /* Rotate the caret/arrow icon when clicked on (using JavaScript) */
        .caret-down::before {
            content: "\2758";
            margin-right: 8px;
            color: rgb(0, 0, 0);

        }

        /* Hide the nested list */
        .nested {
            display: none;
        }

        /* Show the nested list when the user clicks on the caret/arrow (with JavaScript) */
        .active {
            display: block;
        }


        .sidebar #username_logo {
            display: none;
        }

        /* #profil_image {
            display: none !important;
        } */

        /* .responsive-top {
            display: none;
        } */



        .in-active {
            width: 80px !important;
            padding: 20px 15px !important;
            transition: .5s ease-in-out;
        }

        .in-active2 {
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
        .in-active .logo-prokidz {
            display: none !important;
        }

        /* .hidden {
            display: none !important;
        } */

        .sidebar {
            transition: .5s ease-in-out;
        }

        .overlay {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            position: fixed;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .loading {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            position: absolute;
        }

        #loader {
            /* Uncomment this to make it run! */
            /*
       animation: loader 5s linear infinite; 
    */

            position: absolute;
            top: calc(100% - 20px);
            left: calc(100% - 20px);
        }

        @keyframes loader {
            0% {
                left: -100px;
            }

            100% {
                left: 110%;
            }
        }

        #box {
            width: 50px;
            height: 50px;
            background: #fff;
            animation: animate 0.5s linear infinite;
            position: absolute;
            top: 0;
            left: 0;
            border-radius: 3px;
        }

        @keyframes animate {
            17% {
                border-bottom-right-radius: 3px;
            }

            25% {
                transform: translateY(9px) rotate(22.5deg);
            }

            50% {
                transform: translateY(18px) scale(1, 0.9) rotate(45deg);
                border-bottom-right-radius: 40px;
            }

            75% {
                transform: translateY(9px) rotate(67.5deg);
            }

            100% {
                transform: translateY(0) rotate(90deg);
            }
        }

        #shadow {
            width: 50px;
            height: 5px;
            background: #fff;
            opacity: 0.1;
            position: absolute;
            top: 59px;
            left: 0;
            border-radius: 50%;
            animation: shadow 0.5s linear infinite;
        }

        @keyframes shadow {
            50% {
                transform: scale(1.2, 1);
            }
        }

        h4 {
            position: absolute;
            top: 50px;
            left: -30px;
            margin: 0;
            font-weight: 200;
            opacity: 0.5;
            font-family: sans-serif;
            color: #fff;
        }
    </style>


</head>

<body>
    <div class="responsive-top sm:hidden">
        <div class="flex flex-column justify-between p-2">
            <img class="h-[25px] logo-prokidz" src="../asset/img/logo/logo_lumintu.png" alt="logo-prokidz">
            <img src="../asset/img/icons/toggle_icons.svg" alt=" toggle_dashboard" class="w-8 text-black cursor-pointer" id="btnToggle2">
        </div>
    </div>
    <!-- LIST MENU SIDEBAR [START]-->
    <div class="flex items-center">
        <!-- Left side (Sidebar) -->
        <div class="bg-white w-[290px] h-screen px-6 py-6 sm:flex flex-col justify-between sidebar in-active hidden">
            <!-- Top nav -->
            <div class="flex flex-col gap-y-6">
                <!-- Header -->
                <div class="flex items-center space-x-2 px-1">
                    <img src="../asset/img/icons/toggle_icons.svg" alt="toggle_dashboard" class="w-8  fill-black cursor-pointer" id="btnToggle">
                    <img class="w-[130px] logo-prokidz" src="../asset/img/logo/logo_lumintu.png" alt="logo-prokidz">
                </div>

                <hr class="border-[1px] border-opacity-50 border-[#93BFC1]">

                <!-- List Menus -->
                <div>
                    <ul class="flex flex-col gap-y-1">
                        <li>
                            <a href="https://account.lumintulogic.com/dashboard.php" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../asset/img/icons/icons/home_icon.svg" alt="dashboard Icon">
                                <p class="font-semibold">Beranda</p>
                            </a>
                        </li>
                        <li>
                            <a href="list-modul.php" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream bg-cream text-dark-green text-white">
                                <img class="w-5 " src="../asset/img/icons/icons/course_icon.svg" alt="Forum Icon">
                                <p class="font-semibold">Materi</p>
                            </a>
                        </li>
                        <li>
                            <a href="https://assignment.lumintulogic.com/auth.php?token=<?php echo ($_COOKIE['X-LUMINTU-REFRESHTOKEN']); ?>&expiry=<?php echo $_SESSION['expiry']; ?>&page=index" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../asset/img/icons/icons/attendance_icon.svg" alt="Schedule Icon">
                                <p class="font-semibold">Penugasan</p>
                            </a>
                        </li>
                        <li>
                            <a href="https://consultation.lumintulogic.com/auth.php?token=<?php echo ($_COOKIE['X-LUMINTU-REFRESHTOKEN']); ?>&expiry=<?php echo $_SESSION["expiry"]; ?>" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../asset/img/icons/icons/discussion_icon.svg" alt="Attendance Icon">
                                <p class="font-semibold">Konsultasi</p>
                            </a>
                        </li>
                        <li>
                            <a href="http://schedule.lumintulogic.com/auth.php?token=<?php echo ($_COOKIE['X-LUMINTU-REFRESHTOKEN']); ?>&expiry=<?php echo $_SESSION["expiry"]; ?>" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white ">
                                <img class="w-5" src="../asset/img/icons/icons/schedule_icon.svg" alt="Course Icon">
                                <p class=" font-semibold">Jadwal</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom nav -->
            <div>
                <ul class="flex flex-col ">
                    <!-- ICON DAN TEXT HELP -->
                    <li>
                        <button onclick="javascript:bantu();" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                            <img class="w-5" src="../asset/img/icons/icons/help_icon.svg" alt="Help Icon">
                            <p class="font-semibold">Help</p>
                        </button>
                    </li>
                    <!-- ICON DAN TEXT LOG OUT -->
                    <li>
                        <a  data-modal-toggle="logout-modal" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                            <img class="w-5" src="../asset/img/icons/icons/logout_icon.svg" alt="Log out Icon">
                            <p class="font-semibold">Log out</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Mobile navbar -->
        <div id="left-nav" class="bg-opacity-50 bg-gray-500 absolute inset-x-0 hidden z-10 sidebar transition-all delay-100 in-active2 sm:hidden">
            <div class="bg-white w-[250px] h-screen px-8 py-6 ">
                <!-- Top nav -->
                <div class="flex flex-col gap-y-6">

                    <!-- List Menus -->
                    <div>
                        <ul class="flex flex-col gap-y-1">
                            <li>
                                <a href="../index.php" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                    <img class="w-5" src="../asset/img/icons/icons/home_icon.svg" alt="dashboard Icon">
                                    <p class="font-semibold">Beranda</p>
                                </a>
                            </li>
                            <li>
                                <a href="list-modul.php" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream bg-cream text-dark-green text-white">
                                    <img class="w-5 " src="../asset/img/icons/icons/course_icon.svg" alt="Forum Icon">
                                    <p class="font-semibold">Materi</p>
                                </a>
                            </li>
                            <li>
                                <a href="https://assignment.lumintulogic.com/auth.php?token=<?php echo ($_COOKIE['X-LUMINTU-REFRESHTOKEN']); ?>&expiry=<?php echo $_SESSION["expiry"]; ?>&page=index" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                    <img class="w-5" src="../asset/img/icons/icons/attendance_icon.svg" alt="Schedule Icon">
                                    <p class="font-semibold">Penugasan</p>
                                </a>
                            </li>
                            <li>
                                <a href="https://consultation.lumintulogic.com/auth.php?token=<?php echo ($_COOKIE['X-LUMINTU-REFRESHTOKEN']); ?>&expiry=<?php echo $_SESSION["expiry"]; ?>" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                    <img class="w-5" src="../asset/img/icons/icons/discussion_icon.svg" alt="Attendance Icon">
                                    <p class="font-semibold">Konsultasi</p>
                                </a>
                            </li>
                            <li>
                                <a href="http://schedule.lumintulogic.com/auth.php?token=<?php echo ($_COOKIE['X-LUMINTU-REFRESHTOKEN']); ?>&expiry=<?php echo $_SESSION["expiry"]; ?>" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white ">
                                    <img class="w-5" src="../asset/img/icons/icons/schedule_icon.svg" alt="Course Icon">
                                    <p class=" font-semibold">Jadwal</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Bottom nav -->
                <div>
                    <ul class="flex flex-col ">
                        <!-- ICON DAN TEXT HELP -->
                        <li>
                            <button onclick="javascript:bantu();" href="#" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../asset/img/icons/icons/help_icon.svg" alt="Help Icon">
                                <p class="font-semibold">Help</p>
                            </button>
                        </li>
                        <!-- ICON DAN TEXT LOG OUT -->
                        <li>
                            <a data-modal-toggle="logout-modal" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../asset/img/icons/icons/logout_icon.svg" alt="Log out Icon">
                                <p class="font-semibold">Log out</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <!-- Right side -->
        <div class="bg-cgray w-full h-screen px-5 py-5 flex flex-col gap-y-6 overflow-y-scroll rightbar">
            <!-- Header / Profile -->
            <div class="items-center gap-x-4 justify-end hidden sm:flex" id="profil_image2">
                <img class="w-10" src="../asset/img/icons/default_profile.svg" alt="Profile Image" />
                <p class="text-dark-green font-semibold"><?php echo $_SESSION["user_data"]->user->user_username; ?></p>
            </div>

            <!-- Breadcrumb -->
            <nav class="relative w-full flex flex-wrap items-center justify-between  text-gray-500 hover:text-gray-700 focus:text-gray-700 navbar navbar-expand-lg navbar-light">
                <div class="container-fluid w-full flex flex-wrap items-center justify-between ">
                    <nav class=" rounded-md w-full" aria-label="breadcrumb">
                        <ol class="list-reset flex">
                            <li><a href="#" class="text-gray-500 hover:text-gray-600">Home</a></li>
                            <li><span class="text-gray-500 mx-2">/</span></li>
                            <li><a href="#" class="text-blue-500 hover:text-gray-600">list Modul</a></li>
                        </ol>
                    </nav>
                </div>
            </nav>

            <div>
                <p class="text-4xl text-dark-green font-semibold">List Modul</p>
            </div>

            <div class="sm:rounded-lg">
                <div class="float-right ">

                    <button id="mat" class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg sm:text-sm px-2 py-2 text-center" type="button" data-modal-toggle="authentication-modal">
                        Tambah Topik
                    </button>
                    <div class="mt-3">

                        <div class="sm:m-2">
                            <!-- Modal toggle -->

                            <!-- Main modal -->
                            <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden  overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                                <div class="relative p-3 w-full max-w-md h-full md:h-auto">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow ">
                                        <button onclick="javascript:eraseText();" type=" button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="authentication-modal">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                        <div class="py-6 px-5 lg:px-5">
                                            <h1 class="mb-4 text-2xl justify-center text-center items-start font-medium text-black">Topik Utama</h1>
                                            <!-- <form class="space-y-6" action="kompetensi.php" method="POST"> -->
                                            <form class="space-y-2 form-prevent" onsubmit="postModul();return false">
                                                <div>
                                                    <label for="modul_name" class="block mb-1 text-sm font-semibold text-black">Masukkan Topik Pembelajaran</label>
                                                    <input autocomplete="off" type="modul_name" name="modul_name" id="modul_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Masukan nama modul disini" required>
                                                </div>

                                                <div>
                                                    <label for="descModul" class="block mb-1 text-sm font-semibold text-black">Masukan Deskripsi</label>
                                                    <textarea name="modul_description" id="desc" class="block p-2.5 w-full  max-h-20  text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="masukan deskripsi disini..."></textarea>
                                                </div>

                                                <div>
                                                    <label for="modul_name" class="block mb-1 text-sm font-semibold text-black">Masukkan Bobot</label>
                                                    <div class="flex p-2 mb-3 rounded-lg text-[13px] text-blue-700 bg-blue-100" role="alert">
                                                        <svg class="inline flex-shrink-0 mr-3 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <div>
                                                            <span class="font-medium">Warning!</span> <br>
                                                            Skala input 1 - 100 <br>
                                                            Contoh input 1 = 1% <br>
                                                            Contoh input 20 = 20% <br>
                                                            Max Input 100
                                                        </div>
                                                    </div>
                                                    <input autocomplete="off" type="number" min="1" max="100" step="any" name="bobot" id="bobot" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder=" Masukan bobot disini" required>
                                                </div>

                                                <!-- sesion admin  -->
                                                <div class="batch-id mt-2">
                                                <label for="" class="font-semibold text-md ">Masukkan Batch ID</label>
                                                <select name="batch_id" id="batch-id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block sm:w-full p-2.5">
                                                    <?php foreach ($take1["batch"] as $bid) : ?>
                                                        <option value="<?= $bid["batch_id"]; ?>"><?= $bid["batch_name"]; ?> | <?= $bid["batch_start_date"]; ?> | <?= $bid["batch_end_date"]; ?> </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                </div>

                                                <div class="flex">
                                                    <button id="btn-simpan" name="send" class="w-full text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center  mb-2">Simpan dan Lanjut Buat SubModul</button>
                                                    <button type="button" id="btn-loader" class="hidden w-full  bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded-lg items-center rounded">
                                                        <svg role="status" class="inline w-6 h-6 mr-2 text-white animate-spin fill-red-500" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                                                        </svg>
                                                        Memproses...
                                                    </button>
                                                </div>
                                                <button onclick="javascript:eraseText();" type="button" class="w-full text-white bg-gradient-to-r from-blue-600    via-blue-700 to-blue-800 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300  font-medium rounded-lg text-sm px-5 py-2.5 text-center  mb-2" data-modal-toggle="authentication-modal">
                                                    Kembali
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- start tabel  treeview -->
                <table class="shadow-sm sm:w-full md:w-full lg:w-full text-black border-inherit  border-b-2 mb-4">
                    <thead class="text-md text-black text-xenter  bg-gray-200">
                        <tr>
                            <th scope="col" class="sm:w-[37rem] min-w-[16rem] py-3">
                                <center>Nama Modul</center>
                            </th>
                            <th scope="col" class="sm:w-[22rem] py-3">
                                <center>Aksi</center>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        require 'tree-modal.php';
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>


    <!-- loding  -->
    <div id="btn-loader1" class="overlay hidden">
        <div class="loading">
            <div id="loader">
                <div id="shadow"></div>
                <div id="box"></div>
            </div>
            <h4>Loading...</h4>
        </div>
    </div>

    <div id="btn-loader03" class="overlay hidden">
        <div class="loading">
            <div id="loader">
                <div id="shadow"></div>
                <div id="box"></div>
            </div>
            <h4>Loading...</h4>
        </div>
    </div>

<!-- modal logout  -->
    <div id="logout-modal" tabindex="-1"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                <div class="relative bg-white rounded-lg shadow">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center "
                        data-modal-toggle="logout-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 w-14 h-14 text-gray-400 " fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500">Apakah anda ingin keluar?</h3>
                        <a href="logout.php" data-modal-toggle="logout-modal" type="button"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Keluar
                        </a>
                        <button data-modal-toggle="logout-modal" type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 ">
                            Batal</button>
                    </div>
                </div>
            </div>
        </div>


    <!-- Main Edit modal -->

        <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
        <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
        <!-- CDN JQUERY -->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

    <!-- FUNGSI TOGGLE SIDEBAR -->

    <script>
        const intro = introJs();
            intro.setOptions({
                steps: [{
                    intro: "Hi <?php echo $_SESSION["user_data"]->user->user_username; ?>, Ini Adalah Halaman List Modul"
                    }, {
                        title: 'Add Topik Pembelajaran',
                        element: document.querySelector('#mat'),
                        intro: "Ini digunakan untuk menambahkan Topik pembelajaran!"
                    }, {
                        element: document.querySelector('#bantuView'),
                        intro: "Ini digunakan untuk menampilkan detail Topik pembelajaran!"
                    }, {
                        element: document.querySelector('#myButton'),
                        intro: "Ini digunakan untuk mengedit Topik pembelajaran!"
                    }, {
                        element: document.querySelector('#bantu04'),
                        intro: "Ini digunakan untuk menambahkanTopik pembelajaran!"
                    }, {
                        element: document.querySelector('#bantu05'),
                        intro: "Ini digunakan untuk menghapus materi topik pembelajaran beserta materi didalamnya!"
                    }, {
                        element: document.querySelector('#bantuSub'),
                        intro: "Klik topik ini untuk melihat materi pembelajaran di dalamnya"
                    }, {
                        element: document.querySelector('#bantuSub1'),
                        intro: "Ini materi dalam topik pembelajaran!"
                    }, {
                        element: document.querySelector('#bantu06'),
                        intro: "Tombol ini digunakan untuk menambahkan tugas dari materi pembelajaran pada topik in!"
                    }, {
                        element: document.querySelector('#bantu07'),
                        intro: "Tombol ini digunakan untuk mengedit materi pembelajaran dalam topik ini!"
                    }, {
                        element: document.querySelector('#bantu08'),
                        intro: "Tombol ini digunakan untuk menghapus materi pembelajaran dalam topik ini!"
                    }


                ]
            });



        var name = 'IntroJS';
            var value = localStorage.getItem(name) || $.cookie(name);
            var func = function() {
                if (Modernizr.localstorage) {
                    localStorage.setItem(name, 1)
                } else {
                    $.cookie(name, 1, {
                        expires: 365
                    });
                }
            };
            if (value == null) {
                intro.start().oncomplete(func).onexit(func);
            };
    
    
    
    
    
    </script>



    <script type="text/javascript">
                let btnToggle = document.getElementById('btnToggle');
        let btnToggle2 = document.getElementById('btnToggle2');
        let sidebar = document.querySelector('.sidebar');
        let leftNav = document.getElementById("left-nav");
        btnToggle.onclick = function() {
            sidebar.classList.toggle('in-active');
        }

        btnToggle2.onclick = function() {
            leftNav.classList.toggle('hidden');

        }


        var toggler = document.getElementsByClassName("caret");
        var i;
        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("caret-down");
            });
        };
    </script>
    
    <script type="text/javascript">

        function deleteModul(id) {
            let ok = confirm("Apakah anda yakin menghapus modul ini?");
            if (ok) {
                console.log("deleting modul..");

                $.ajax({
                    url: "https://lessons.lumintulogic.com/api/modul/delete.php",
                    type: "post",
                    data: {
                        id: id
                    },
                    success: function(res) {
                        console.log(res);
                        if (!res.error) {
                            console.log("berhasil delete modul id: " + res.deletedId);

                            // delete div
                            let fileElm = $("[data-filesection=" + res.deletedId + "]");
                            fileElm.remove();


                        } else {
                            console.log("gagal hapus");
                        }
                    },
                    error: function() {
                        console.log("gagal delete");
                    }
                });
            }
        }

        function deleteSubModul(id) {
            let ok = confirm("Apakah anda yakin menghapus modul ini?");

            if (ok) {
                console.log("deleting modul..");

                $.ajax({
                    url: "https://lessons.lumintulogic.com/api/modul/delete.php",
                    type: "post",
                    data: {
                    id: id
                    },
                    success: function(res) {
                        console.log(res);
                        if (!res.error) {

                            console.log("berhasil delete submodul id: " + res.deletedId);
                            let fileElm = $("[data-filesection=" + res.deletedId + "]");
                            fileElm.remove();
                            window.location.replace("list-modul.php");


                        } else {
                            console.log("gagal hapus");
                        }
                    },
                    error: function() {
                        console.log("gagal delete");
                    }
                });
            }
        }




        function bantu() {
            introJs().setOptions({
                steps: [{
                        intro: "Hi <?php echo $_SESSION["user_data"]->user->user_username; ?>, Ini Adalah Halaman List Modul"
                    }, {
                        element: document.querySelector('#mat'),
                        intro: "Ini digunakan untuk menambahkan Topik pembelajaran!"
                    }, {
                        element: document.querySelector('#bantuView'),
                        intro: "Ini digunakan untuk menampilkan detail Topik pembelajaran!"
                    }, {
                        element: document.querySelector('#myButton'),
                        intro: "Ini digunakan untuk mengedit Topik pembelajaran!"
                    }, {
                        element: document.querySelector('#bantu04'),
                        intro: "Ini digunakan untuk menambahkanTopik pembelajaran!"
                    }, {
                        element: document.querySelector('#bantu05'),
                        intro: "Ini digunakan untuk menghapus materi topik pembelajaran beserta materi didalamnya!"
                    }, {
                        element: document.querySelector('#bantuSub'),
                        intro: "Klik topik ini untuk melihat materi pembelajaran di dalamnya"
                    }, {
                        element: document.querySelector('#bantuSub1'),
                        intro: "Ini materi dalam topik pembelajaran!"
                    }, {
                        element: document.querySelector('#bantu06'),
                        intro: "Tombol ini digunakan untuk menambahkan tugas dari materi pembelajaran pada topik in!"
                    }, {
                        element: document.querySelector('#bantu07'),
                        intro: "Tombol ini digunakan untuk mengedit materi pembelajaran dalam topik ini!"
                    }, {
                        element: document.querySelector('#bantu08'),
                        intro: "Tombol ini digunakan untuk menghapus materi pembelajaran dalam topik ini!"
                    }

                ]
            }).start();

        };



        // jika form-prevent disubmit maka disable button-prevent dan tampilkan spinner
        (function() {
            $('.form-prevent').on('submit', function() {
                $("#btn-simpan").toggleClass("hidden");
                $("#btn-loader").toggleClass("hidden");
            })
        })();



        $('#myButton').on('click', function() {
            var $btn = $(this).button('loading')
            // business logic...
            $btn.button('loading')
        })



        function eraseText() {
            document.getElementById("modul_name").value = "";
            document.getElementById("desc").value = "";
            document.getElementById("bobot").value = "";
        };

        function loadin() {
            $("#btn-loader1").toggleClass("hidden");
        };




        function postModul() {
            let modulName = $("input[name='modul_name']").val();
            let modulDesc = $("textarea[name='modul_description']").val();
            let bobot = $("input[name='bobot']").val();
            bobot = bobot/100;
            let batchId = $('select[name=batch_id]').val();


            console.log("post");

            // console.log(modulName);
            // console.log(modulDesc);
            // console.log(batchId);
            $.ajax({
                url: "https://lessons.lumintulogic.com/api/modul/create.php",
                type: "post",
                data: {
                    modul_name: modulName,
                    status: 1,
                    parent_id: null,
                    batch_id: batchId,
                    modul_weight: bobot,
                    modul_description: modulDesc,

                },
                success: function(res) {
                    if (!res.error) {
                        console.log("berhasil insert modul, id: " + res.insertedId);
                        alert("Berhasil Menyimpan Topik Pembelajaran!");
                        // redirect
                        window.location.replace("tambah.php?modulId=" + res.insertedId);
                    } else {
                        alert("Gagal Insert Topik!");
                    }
                },
                error: function() {
                    console.log("gagal post");
                }
            });

        }


        function openModal(id) {
            // loader
            $("#modal-loader").removeClass("hidden");
            $("#modal-content").addClass("hidden");
            // hide content

            console.log(id);
            $.ajax({
                url: "https://lessons.lumintulogic.com/api/modul/read_single_modul.php?id=" + id,
                method: "get",
                success: function(data) {
                    console.log(data);
                    // let modul = JSON.stringify(data);

                    let modul = data.data;
                    let modulId = modul.id;
                    let modulName = modul.modul_name;
                    let modulDesc = modul.modul_description;
                    let modulBobot = modul.modul_weight;
                    modulBobot = modulBobot *100;
                    let modulBatch = modul.batch_id;
                    let modulParent = modul.parent_id;

                    // getId(modulId, modulParent);
                    // let coba = document.getElementById("modul_name").getAttribute("value", modulName);



                    let modval =
                    $('#modul-ID').attr("value", modulId);
                    $('#main_modul1').val(modulName);
                    // let descval = $('textarea').attr("placeholder", modulDesc);
                    $('#modul_desc1').val(modulDesc);
                    // $("textarea").val().attr("value", modulDesc);
                    $('#bobot_id2').val(modulBobot);
                    $('#batch-id1').val(modulBatch).change();
                    $('#parentid').attr("value", modulParent);
                    $('#modulid').attr("value", modulId);

                    $("#modal-loader").addClass("hidden");
                    $("#modal-content").removeClass("hidden");

                    // console.log(modval);
                    // $('#desc').attr("value", "modulDesc");
                    // document.getElementById("desc").getAttribute("value", modulDesc);

                    console.log(modulId);

                }
            })

        }


        function updateModul(id) {

            let modulID = $("#modul-ID").val();
            let modulName = $("#main_modul1").val();
            let modulDesc = $("#modul_desc1").val();
            let modulBobot = $("#bobot_id2").val();
            modulBobot = modulBobot/100;
            // let modulParent = $("#parentid").val();
            let batchID = $('#batch-id1').val();
            let status = 1;

            let arr = {
                "id": modulID,
                "modul_name": modulName,
                "modul_description": modulDesc,
                "modul_weight": modulBobot,
                // "parent_id": modulParent,
                "batch_id": batchID,
                "status": 1,

            }

            $("#btn-simpan2").toggleClass("hidden");
            $("#btn-loader03").toggleClass("hidden");


            $.ajax({
                url: "https://lessons.lumintulogic.com/api/modul/update.php?id=" + id,
                type: "post",
                data: arr,
                success: function(res) {
                    if (!res.error) {
                        console.log("berhasil edit modul, id: " + res.id);
                        alert("Berhasil Mengedit Topik Pembelajaran!");


                    } else {
                        console.log("gagal edit");
                    }

                }
            });


        }
    </script>


</body>

</html>