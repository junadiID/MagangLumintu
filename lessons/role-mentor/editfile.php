<?php

// if(isset($_GET['op'])){
//     $op = $_GET['op'];
// }else{
//     $op = "";
// }

session_start();
if (!isset($_SESSION['user_data'])) { //if login in session is not set
    header("Location: https://account.lumintulogic.com/login.php");
}


// $urlf = 'https://lessons.lumintulogic.com/api/modul/read_moduls_tree.php';
// $datajs = file_get_contents($urlf);
// $json = json_decode($datajs, TRUE);

$pars = curl_init();
$subId = 'https://lessons.lumintulogic.com/api/modul/read_single_modul_tree.php?id=' . $_GET['modulId'];
curl_setopt($pars, CURLOPT_URL, $subId);
curl_setopt($pars, CURLOPT_RETURNTRANSFER, true);
$idM = curl_exec($pars);
if ($r = curl_error($pars)) {
    echo $r;
} else {
    $record1 = json_decode($idM, true);
}
curl_close($pars);

$curl = curl_init();
$datal = 'https://lessons.lumintulogic.com/api/modul_file/read_by_modul.php?id=' . $_GET['modulId'];
curl_setopt($curl, CURLOPT_URL, $datal);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$datach = curl_exec($curl);
if ($check = curl_error($curl)) {
    echo $check;
} else {
    $getData = json_decode($datach, true);
}
curl_close($curl);

$curle = curl_init();
$datalEvent = 'https://q4optgct.directus.app/items/events?filter[event_type_id][_eq]=1&filter[modul_id][_eq]=' . $_GET['modulId'];
curl_setopt($curle, CURLOPT_URL, $datalEvent);
curl_setopt($curle, CURLOPT_RETURNTRANSFER, true);
$datachEvent = curl_exec($curle);
if ($checkE = curl_error($curle)) {
    echo $checkE;
} else {
    $getDataEvent = json_decode($datachEvent, true);
    $totalEvent =  count($getDataEvent['data']);
    // print_r($getDataEvent['data'][$totalEvent - 1]);
    // var_dump($getDataEvent);

}
curl_close($curle);

// var_dump($getDataEvent["data"]);
// die;

// var_dump($record1["data"]["child"][0]["modul_name"]);

// die;



$ch = curl_init();
$url = 'https://lessons.lumintulogic.com/api/modul/read_single_modul.php?id=' . $_GET['modulId'];
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);
if ($e = curl_error($ch)) {
    echo $e;
} else {
    $modulId = json_decode($data, true);
}
curl_close($ch);

// var_dump($modulId["data"]) ;
// die;


$ch3 = curl_init();
// $url3 = '192.168.18.136:8000/api/users.php';
$url3 = 'https://account.lumintulogic.com/api/batch.php';
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

    $take = [
        "batch" => []
    ];
    $take['batch'] = [
        [
            "batch_id" => "1",
            "batch_name" => "Batch 1",
            "batch_start_date" => "2022-05-10",
            "batch_end_date" => "2022-05-27"
        ],
        [
            "batch_id" => "2",
            "batch_name" => "Batch 2",
            "batch_start_date" => "2022-05-04",
            "batch_end_date" => "2022-05-31"
        ]
    ];
} else {
    $take = json_decode($batch, true);
}
curl_close($ch3);



if (isset($_POST['send'])) {
    // var_dump($_POST);
    if (isset($_POST['allday'])) {
        $startDate = date("Y-m-d H:i:s", strtotime($_POST['start-date']));
        $endDate = date("Y-m-d H:i:s", strtotime($startDate . ' 23 hours 59 minutes'));

        echo $startDate;
        echo "<br>";
        echo $endDate;
    }
}


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
    <link rel="stylesheet" href="../asset/style/output.css" />

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />
    <script src="https://kit.fontawesome.com/cb5fcec140.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />
    <link href="https://releases.transloadit.com/uppy/v2.12.1/uppy.min.css" rel="stylesheet">


    <!-- Tailwindcss -->
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
                        <button onclick="javascript:bantu();" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                            <img class="w-5" src="../asset/img/icons/icons/help_icon.svg" alt="Help Icon">
                            <p class="font-semibold">Help</p>
                        </button>
                    </li>
                    <!-- ICON DAN TEXT LOG OUT -->
                    <li>
                        <a data-modal-toggle="popup-modal" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
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
                            <a data-modal-toggle="popup-modal" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
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
                        <a class="text-light-green" href="../index.php">Home</a>
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
                        <a class="text-light-green text-blue-500" href="#">Edit Modul</a>
                    </li>
                </ul>
            </div>
            <!-- end breadcrumb -->

            <!-- start edit modul -->
            <div class="p-4 bg-white  rounded-2xl w-full min-w-[15rem] h-fit">

                <div id="">
                    <div class="md:flex">
                        <div class="ml-3 mt-2 md:flex-1">
                            <p id="bantusubmodul">Materi Pembelajaran <?php echo $modulId["data"]["modul_name"];  ?></p>
                        </div>
                    </div>
                </div>

                <form id="edit-form">
                    <!-- <form onsubmit="return false"> -->
                    <div class="grid sm:grid-cols-2 space-x-2">
                        <div class="md:grid row-span-3 mb-[-10px]">
                            <div class="m-3 mt-4">
                                <input type="hidden" name="parent_id" value="<?php echo $modulId["data"]["parent_id"];  ?>" id="bantusubmodul">

                                <div class="grid grid-cols-1 " id="bantusubmoduledit">
                                    <label for="submo" class="font-semibold text-md ">Nama Materi Pembelajaran</label>
                                    <input required class=" mb-2  p-2.5 w-full  text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" id="submo" name="modul_name" value="<?php echo $modulId["data"]["modul_name"];  ?>" placeholder="masukkan nama submodul disini">
                                </div>

                                <div class="grid grid-cols-1" id="bantudeskripsi">
                                    <div class="mt-2">
                                        <label for="desc" name="modul_description" class="text-md font-semibold form-label inline-block  text-gray-700">Masukkan Deskripsi</label>
                                        <textarea name="modul_description" id="desc" rows="4" class="block p-2.5 w-full  text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"><?php echo $modulId["data"]["modul_description"]; ?></textarea>
                                    </div>
                                </div>

                                <div class="sm:flex items-center  mt-2">
                                    <div id="bantustartdate" class="relative">
                                        <label for="start-date" class="font-semibold mt-2 text-md">Start Date</label>
                                        <input type="datetime-local" id="start-date" name="start-date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " value="<?php echo ($getDataEvent['data'][$totalEvent - 1]['event_start_time']); ?>">
                                    </div>
                                    <span class="mx-4 mt-4 text-gray-500">to</span>
                                    <div id="bantuenddate" class="relative">
                                        <label for="start-date" class="font-semibold mt-2 text-md">End Date</label>
                                        <input type="datetime-local" id="end-date" name="end-date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?php echo ($getDataEvent['data'][$totalEvent - 1]['event_end_time']); ?>">
                                    </div>
                                    <span class="flex mt-4 ml-1  items-center" id="bantuallday">
                                        <input type="checkbox" name="allday" id="allday" class="rounded-md">
                                        <span class="text-sm ml-1">All Day</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- end form  -->

                        <div class="m-1">
                            <div id="bantuuploadfile" class="max-h-md">
                                <label class="block mb-2 font-semibold text-md text-gray-900 " for="file_input">Upload file</label>
                                <div id="drag-drop-area" class="w-auto"></div>
                                <p class="mt-1 text-[12px] text-gray-500 " id="file_input_help"><span class="text-red-800 font-semibold">*</span>PDF,TXT,MP4,MKV,PPT,PPTX,DOC,DOCX</p>
                                <p class="text-[12px] text-gray-500"><span class="text-red-800 font-semibold">*</span>Maksimum 5MB</p>
                            </div>
                            <div id="bantulistfile">
                                <?php if (empty($getData["data"])) : ?>
                                    <div class="p-2 items-center ml-3 mt-2">Tidak ada File</div>

                                <?php else : ?>
                                    <?php foreach ($getData["data"] as $datas) : ?>
                                        <div data-filesection="<?= $datas['id']; ?>" class="flex items-center p-1 border-2 rounded-lg border-dashed border-black  border-solid border-gray-200 truncate mt-3 ">
                                            <a href="#" class="flex-1">
                                                <p class=" text-lg font-normal tracking-tight text-gray-900 ml-3 truncate"><?= $datas["file_name"]; ?></p>
                                            </a>

                                            <div class="text-red-600 hover:text-red-900 items-center cursor-pointer ">
                                                <a class="bi bi-trash-fill">
                                                    <input type="button" class="cursor-pointer" onclick="deleteFile(<?= $datas['id']; ?>)" value="Hapus">
                                                <a>

                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>



                            <div class="flex mt-3  sm:float-right">
                                <a href="list-modul.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" id="bantukembali">
                                    Kembali
                                </a>
                                <button id="btn-simpan" name="send" class=" ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
                                <!-- <button onclick="doUpdate()" id="btn-simpan" name="send" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button> -->

                            </div>
                        </div>
                    </div>
                </form>
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
    <div id="popup-modal" tabindex="-1"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                <div class="relative bg-white rounded-lg shadow">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center "
                        data-modal-toggle="popup-modal">
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
                        <a href="logout.php" data-modal-toggle="popup-modal" type="button"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Keluar
                        </a>
                        <button data-modal-toggle="popup-modal" type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 ">
                            Batal</button>
                    </div>
                </div>
            </div>
        </div>

    <script src="https://releases.transloadit.com/uppy/v2.12.1/uppy.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
    <!-- CDN JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <script>
      var uppy = new Uppy.Core()
        .use(Uppy.Dashboard, {
          inline: true,
          target: '#drag-drop-area'
        })
        .use(Uppy.Tus, {endpoint: 'https://tusd.tusdemo.net/files/'})

      uppy.on('complete', (result) => {
        console.log('Upload complete! We’ve uploaded these files:', result.successful)
      })
    </script>
  <script>
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
        var today = new Date().toISOString().slice(0, 16);
            let start_date = document.getElementsByName("start-date")[0];
            let end_date = document.getElementsByName("end-date")[0];
            start_date.min = today;
            end_date.disabled = false;
            start_date.addEventListener('input', (e) => {
            end_date.disabled = false;
            end_date.min = e.target.value;
        })
  </script>
  <script>


        const intro = introJs();

        intro.setOptions({
            steps: [{
                    intro: "Hi <?php echo $_SESSION["user_data"]->user->user_username; ?>, Ini Adalah Halaman Edit Materi Pembelajaran"
                },
                {
                    title: 'Nama Materi Pembelajaran',
                    element: document.querySelector('#bantusubmodul'),
                    intro: 'Menampilkan Nama Materi Pembelajaran yang akan diedit'
                },
                {
                    title: 'Nama SubModul',
                    element: document.querySelector('#bantusubmoduledit'),
                    intro: 'Bagian Untuk Mengedit Nama Materi Pembelajaran'
                },
                {

                    title: 'Deskripsi Materi Pembelajaran',
                    element: document.querySelector('#bantudeskripsi'),
                    intro: 'Bagian Untuk Mengedit Deskripsi Materi Pembelajaran'
                },
                {
                    title: 'Tanggal Mulai Materi Pembelajaran',
                    element: document.querySelector('#bantustartdate'),
                    intro: 'Bagian Untuk Edit tanggal Mulai Kelas'
                },
                {
                    title: 'Tanggal Berakhir Materi Pembelajaran',
                    element: document.querySelector('#bantuenddate'),
                    intro: 'Bagian untuk Edit tanggal Berakhir Kelas secara Spesifik'
                },
                {
                    title: 'All Days',
                    element: document.querySelector('#bantuallday'),
                    intro: 'Centang All Day jika menginginkan Waktu selesai 24 Jam dari Start Date'
                },
                {
                    title: 'Upload File',
                    element: document.querySelector('#bantuuploadfile'),
                    intro: 'Anda dapat Menambah lebih dari 1 file'
                },
                {
                    title: 'Daftar File',
                    element: document.querySelector('#bantulistfile'),
                    intro: 'Berisi Daftar file yang ada di Submodul yang di pilih'
                },
                {
                    title: 'Kembali ke List Modul',
                    element: document.querySelector('#bantukembali'),
                    intro: 'Tombol Untuk kembali ke Halaman Daftar Materi'
                },
                {
                    title: 'Simpan SubModul',
                    element: document.querySelector('#btn-simpan'),
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


        function bantu() {
            introJs().setOptions({
                steps: [{
                        intro: "Hi <?php echo $_SESSION["user_data"]->user->user_username; ?>, Ini Adalah Halaman Edit Materi Pembelajaran"
                    },
                    {
                        title: 'Nama Materi Pembelajaran',
                        element: document.querySelector('#bantusubmodul'),
                        intro: 'Menampilkan Nama Materi Pembelajaran yang akan diedit'
                    },
                    {
                        title: 'Nama SubModul',
                        element: document.querySelector('#bantusubmoduledit'),
                        intro: 'Bagian Untuk Mengedit Nama Materi Pembelajaran'
                    },
                    {
                        title: 'Deskripsi Materi Pembelajaran',
                        element: document.querySelector('#bantudeskripsi'),
                        intro: 'Bagian Untuk Mengedit Deskripsi Materi Pembelajaran'
                    },
                    {
                        title: 'Tanggal Mulai Materi Pembelajaran',
                        element: document.querySelector('#bantustartdate'),
                        intro: 'Bagian Untuk Edit tanggal Mulai Kelas'
                    },
                    {
                        title: 'Tanggal Berakhir Materi Pembelajaran',
                        element: document.querySelector('#bantuenddate'),
                        intro: 'Bagian untuk Edit tanggal Berakhir Kelas secara Spesifik'
                    },
                    {
                        title: 'All Days',
                        element: document.querySelector('#bantuallday'),
                        intro: 'Centang All Day jika menginginkan Waktu selesai 24 Jam dari Start Date'
                    },
                    {
                        title: 'Upload File',
                        element: document.querySelector('#bantuuploadfile'),
                        intro: 'Anda dapat Menambah lebih dari 1 file'
                    },
                    {
                        title: 'Daftar File',
                        element: document.querySelector('#bantulistfile'),
                        intro: 'Berisi Daftar file yang ada di Submodul yang di pilih'
                    },
                    {
                        title: 'Kembali ke List Modul',
                        element: document.querySelector('#bantukembali'),
                        intro: 'Tombol Untuk kembali ke Halaman Daftar Materi'
                    },
                    {
                        title: 'Simpan SubModul',
                        element: document.querySelector('#btn-simpan'),
                        intro: 'Tombol untuk menyimpan Data'
                    }

                ]

            }).start();
        };

        $("#edit-form").submit(function(e) {
            e.preventDefault();
            doUpdate();
        });

        function doUpdate() {
            if (!validateForm()) {
                alert("Harap isi form dengan benar");
            }

            $("#btn-simpan").toggleClass("");
            $("#btn-loader").toggleClass("hidden");

            updateModul();
            console.log("selesai update modul");

            // post file

            //window.location.replace("list-modul.php");

        }

            // function deleteFile(id) {
            //         let ok = confirm("Apakah anda yakin menghapus file?");
            //         if (ok) {
            //         console.log("deleting file..");
            //         // delete div
            //         let fileElm = $(`[data-filesection=${id}]`);
            //         fileElm.remove();
            //     }
            // }

        function deleteFile(id) {
            let ok = confirm("Apakah anda yakin menghapus file?");
            if (ok) {
                console.log("deleting file..");
                $.ajax({
                    url: "https://lessons.lumintulogic.com/api/modul_file/delete_single.php",
                    type: "post",
                    data: {
                        id: id
                    },
                    success: function(res) {
                        deleteFile(id);
                        console.log(res);
                        if (!res.error) {
                            console.log("berhasil delete file id: " + res.deletedId);

                            // delete div
                            let fileElm = $("[data-filesection=" + res.deletedId + "]");
                            fileElm.remove();

                        } else {
                            console.log("gagal delete file ");
                        }
                    },
                    error: function() {
                        console.log("gagal delete");
                    }
                });
            }
        }

        function validateForm() {
            let modulName = $("input[name='modul_name']").val();
            if (!modulName) {
                console.log("modul name belum diisi");
                return false;
            }


            // let batchId = $('select[name=batchID]').val();
            // if (!batchId) {
            //     console.log("batch belum dipilih");
            //     return false;
            // }

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

        function postFile(modulId) {
            let files = $("#file_input").get(0).files;
            console.log(files);
            // return false;

            for (let i = 0; i < files.length; i++) {
                let formData = new FormData();
                formData.append("modul_id", modulId);
                formData.append("file", files[i]);
                $.ajax({
                    url: "https://lessons.lumintulogic.com/api/modul_file/upload.php",
                    type: "post",
                    contentType: false,
                    processData: false,
                    cache: false,
                    data: formData,
                    success: function(res) {
                        res = JSON.parse(res);
                        if (!res.error) {
                            console.log("berhasil insert file: " + files[i].name);
                            if (i == (files.length - 1)) {
                                console.log(i);
                                console.log("selesai upload file..");
                                window.location.replace("list-modul.php");
                            }
                        } else {
                            console.log("gagal insert file");
                            alert("Gagal insert file!");
                            console.log(res.message);
                            window.location.replace("list-modul.php");
                        }
                    },
                    error: function() {
                        console.log("gagal insert file");
                        window.location.replace("list-modul.php");
                    }
                });
            }
        }

        function updateModul() {
            // alert("tes");
            let modulName = $("input[name='modul_name']").val();
            let parentId = $("input[name='parent_id']").val();
            let status = 1;
            let batchId = $('select[name=batchID]').val();
            let modulDescription = $('textarea#desc').val();
    
            // let weight = $("input[name='competenceWeight']").val();

            let url = window.location.href;
            let captured = /modulId=([^&]+)/.exec(url)[1];
            let modulId = captured ? captured : null;

            // console.log(modulName);
            // console.log(modulDescription);
            // console.log(modulId);
            // console.log(batchId);
            // console.log(weight);
            // console.log(parentId);

            // return false;
            console.log("update modul");
            $.ajax({
                url: "https://lessons.lumintulogic.com/api/modul/update.php",
                type: "post",
                data: {
                    id: modulId,
                    modul_name: modulName,
                    status: 1,
                    parent_id: parentId,
                    batch_id: batchId,
                    modul_description: modulDescription
                },
                success: function(res) {
                    if (!res.error) {
                        console.log("berhasil edit modul, id: " + res.updatedId);
                        alert("Edit Materi Pembelajaran Berhasil!");

                        updateSchedule();
                        
                        // location.replace("list-modul.php");

                    } else {
                        console.log("gagal update modul");
                        window.location.replace("list-modul.php");
                    }
                },
                error: function() {
                    console.log("gagal post");
                }
            });

        }

        function updateSchedule() {
            // let user = "admin"; //Dari session
            let eventName = $("input[name='modul_name']").val();;
            let description = $('textarea#desc').val();
            // let batchId = parseInt($('input[name=batchID]').val());

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

            body = {
                "event_name": eventName,
                "event_start_time": eventStart,
                "event_end_time": eventEnd,
                "event_description": description,
            };

            console.log(body);
            // contoh format tanggal: "2022-05-11T13:36:33"

            console.log("update schedule");
            $.ajax({
                type: "PATCH",
                // url: "https://q4optgct.directus.app/items/events/" + <?php echo $modulId["data"]["schedule_id"]  ?>,
                url: "https://q4optgct.directus.app/items/events/" + <?php echo $getDataEvent['data'][$totalEvent - 1]['event_id']; ?>,
                contentType: "application/json",
                dataType: "json",
                processData: false,
                data: JSON.stringify(body),
                success: function(res) {
                    console.log(res);
                    console.log("berhasil update schedule");
                    alert("berhasil update jadwal");

                    if ($('#file_input').prop('files').length > 0) {
                        if (validateFiles()) {
                            let url = window.location.href;
                            let captured = /modulId=([^&]+)/.exec(url)[1];
                            let modulId = captured ? captured : null;
                            postFile(modulId);
                        }
                    } else {
                        console.log("file kosong");
                        window.location.replace("list-modul.php");
                    }

                    // alert(res);
                },
                error: function(errMsg) {
                    // alert(errMsg);
                    console.log("gagal update schedule");
                    console.log(errMsg);
                    alert("gagal update jadwal");

                }
            });
        }
    </script>


</body>

</html>