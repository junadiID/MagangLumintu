<?php

session_start();
if (!isset($_SESSION['user_data'])) { //if login in session is not set
    header("Location: https://account.lumintulogic.com/login.php");
    die;
}

if (!isset($_COOKIE['X-LUMINTU-REFRESHTOKEN'])) {
    unset($_SESSION['user_data']);
    header("Location: https://account.lumintulogic.com/login.php");
    die;
}

$role = $_SESSION['user_data']->user->role_id;
switch ($role) {
    case 1:
        //
        break;
    
    case 2:
        // Mentor
        header("location: ../role-mentor/list-modul.php");
        break;
    
    default:
        echo "
        <script>
            alert('Akses ditolak!');
            location.replace('https://account.lumintulogic.com/login.php');
        </script>";
        break;
}

if (!isset($_GET["modulId"]) || empty($_GET["modulId"])) {
    echo "
        <script>
            alert('modul id tidak valid');
            location.replace('list-modul.php');
        </script>";
}

if (!isset($_GET["batchId"]) || empty($_GET["batchId"])) {
    echo "
        <script>
            alert('modul id tidak valid');
            location.replace('list-modul.php');
        </script>";
}

$ch = curl_init();
$url = 'https://lessons.lumintulogic.com/api/modul/read_single_modul_tree.php?id=' . $_GET['modulId'];
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);
if ($e = curl_error($ch)) {
    // echo $e;
} else {
    $modulId = json_decode($data, true);
}
curl_close($ch);

if ($modulId["error"] || !$modulId) {
    echo "
        <script>
            alert('error mendapatkan data modul');
            location.replace('list-modul.php');
        </script>";
}

$ch3 = curl_init();
// $url3 = '192.168.18.136:8000/api/users.php';
$url3 = 'https://account.lumintulogic.com/api/batch.php?batch_id=' . $_GET['batchId'];
curl_setopt($ch3, CURLOPT_URL, $url3);
$headr = array();
$accesstoken = $_COOKIE['X-LUMINTU-REFRESHTOKEN'];
$headr[] = 'Content-length: 0';
$headr[] = 'Content-type: application/json';
$headr[] = 'Authorization: OAuth ' . $accesstoken;
curl_setopt($ch3, CURLOPT_HTTPHEADER, $headr);
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch3, CURLOPT_FAILONERROR, true);
$batch = curl_exec($ch3);

if ($batch === false) {
    echo "
        <script>
            alert('error mendapatkan data batch');
        </script>";
} else {
    $take = json_decode($batch, true);
}
curl_close($ch3);

// var_dump($take['batch']);
// die;








?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../asset/img/logo/favicon.png" />
    <link rel="stylesheet" href="../asset/style/output.css" type="text/css">
    <title>Prokid - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />
    <!-- Font -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />
    <script src="https://kit.fontawesome.com/cb5fcec140.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.1/dist/flowbite.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/intro.js/minified/introjs.min.css" rel="stylesheet">

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
                        "drop": "#CDDBFE"
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
    </style>
</head>

<body>
    <!-- side bar  -->
    <div class="responsive-top sm:hidden">
        <div class="flex flex-column justify-between p-2">
            <img class="h-[25px] logo-prokidz" src="../asset/img/logo/logo_lumintu.png" alt="logo-prokidz">
            <img src="../asset/img/icons/toggle_icons.svg" alt=" toggle_dashboard" class="w-8 text-black cursor-pointer" id="btnToggle2">
        </div>
    </div>
    <!-- LIST MENU SIDEBAR [START]-->
    <div class="flex items-center">
        <!-- Left side (Sidebar) -->
        <div class="bg-white w-[300px] h-screen px-8 py-6 sm:flex flex-col justify-between sidebar in-active hidden">
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
                        <button onclick="javascript:bantu();" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                            <img class="w-5" src="../asset/img/icons/icons/help_icon.svg" alt="Help Icon">
                            <p class="font-semibold">Help</p>
                        </button>
                    </li>
                    <!-- ICON DAN TEXT LOG OUT -->
                    <li>
                        <a data-modal-toggle="keluar-modal" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
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
                                <a href="https://account.lumintulogic.com/dashboard.php" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                    <img class="w-5" src="../asset/img/icons/icons/home_icon.svg" alt="dashboard Icon">
                                    <p class="font-semibold">Beranda</p>
                                </a>
                            </li>
                            <li>
                                <a href="list-modul.php" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream bg-cream text-dark-green hover:text-white">
                                    <img class="w-5 " src="../asset/img/icons/icons/course_icon.svg" alt="Forum Icon">
                                    <p class="font-semibold">Materi</p>
                                </a>
                            </li>
                            <li>
                                <a href="https://assignment.lumintulogic.com/auth.php?token=<?php echo ($_COOKIE['X-LUMINTU-REFRESHTOKEN']); ?>&expiry=<?php echo $_SESSION["expiry"]; ?>>&page=index" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
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
                            <a data-modal-toggle="keluar-modal" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../asset/img/icons/icons/logout_icon.svg" alt="Log out Icon">
                                <p class="font-semibold">Log out</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- end side bar  -->

        <!-- Header / Profile -->

        <div class="bg-gray-100 sm:w-full h-screen px-8 py-6 flex flex-col gap-y-2 overflow-y-scroll ">
            <div class="items-center gap-x-4 justify-end hidden sm:flex" id="profil_image2">
                <img class="w-10" src="../asset/img/icons/default_profile.svg" alt="Profile Image" />
                <p class="text-dark-green font-semibold"><?php echo $_SESSION["user_data"]->user->user_username; ?></p>
            </div>

            <!-- Breadcrumb -->
            <div>
                <ul class="flex items-center gap-x-4">
                    <li>
                        <a class="text-light-green hover:text-blue-500" href="../index.php">Home</a>
                    </li>
                    <li>
                        <span class="text-light-green">/</span>
                    </li>
                    <li>
                        <a class="text-light-green hover:text-blue-500" href="list-modul.php">List Modul</a>
                    </li>
                    <li>
                        <span class="text-light-green">/</span>
                    </li>
                    <li>
                        <a class="text-light-green text-blue-500" href="viewmodul.php">View Modul</a>
                    </li>
                </ul>
            </div>
            <!-- end breadcrumb -->
            <div class="items-center">
                <div class="p-3  items-center rounded-md sm:w-[56rem]" 0>
                    <div class="bg-white p-2 shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6" id="bantumodulutama">
                            <h3 class="text-lg leading-6 font-semibold text-gray-900"><?php echo $modulId["data"]["modul_name"];  ?></h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Detail informasi Topik Pembelajaran <?php echo $modulId["data"]["modul_name"];  ?></p>
                        </div>
                        <div class="border-t border-gray-200">
                            <dl>
                                <div id="des" class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-semibold text-black">Deskripsi Modul</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"><?php echo htmlspecialchars_decode($modulId["data"]["modul_desc"]);  ?></dd>
                                </div>

                                <div id="bantubatch" class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-semibold text-black">Informasi Batch</dt>

                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"><?php echo $take['batch']['batch_name']; ?> | <?php echo $take['batch']['batch_start_date']; ?> | <?php echo $take['batch']['batch_end_date']; ?></dd>


                                </div>

                                <div id="bantusubmodul" class="bg-gray-50 px-4 py-5 grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-semibold text-black">Topik Pembelajaran</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <?php if (empty($modulId["data"]['child'])) : ?>
                                            <p class="text-sm text-black ">Tidak ada SubModul</p>
                                        <?php else : ?>
                                            <?php foreach ($modulId['data']['child'] as $modulName) : ?>
                                                <ul role="list" class="border  border-dashed  mt-1 border-black rounded-md divide-y divide-gray-200">
                                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                                        <div class="w-0 bg flex-1 flex items-center">
                                                            <span class="ml-1 flex-1  w-full truncate"><?= $modulName['modul_name']; ?></span>
                                                        </div>
                                                        <div id="bantuaksi" class="ml-4 flex-shrink-0">
                                                            <button onclick="showFileModal(<?= $modulName['id']; ?>)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 border border-blue-700 rounded " type="button" data-modal-toggle="medium-modal">
                                                                Liat File
                                                            </button>
                                                        </div>
                                                    </li>
                                                </ul>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div class="mt-3 flex">
                            <button class="flex-1  display-hidden"></button>
                            <a href="list-modul.php" class=" bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" id="bantukembali">
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- start edit modul -->

            <!-- start modal  -->
            <div id="medium-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed  top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
                <div class="relative p-2 w-full max-w-lg h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex justify-between p-3 rounded-t items-center border-b ">
                            <h3 class="text-xl font-medium text-gray-900  ">
                                List File
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="medium-modal">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <!-- LOADING  -->
                        <div class="p-2 space-y-2  items-center justify-center" id="file-content">
                            <div class="flex justify-center items-center space-x-2">
                                <div class="spinner-grow inline-block w-8 h-8 bg-current rounded-full opacity-0 text-blue-600" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="
                                                                                        spinner-grow inline-block w-8 h-8 bg-current rounded-full opacity-0
                                                                                        text-purple-500
                                                                                        " role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="
                                                                                        spinner-grow inline-block w-8 h-8 bg-current rounded-full opacity-0
                                                                                        text-green-500
                                                                                        " role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="spinner-grow inline-block w-8 h-8 bg-current rounded-full opacity-0 text-red-500" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="
                                                                                        spinner-grow inline-block w-8 h-8 bg-current rounded-full opacity-0
                                                                                        text-yellow-500
                                                                                        " role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="spinner-grow inline-block w-8 h-8 bg-current rounded-full opacity-0 text-blue-300" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="spinner-grow inline-block w-8 h-8 bg-current rounded-full opacity-0 text-gray-300" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->

                    </div>
                </div>
            </div>
            <!-- modal logout -->
            <div id="keluar-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                    <div class="relative bg-white rounded-lg shadow">
                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-toggle="keluar-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="p-6 text-center">
                            <svg class="mx-auto mb-4 w-14 h-14 text-gray-400 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mb-5 text-lg font-normal text-gray-500">Apakah anda ingin keluar?</h3>
                            <a href="logout.php" data-modal-toggle="keluar-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                Keluar
                            </a>
                            <button data-modal-toggle="keluar-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 ">
                                Batal</button>
                        </div>
                    </div>
                </div>
            </div>



        </div>




        <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
        <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
        <!-- CDN JQUERY -->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
        <script>
            const intro = introJs();
            intro.setOptions({
                steps: [{
                        intro: "Hi <?php echo $_SESSION["user_data"]->user->user_username; ?>, Ini Adalah Halaman view Topik Pembelajaran"
                    },
                    {
                        title: 'Nama Topik Pembelajaran',
                        element: document.querySelector('#bantumodulutama'),
                        intro: 'Nama Topik Pembelajaran'
                    },
                    {
                        title: 'Deskripsi Topik Pembelajaran',
                        element: document.querySelector('#des'),
                        intro: 'Berisi Deskripsi Modul dari Modul yang di liat'
                    },
                    {
                        title: 'Batch Topik Pembelajaran',
                        element: document.querySelector('#bantubatch'),
                        intro: 'Berisi Batch Topik Pembelajaran yang di lihat masuk ke batch yang mana'
                    },
                    {
                        title: 'Materi Pembelajaran',
                        element: document.querySelector('#bantusubmodul'),
                        intro: 'Berisi List Materi dari Topik Pembelajara yang di lihat'
                    },
                    {
                        title: 'Lihat Aksi',
                        element: document.querySelector('#bantuaksi'),
                        intro: 'Bisa Melakukan Download file disini ketika anda klik liat file maka akan muncul list file yang siap di download'
                    },


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






            function bantu() {
                introJs().setOptions({
                    steps: [{
                            intro: "Hi <?php echo $_SESSION["user_data"]->user->user_username; ?>, Ini Adalah Halaman view Topik Pembelajaran"
                        },
                        {
                            title: 'Nama Topik Pembelajaran',
                            element: document.querySelector('#bantumodulutama'),
                            intro: 'Nama Topik Pembelajaran'
                        },
                        {
                            title: 'Deskripsi Topik Pembelajaran',
                            element: document.querySelector('#des'),
                            intro: 'Berisi Deskripsi Modul dari Modul yang di liat'
                        },
                        {
                            title: 'Batch Topik Pembelajaran',
                            element: document.querySelector('#bantubatch'),
                            intro: 'Berisi Batch Topik Pembelajaran yang di lihat masuk ke batch yang mana'
                        },
                        {
                            title: 'Materi Pembelajaran',
                            element: document.querySelector('#bantusubmodul'),
                            intro: 'Berisi List Materi dari Topik Pembelajara yang di lihat'
                        },
                        {
                            title: 'Lihat Aksi',
                            element: document.querySelector('#bantuaksi'),
                            intro: 'Bisa Melakukan Download file disini ketika anda klik liat file maka akan muncul list file yang siap di download'
                        },


                    ]

                }).start();
            };



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


            // const checkbox = document.getElementById("flexCheckIndeterminate");
            // checkbox.indeterminate = true;

            function openModal(id) {
                console.log(id);
                $.ajax({
                    url: "https://lessons.lumintulogic.com/api/modul_file/read_by_modul.php?id=" + id,
                    method: "get",
                    success: function(data) {
                        console.log(data);

                    }
                })

            }

            function showFileModal(id) {
                console.log(id);
                $("#file-content").html(loaderElm);

                $.ajax({
                    method: "get",
                    url: "https://lessons.lumintulogic.com/api/modul_file/read_by_modul.php?id=" + id,
                    success: function(res) {
                        console.log(res);

                        let modalElm = fileModalElm(res.data);
                        console.log(modalElm);
                        $("#file-content").html(modalElm);

                    },
                    error: function(e) {
                        console.log(e);
                    }

                });
            }

            function fileModalElm(files) {

                // let row = `
                // <tr class=" text-center items-center justify-center">
                //     <td scope="row" class="px-6 text-center items-center justify-center py-4 font-medium text-gray-900 whitespace-nowrap">
                //         Nama File
                //     </td>
                //     <td class="text-center items-center justify-center">
                //         <button type="button" class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2">Download</button>
                //     </td>
                // </tr>`;

                if (!files) {
                    return `<p class="text-sm text-center  text-black">File kosong</p> `;
                }
                let tableRowFile = ``;

                files.forEach(elm => {
                    tableRowFile += `
                    <tr class="bg-white  justify-center">
                        <th scope="row" class="max-w-[110px] truncate px-2  py-2 font-medium  justify-center text-black whitespace-nowrap">
                            ${elm.file_name}
                        </th>
                        <th class="text-center  items-center justify-center"> 
                            <a href="https://lessons.lumintulogic.com/uploads/${elm.file_name}" type="application/pdf" target="_blank" class="text-white py-1 bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2">Download</a>
                        </th>
                    </tr>`;
                });

                let table = `
                    <table class="w-full border text-sm text-left text-gray-500 ">
                        <thead class="text-xs border text-gray-700  ">
                            <tr>
                                <th scope="col" class="sm:px-8 py-3 text-center items-center justify-center">
                                    Nama Files
                                </th>
                                <th scope="col" class="px-2 py-3 text-center items-center justify-center">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="border">
                            ${tableRowFile}
                        </tbody>
                    </table>
                `;

                return table;
            }

            function loaderElm() {
                return `
            <div class="flex justify-center items-center space-x-2">
                <div class="spinner-grow inline-block w-8 h-8 bg-current rounded-full opacity-0 text-blue-600" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="
                    spinner-grow inline-block w-8 h-8 bg-current rounded-full opacity-0
                        text-purple-500
                    " role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="
                    spinner-grow inline-block w-8 h-8 bg-current rounded-full opacity-0
                        text-green-500
                    " role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow inline-block w-8 h-8 bg-current rounded-full opacity-0 text-red-500" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="
                    spinner-grow inline-block w-8 h-8 bg-current rounded-full opacity-0
                        text-yellow-500
                    " role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow inline-block w-8 h-8 bg-current rounded-full opacity-0 text-blue-300" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow inline-block w-8 h-8 bg-current rounded-full opacity-0 text-gray-300" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                </div>
            `;
            }
        </script>


</body>

</html>