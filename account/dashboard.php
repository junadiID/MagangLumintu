<?php

require_once 'core/init.php';


if (!$user->is_loggedIn()) {
    Session::flash('login', 'Anda harus login terlebih dahulu');
    Redirect::to('login');
}


if (!$user->is_admin(Session::get('email')) && !$user->is_mentor(Session::get('email')) ) {
    Session::flash('account-settings', 'Halaman ini khusus Admin');
    Redirect::to('account-settings');
}

$user_data = $user->get_data( Session::get('email') );

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
    <link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css" />

    <title>Dashboard | Lumintu Classsroom</title>

    <!-- Flowbite CSS -->
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.1/dist/flowbite.min.css" />

    <!-- DaisyUI -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.14.3/dist/full.css" rel="stylesheet" type="text/css" />

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
                        <a href="account-settings.php"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-400 hover:text-white">
                            Account Settings
                        </a>
                    </div>
                </div>
            </div>

            <!-- Breadcrumb -->
            <div>
                <ul class="flex items-center gap-x-4">
                    <li>
                        <a class="text-light-green" href="#">Dashboard</a>
                    </li>
                </ul>
            </div>

            <!-- card user -->
            <div class="flex flex-wrap -m-4">
                <div class="p-4 md:w-1/3" id="tabuser">
                <div class="h-full rounded-xl bg-white overflow-hidden">
                <a href="users.php">
                    <img
                    class="lg:h-48 md:h-36 w-full object-top pt-5 scale-110 transition-all duration-400 hover:scale-100"
                    src="assets/img/Consulting-rafiki(1).svg"
                    alt="blog">
                </a>
                <a href="users.php">
                    <div class="p-6">
                    <br>
                    <h1 class="title-font text-lg font-medium text-gray-600 mb-3">User</h1>
                    <p class="leading-relaxed mb-3">Melihat daftar data user.</p>
                    <div class="flex items-center flex-wrap ">
                    </div>
                    </div>
                </a>
                </div>
            </div>

            <!-- card batch -->
            <div class="p-4 md:w-1/3" id="tabbatch">
                <div class="h-full rounded-xl bg-white overflow-hidden">
                <a href="batch.php">
                    <img
                    class="lg:h-48 md:h-36 w-full object-top pt-5 scale-110 transition-all duration-400 hover:scale-100"
                    src="assets/img/Add tasks-pana.svg"
                    alt="blog">
                </a>
                <a href="batch.php">
                    <div class="p-6">
                    <br>
                    <h1 class="title-font text-lg font-medium text-gray-600 mb-3">Batch</h1>
                    <p class="leading-relaxed mb-3">Melihat daftar data batch.</p>
                    <div class="flex items-center flex-wrap ">
                    </div>
                    </div>
                </a>
                </div>
            </div>
        </div>

            <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
            <script defer src="https://unpkg.com/alpinejs@3.2.4/dist/cdn.min.js"></script>
            <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
            <script>

                let btnToggle = document.getElementById('btnToggle');
                let sidebar = document.querySelector('.sidebar');
                btnToggle.onclick = function () {
                    sidebar.classList.toggle('in-active');
                }


                const intro = introJs();

                intro.setOptions({
                    steps: [{
                        title: 'Welcome',
                        intro: 'Hallo Selamat Datang! 👋'
                    },
                    {
                        element: document.querySelector('#bantu1'),
                        intro: 'Ini adalah sidebar'
                    },
                    {
                        element: document.querySelector('#bantu2'),
                        intro: 'Ini untuk keluar'
                    },
                    {
                        element: document.querySelector('#tabuser'),
                        intro: 'Klik ini untuk melihat user'
                    },
                    {
                        element: document.querySelector('#tabbatch'),
                        intro: 'Klik ini untuk melihat batch'
                    },
                    {
                        title: 'Step Selesai',
                        intro: 'Thank You! 👋'
                    }]
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
                if(value == null) {
                    intro.start().oncomplete(func).onexit(func);
                };
            // end intro js
            </script>
</body>

</html>