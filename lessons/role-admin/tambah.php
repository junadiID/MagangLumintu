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
        //admin
        continue;
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

$ch1 = curl_init();
$url1 = 'https://lessons.lumintulogic.com/api/modul/read_single_modul.php?id=' . $_GET['modulId'];
curl_setopt($ch1, CURLOPT_URL, $url1);
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
$data1 = curl_exec($ch1);
if ($e2 = curl_error($ch1)) {
    // echo $e;
    echo "
        <script>
            alert('error mendapatkan data');
        </script>";
} else {
    $batchId = json_decode($data1, true);
}
curl_close($ch1);

if ($batchId["error"] || !$batchId) {
    echo "
        <script>
            alert('error mendapatkan data modul');

            location.replace('list-modul.php');
        </script>";
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
    // echo "error";
    echo "
    <script>
        alert('error mendapatkan data batch');
        //location.replace('list-modul.php');
    </script>";
} else {
    // echo "Ga error";
    $take = json_decode($batch1, true);
}
// var_dump($take);

curl_close($ch4);


$ch5 = curl_init();
$url3 = 'https://lessons.lumintulogic.com/api/modul_competence/read_by_modul.php?id=' . $_GET['modulId'];
curl_setopt($ch5, CURLOPT_URL, $url3);
curl_setopt($ch5, CURLOPT_RETURNTRANSFER, true);
$batch2 = curl_exec($ch5);
if ($f = curl_error($ch5)) {
    // echo $f;
} else {
    $bobot = json_decode($batch2, true);
}

curl_close($ch5);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <link rel="shortcut icon" href="../asset/img/logo/favicon.png">
    <title>Prokidz</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="../asset/style/output.css" type="text/css">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />


    <script src="https://kit.fontawesome.com/cb5fcec140.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" c<div class="container">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.1/dist/flowbite.min.css" />


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


        .tox-tinymce {
            max-height: 200px;
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
            /* animation: loader 5s linear infinite; */
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
    <!-- side bar  -->
    <div id="parent_id" style="display:none;"><?php echo $parent_id; ?></div>
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
                        <a id="bantu2" data-modal-toggle="popup-modal" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
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
                            <a data-modal-toggle="popup-modal" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white" onclick=" return confirm('Anda yakin ingin keluar?')">
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

        <div class="bg-cgray w-full h-screen p-3 flex flex-col gap-y-6 overflow-y-scroll rightbar">
            <!-- Header / Profile -->
            <div class="items-center gap-x-4 justify-end hidden sm:flex" id="profil_image2">
                <img class="w-10" src="../asset/img/icons/default_profile.svg" alt="Profile Image" />
                <p class="text-dark-green font-semibold"><?php echo $_SESSION["user_data"]->user->user_username; ?></p>
            </div>


            <!-- Breadcrumb -->
            <div>
                <ul class="flex items-center gap-x-4">
                    <li>
                        <a class="text-light-green" href="list-modul.php">Home</a>
                    </li>
                    <li>
                        <span class="text-light-green">/</span>
                    </li>
                    <li>
                        <a class="text-light-green" href="list-modul.php">List Modul</a>
                    </li>
                    <li>
                        <span class="text-light-green">/</span>
                    </li>
                    <li>
                        <a class="text-light-green text-blue-500" href="tambah.php">Upload Modul</a>
                    </li>
                </ul>
            </div>
            <!-- end breadcrumb -->

            <!-- start edit modul -->
            <div class="p-4 bg-white  rounded-2xl w-full min-w-[15rem] h-fit" 0>

                <div>
                    <div class="md:flex">
                        <div class=" md:flex-1">
                            <p id="bantumodulutama">Topik Pembelajaran <span class="font-semibold"><?php echo $modulId["data"]["modul_name"];  ?></span></p>
                        </div>


                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <form onsubmit="return false">
                            <div class="sm:grid row-span-3">
                                <div class="mt-4">
                                    <div class="sub-modul grid grid-cols-1" id="bantusubmodul">
                                        <label for="" class="font-semibold text-md ">Materi Pembelajaran</label>
                                        <input required type="modul_name" name="modul_name" id="modul_name" class="mb-2  p-2.5 w-full  text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="masukkan nama Materi Pembelajaran disini">
                                    </div>

                                    <div class="deskripsi-sub-modul">
                                        <div class="grid grid-cols-1" id="bantudeskripsi">
                                            <label for="exampleFormControlTextarea1" class="text-md font-semibold form-label inline-block  text-gray-700">Masukkan Deskripsi Pembelajaran</label>
                                            <textarea name="modul_description" id="desc" rows="4" class=" p-2.5 w-full  text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukan deskripsi Pembalajaran disini"></textarea>
                                        </div>
                                    </div>


                                    <div class="mt-2">
                                        <div class="space-y-3">
                                            <div id="MUlai">
                                            </div>
                                            <div class="sm:flex mt-2">
                                                <div id="bantustartdate" class="relative">
                                                    <label for="start-date" class="font-semibold mt-2 text-md">Start Date</label>
                                                    <input type="datetime-local" min="2022-06-30T15:30" id="start-date" name="start-date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block  max-w-[13rem]  " value="<?php echo ($getDataEvent['data'][$totalEvent - 1]['event_start_time']); ?>">
                                                </div>
                                                <span class="p-2 mt-5 text-gray-500 flex-none">to</span>
                                                <div id="bantuenddate" class="relative">
                                                    <label for="start-date" class="font-semibold mt-2 text-md">End Date</label>
                                                    <input type="datetime-local" id="end-date" name="end-date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block max-w-[13rem]  " value="<?php echo ($getDataEvent['data'][$totalEvent - 1]['event_end_time']); ?>">
                                                </div>
                                                <span class="flex mt-4 ml-1  items-center" id="bantuallday">
                                                    <input type="checkbox" name="allday" id="allday" class="rounded-md">
                                                    <span class="text-sm ml-1 flex-none">All Day</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="batch-id mt-2 grid grid-cols-1 ">
                                        <input type="number" name="batchID" class="hidden" value="<?php echo $batchId['data']['batch_id']; ?>">
                                    </div>

                                    <div>
                                        <div class="grid grid-cols-1">
                                            <div id="bantuuploadfile">
                                                <label class=" mb-2 text-sm font-semibold text-black" for="file_input">Upload file</label>
                                                <input required class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5" aria-describedby="file_input_help" id="file_input" type="file" name="file[]" multiple="multiple">

                                                <p class="mt-1 text-[12px] text-gray-500 " id="file_input_help"><span class="text-red-800 font-semibold">*</span>PDF,TXT,MP4,MKV,PPT,PPTX,DOC,DOCX</p>
                                                <p class="text-[12px] text-gray-500"><span class="text-red-800 font-semibold">*</span>Maksimum 5MB</p>
                                            </div>

                                            <div class="flex mt-6">
                                                <a href="list-modul.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" id="bantukembali">
                                                    Kembali
                                                </a>
                                                <div class="flex" id="bantusimpan">
                                                    <button onclick="doPost()" id="btn-simpan" name="send" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                                                    <button disabled id="btn-simpan-disable" name="send" class="hidden ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-not-allowed" disabled>
                                                        <svg role="status" class="inline w-6 h-6 mr-2 text-white animate-spin fill-red-500" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                                                        </svg>
                                                        Memproses...
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end form  -->
                        </form>
                    </div>

                    <div class="sm:mt-[45px] sm:hidden md:hidden hidden sm:block md:block lg:block   ml-10 mb-4" id="bantutreeview">
                        <table class="sm:w-full  text-sm text-left text-gray-500  ">
                            <thead class="text-lg text-black bg-gray-200  ">
                                <tr>
                                    <th scope="col" class="sm:w-ful font-medium py-2 rounded-md">
                                        <p class="text-md font-semibold ml-3 px-3 ">Tree View Modul</p>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                require 'tree-tambah.php';
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div id="btn-loader" class="overlay hidden">
            <div class="loading">
                <div id="loader">
                    <div id="shadow"></div>
                    <div id="box"></div>
                </div>
                <h4>Loading...</h4>
            </div>

        </div>
        <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                <div class="relative bg-white rounded-lg shadow">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center " data-modal-toggle="popup-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 w-14 h-14 text-gray-400 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500">Apakah anda ingin keluar?</h3>
                        <a href="logout.php" data-modal-toggle="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Keluar
                        </a>
                        <button data-modal-toggle="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 ">
                            Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end treview  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
    <!-- CDN JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/jdgq889vwzk6qe7sdoa5zomykgdtarvb92rd6ukb8x0nxkj3/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: 'textarea#desc',
            plugins: [

            ],
            toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
                'alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist checklist outdent indent | removeformat |'
        });


        var today = new Date().toISOString().slice(0, 16);
        let start_date = document.getElementsByName("start-date")[0];
        let end_date = document.getElementsByName("end-date")[0];
        // console.log(end_date);
        // start_date.min = today;
        end_date.disabled = true;
        start_date.addEventListener('input', (e) => {
            end_date.disabled = false;
            end_date.min = e.target.value;
        })

        const intro = introJs();
        intro.setOptions({
            steps: [{
                    intro: "Hi <?php echo $_SESSION["user_data"]->user->user_username; ?>, Ini Adalah Halaman Tambah Materi Pembelajaran"
                },
                {
                    title: 'Nama Topik Pembelajaran',
                    element: document.querySelector('#bantumodulutama'),
                    intro: 'Nama Topik Pembelajaran yang akan ditambahkan Materi didalamnya'
                },
                {
                    title: 'Nama Materi Pembelajaran',
                    element: document.querySelector('#bantusubmodul'),
                    intro: 'Bagian Untuk Memasukkan Materi Pembelajaran yang akan di tambahkan'
                },
                {
                    title: 'Struktur Bagian Topik Pembelajaran',
                    element: document.querySelector('#bantutreeview'),
                    intro: 'Bagian Untuk Melihat Struktur dari Modul Utama yang dipilih'
                },
                {
                    title: 'Deskripsi Materi Pembelajaran',
                    element: document.querySelector('#bantudeskripsi'),
                    intro: 'Bagian Untuk Memasukkan Deskripsi Materi Pembelajaran yang akan di tambahkan'
                },
                {
                    title: 'Tanggal Mulai Materi',
                    element: document.querySelector('#bantustartdate'),
                    intro: 'Bagian Untuk Memasukkan Tanggal Mulai Materi yang akan di tambahkan'
                },
                {
                    title: 'Tanggal Berakhir Materi',
                    element: document.querySelector('#bantuenddate'),
                    intro: 'Isi End Date jika menginginkan Waktu spesifik kelas akan berakhir'
                },
                {
                    title: 'All Days',
                    element: document.querySelector('#bantuallday'),
                    intro: 'Centang All Day jika menginginkan Waktu selesai 24 Jam dari Start Date'
                },
                {
                    title: 'Upload File',
                    element: document.querySelector('#bantuuploadfile'),
                    intro: 'Anda dapat memasukkan lebih dari 1 file'
                },
                {
                    title: 'Kembali ke List Modul',
                    element: document.querySelector('#bantukembali'),
                    intro: 'Tombol Untuk kembali ke Halaman Daftar Materi'
                },
                {
                    title: 'Simpan SubModul',
                    element: document.querySelector('#bantusimpan'),
                    intro: 'Tombol untuk menyimpan Data'
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

        let btnToggle = document.getElementById('btnToggle');
        let btnToggle2 = document.getElementById('btnToggle2');
        let sidebar = document.querySelector('.sidebar');
        let leftNav = document.getElementById("left-nav");
        btnToggle.onclick = function() {
            sidebar.classList.toggle('in-active');
        }

        btnToggle2.onclick = function() {
            leftNav.classList.toggle('hidden');
            $("#btnToggle2").toggleClass("ease-in-out transition-all delay-100");
        }

        var toggler = document.getElementsByClassName("caret");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("caret-down");
            });
        };

        // const checkbox = document.getElementById("flexCheckIndeterminate");
        // checkbox.indeterminate = true;

        //POST
        function validateForm() {
            let modulName = $("input[name='modul_name']").val();
            if (!modulName) {
                console.log("modul name belum diisi");
                return false;
            }

            let description = tinymce.get("desc").getContent();
            if (!description) {
                console.log("deskripsi belum diisi");
                return false;
            }

            // let batchId = $('select[name=batchID]').val();
            // if (!batchId) {
            //     console.log("batch belum dipilih");
            //     return false;
            // }

            let eventStart = $("input[name='start-date']").val();
            if (!eventStart) {
                console.log("start date belum diisi");
                return false;
            }

            let isAllDay = $("input[name='allday']").is(":checked");
            let eventEnd = $("input[name='end-date']").val();
            if (!(eventEnd || isAllDay)) {
                console.log("end date belum diisi");
                return false;
            }

            if (!validateFiles()) {
                return false;
            }

            return true;
        }

        function validateFiles() {
            // validasi form
            // validasi file, kosong atau enga
            // kalau ada file, cek mime type, file size

            let files = $('#file_input').prop('files');
            console.log(files);
            let maxSize = 5 * 1000000; // in bytes
            let allowedType = [
                "video/mp4",
                "video/x-matroska", // "mkv"
                "text/plain", //"txt",
                "application/pdf", // "pdf",
                "application/vnd.ms-powerpoint", // "ppt",
                "application/vnd.openxmlformats-officedocument.presentationml.presentation", // "pptx",
                "application/msword", // "doc",
                "application/vnd.openxmlformats-officedocument.wordprocessingml.document" // "docx"
            ];

            if (files.length == 0) {
                console.log("file kosong");
                return false;
            }

            // console.log(files);
            // console.log(files.length + " file");
            for (let i = 0; i < files.length; i++) {
                // console.log(files[i].name);
                if (jQuery.inArray(files[i].type, allowedType) == -1) {
                    console.log("Jenis file " + files[i].type + " tidak diizinkan!");
                    alert("Jenis file " + files[i].type + " tidak diizinkan!");
                    return false;
                }

                if (maxSize < files[i].size) {
                    console.log("File " + files[i].name + " melebihi maks. size");
                    alert("File " + files[i].name + " melebihi maks. size");
                    return false;
                }
            }

            return true;
        }

        function collectModulPayload() {
            let modulName = $("input[name='modul_name']").val();
            let batchId = $('input[name=batchID]').val();
            let modulDescription = tinymce.get("desc").getContent();

            let url = window.location.href;
            let captured = /modulId=([^&]+)/.exec(url)[1];
            let parentId = captured ? captured : null;

            let payload = {
                modul_name: modulName,
                status: 1,
                parent_id: parentId,
                batch_id: batchId,
                modul_description: modulDescription,
                // modul_weight: weight
            };

            return payload;
        }

        function collectSchedulePayload(modulId) {
            let user = "admin"; //Dari session
            let eventName = $("input[name='modul_name']").val();;
            let description = tinymce.get("desc").getContent();
            let batchId = parseInt($('input[name=batchID]').val());

            let eventStart = $("input[name='start-date']").val() + ":00";
            let eventEnd;

            let isAllDay = $("input[name='allday']").is(":checked");
            if (isAllDay) {
                let date2 = new Date(eventStart); //param dari evenStart
                date2.setHours(23 + 7, 59, 0); // +7 karna GMT
                eventEnd = date2.toISOString().slice(0, -5);
            } else {
                eventEnd = $("input[name='end-date']").val() + ":00";
            }

            let payload = {
                "event_type_id": 1,
                "created_by": user,
                "event_name": eventName,
                "event_start_time": eventStart,
                "event_end_time": eventEnd,
                "event_description": description,
                "batch_id": batchId,
                "modul_id": modulId
            };

            return payload;
        }

        function postSchedule(modulId) {
            let payload = collectSchedulePayload(modulId);
            console.log("post schedule");
            return $.ajax({
                type: "POST",
                url: "https://q4optgct.directus.app/items/events",
                contentType: "application/json",
                dataType: "json",
                processData: false,
                data: JSON.stringify(payload)
            });
        }

        function postModul() {
            let payload = collectModulPayload();
            console.log("trying post modul");
            return $.ajax({
                url: "https://lessons.lumintulogic.com/api/modul/create.php",
                // url: "http://localhost/lessons_sprint2/api/modul/create.php",
                type: "post",
                data: payload
            });
        }

        async function postAllFile(modulId) {
            let files = $("#file_input").get(0).files;
            // console.log(files);
            let resp = [];

            for (let i = 0; i < files.length; i++) {
                try {
                    let fileResp = await postSingleFile(modulId, files[i]);
                    resp.push(fileResp);
                    console.log("file " + (i + 1) + ": " + files[i].name + " berhasil diupload");
                } catch (error) {
                    console.log("file " + (i + 1) + ": " + files[i].name + " gagal diupload");
                    if (error.responseJSON) {
                        // console.log(error.responseJSON);
                        resp.push({
                            error: true,
                            data: {
                                fileName: files[i].name,
                                message: error.responseJSON.message,
                            }
                        });
                    } else {
                        // console.log(error.responseText);
                        resp.push({
                            error: true,
                            data: {
                                fileName: files[i].name,
                                message: "uncaught error"
                            }
                        });
                    }
                }
            }
            return resp;
        }

        async function postSingleFile(modulId, fileData) {
            let formData = new FormData();
            formData.append("modul_id", modulId);
            formData.append("file", fileData);

            return $.ajax({
                url: "https://lessons.lumintulogic.com/api/modul_file/upload.php",
                type: "post",
                contentType: false,
                processData: false,
                cache: false,
                data: formData
            });
        }

        async function doPost() {
            // if (validateForm()) {
            //     // alert("Form sudah benar");
            //     $("#btn-simpan").toggleClass("hidden");
            // $("#btn-loader").toggleClass("hidden");
            // $(".overlay").delay(5000).fadeOut("slow");
            //     postModul();

            if (!validateForm()) {
                alert("Harap isi form dengan benar");
                return;
            }

            //tampilkan loader
            $("#btn-simpan").toggleClass("hidden");
            $("#btn-simpan-disable").toggleClass("hidden");
            $("#btn-loader").toggleClass("hidden");

            // console.log(collectModulPayload());
            let modulRes = false;
            try {
                modulRes = await postModul();
                console.log(modulRes);
            } catch (error) {
                console.log("catch error post modul");
                if (error.responseJSON) {
                    console.log(error.responseJSON);
                } else {
                    console.log("uncaught error");
                }
            }

            if (!modulRes.insertedId) {
                // alert()
                // redirect
                console.log("fom error modul, redirecting..");
                alert("Gagal membuat modul");
                location.reload();
                return;
            }

            //post jadwal
            let scheduleRes = false;
            try {
                scheduleRes = await postSchedule(modulRes.insertedId);
                console.log(scheduleRes);
            } catch (error) {
                console.log("catch error post schedule");
                console.log(error);
                alert("Gagal mengirim jadwal");
            }

            //post file
            let file = false;
            try {
                file = await postAllFile(modulRes.insertedId);
                // console.log("selesai post file");
            } catch (error) {
                console.log("catch error post file");
                console.log(error);
            }
            console.log(file);


            //redirect
            console.log("selesai proses, redirecting...");
            alert("selesai proses, redirecting...");
            $(".overlay").delay(10000).fadeOut("slow");
            location.replace('list-modul.php');
        }
    </script>

    </div>

</body>

</html>