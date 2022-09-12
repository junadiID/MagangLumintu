<?php 

require_once "templates/header.php"; 

$title_page = "Faq"; 

?>
</head>

<style>
            .tab {
            overflow: hidden;
            }
            .tab-content {
            max-height: 0;
            transition: all 0.5s;
            }
            input:checked + .tab-label .test {
                background-color: #000;
            }
            input:checked + .tab-label .test svg {
                transform: rotate(180deg);
                stroke: #fff;
            }
            input:checked + .tab-label::after {
            transform: rotate(90deg);
            }
            input:checked ~ .tab-content {
            max-height: 100vh;
            }
        </style>
<body>

<div class="bg-[#f1f5f9]">
    <div class="text-center w-full mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 z-20">
        <h2 class="text-3xl font-semibold text-slate-700 sm:text-4xl">
            <span class="block">
            Frequently Asked Questions 
            </span>
            <span class="block text-indigo-500">
            (FAQ)
            </span>
        </h2>
    </div>
</div>

<main class="w-full p-8 mx-auto">
            <section class="shadow row">
                <div class="tabs">
                    <div class="border-b tab">
                        <div class="border-l-2 border-transparent relative">
                            <input class="w-full absolute z-10 cursor-pointer opacity-0 h-5 top-6" type="checkbox" id="chck1">
                            <header class="flex justify-between items-center p-5 pl-8 pr-8 cursor-pointer select-none tab-label" for="chck1">
                                <span class="text-grey-darkest font-thin text-xl">
                                Bagaimana Update profile ?
                                </span>
                                <div class="rounded-full border border-grey w-7 h-7 flex items-center justify-center test">
                                    <!-- icon by feathericons.com -->
                                    <svg aria-hidden="true" class="" data-reactid="266" fill="none" height="24" stroke="#606F7B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <polyline points="6 9 12 15 18 9">
                                        </polyline>
                                    </svg>
                                </div>
                            </header>
                            <div class="tab-content">
                                <div class="pl-8 pr-8 pb-5 text-grey-darkest">
                                    <ul class="pl-4">
                                        <li class="pb-2">
                                        Pada bagian ini anda bisa merubah profile yang anda miliki, merubah username, merubah foto profil dan about me pada akun profile yang tersedia :
                                        </li>
                                        <ol class="list-decimal">
                                        <li class="pb-2">
                                        Sign in to office.com/signin with your Microsoft 365 for business.
                                        </li>
                                        <li class="pb-2">
                                        Select your profile picture.
                                        </li>
                                        <li class="pb-2">
                                        Select My profile.
                                        </li>
                                        <li class="pb-2">
                                        Select Update profile
                                        </li>
                                        <li class="pb-2">
                                        Update the information you want, such as About me, Projects, and more.
                                        </li>
                                        <li class="pb-2">
                                        Masuk ke gradit.com/profil dengan akun anda 
                                        </li>
                                        <li class="pb-2">
                                        Klik Akun Profil
                                        </li>
                                        <li class="pb-2">
                                        Rubah Nama, Username, Pasword dan juga foto profil anda atau yang anda butuhkan.
                                        </li>
                                        <li class="pb-2">
                                        Save Update Profil 
                                        </li>
                                        </ol>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-b tab">
                        <div class="border-l-2 border-transparent relative">
                            <input class="w-full absolute z-10 cursor-pointer opacity-0 h-5 top-6" type="checkbox" id="chck2">
                            <header class="flex justify-between items-center p-5 pl-8 pr-8 cursor-pointer select-none tab-label" for="chck2">
                                <span class="text-grey-darkest font-thin text-xl">
                                Bagaimana Lupa Password ?
                                </span>
                                <div class="rounded-full border border-grey w-7 h-7 flex items-center justify-center test">
                                    <!-- icon by feathericons.com -->
                                    <svg aria-hidden="true" class="" data-reactid="266" fill="none" height="24" stroke="#606F7B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <polyline points="6 9 12 15 18 9">
                                        </polyline>
                                    </svg>
                                </div>
                            </header>
                            <div class="tab-content">
                                <div class="pl-8 pr-8 pb-5 text-grey-darkest">
                                    <ul class="pl-4">
                                        <li class="pb-2">
                                        Pada bagian ini anda akan merubah password anda sebelumnya 
                                        Jika kamu ingin merubah pasword lakukan langkah berikut :
                                        </li>
                                        <ol class="list-decimal">
                                        <li class="pb-2">
                                        Klik ‘Masuk’ pada pojok kanan halaman.
                                        </li>
                                        <li class="pb-2">
                                        Klik ‘Saya Tidak Bisa Masuk’.
                                        </li>
                                        <li class="pb-2">
                                        Pilih ‘Lupa kata sandi’ dan masukkan alamat e-mail Kamu yang terdaftar di Kampus Merdeka.
                                        </li>
                                        <li class="pb-2">
                                        Cek kotak masuk e-mail Kamu dan klik link yang tercantum untuk memasukkan password baru Kamu.
                                        </li>
                                        <li class="pb-2">
                                        Kemudian silakan lakukan login kembali dengan memasukkan password baru yang telah berhasil kamu masukkan.
                                        </li>
                                        </ol>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-b tab">
                        <div class="border-l-2 border-transparent relative">
                            <input class="w-full absolute z-10 cursor-pointer opacity-0 h-5 top-6" type="checkbox" id="chck3">
                            <header class="flex justify-between items-center p-5 pl-8 pr-8 cursor-pointer select-none tab-label" for="chck3">
                                <span class="text-grey-darkest font-thin text-xl">
                                Bagaimana cara mengubah course yang sudah saya kerjakan ?
                                </span>
                                <div class="rounded-full border border-grey w-7 h-7 flex items-center justify-center test">
                                    <!-- icon by feathericons.com -->
                                    <svg aria-hidden="true" class="" data-reactid="266" fill="none" height="24" stroke="#606F7B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <polyline points="6 9 12 15 18 9">
                                        </polyline>
                                    </svg>
                                </div>
                            </header>
                            <div class="tab-content">
                                <div class="pl-8 pr-8 pb-5 text-grey-darkest">
                                    <ul class="pl-4">
                                        <li class="pb-2">
                                        Pada bagian ini, yang bisa anda lakukan adalah merubah, memilih dan menyimpan course yang anda akan kerjakan.
                                        </li>
                                        <ol class="list-decimal">
                                        <li class="pb-2">
                                        Klik pada Fitur Course.
                                        </li>
                                        <li class="pb-2">
                                        Pilih Course yang ingin dirubah. 
                                        </li>
                                        <li class="pb-2">
                                        Klik Asessment yang sudah dikerjakan. 
                                        </li>
                                        <li class="pb-2">
                                        Klik Rubah, Lalu klik simpan ketika sudah selesai. 
                                        </li>
                                        <li class="pb-2">
                                        Kembali ke menu Home. 
                                        </li>
                                        </ol>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-b tab">
                        <div class="border-l-2 border-transparent relative">
                            <input class="w-full absolute z-10 cursor-pointer opacity-0 h-5 top-6" type="checkbox" id="chck3">
                            <header class="flex justify-between items-center p-5 pl-8 pr-8 cursor-pointer select-none tab-label" for="chck3">
                                <span class="text-grey-darkest font-thin text-xl">
                                Bagaimana Konsultasi Bersama Mentor ?
                                </span>
                                <div class="rounded-full border border-grey w-7 h-7 flex items-center justify-center test">
                                    <!-- icon by feathericons.com -->
                                    <svg aria-hidden="true" class="" data-reactid="266" fill="none" height="24" stroke="#606F7B" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <polyline points="6 9 12 15 18 9">
                                        </polyline>
                                    </svg>
                                </div>
                            </header>
                            <div class="tab-content">
                                <div class="pl-8 pr-8 pb-5 text-grey-darkest">
                                    <ul class="pl-4">
                                        <li class="pb-2">
                                        Pada bagian ini anda akan memilih waktu berkonsultasi bersama mentor, mengenai pembelajaran dan course yang anda telah pilih sebelumnya.
                                        </li>
                                        <ol class="list-decimal">
                                        <li class="pb-2">
                                        Klik Home - Mentor.
                                        </li>
                                        <li class="pb-2">
                                        Daftar mentor - Jadwalkan waktu bimbingan.
                                        </li>
                                        <li class="pb-2">
                                        Pilih waktu bimbingan - lalu klik simpan. 
                                        </li>
                                        <li class="pb-2">
                                        Setelah itu klik simpan. 
                                        </li>
                                        <li class="pb-2">
                                        Lalu kembali ke menu home. 
                                        </li>
                                        </ol>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        
<footer class="p-4 bg-white rounded-lg shadow md:px-8 md:py-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <a href="#" class="flex items-center mb-4 sm:mb-0">
            <img src="assets/logo/logo_lumintu.png" class="mr-3 h-full w-36" alt="GradIT Logo">
        </a>
        <ul class="flex flex-wrap items-center mb-6 text-sm text-gray-500 sm:mb-0">
            <li>
                <a href="#" class="mr-4 hover:underline md:mr-6 ">About</a>
            </li>
            <li>
                <a href="#" class="mr-4 hover:underline md:mr-6">Privacy Policy</a>
            </li>
            <li>
                <a href="#" class="mr-4 hover:underline md:mr-6 ">Licensing</a>
            </li>
            <li>
                <a href="#" class="hover:underline">Contact</a>
            </li>
        </ul>
    </div>
    <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8">
    <span class="block text-sm text-gray-500 sm:text-center">© 2022 <a href="#" class="hover:underline">GradIT</a>. All Rights Reserved.
</span>
</footer>