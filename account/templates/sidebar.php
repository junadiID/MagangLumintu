<div id="bantu1" class="bg-white w-[350px] h-screen px-8 py-6 flex flex-col justify-between sidebar in-active">
    <div class="flex flex-col gap-y-6">
        <div class="flex items-center space-x-4 px-2">
            <img src="assets/icons/toggle_icons.svg" alt="toggle_dashboard" class="w-8 cursor-pointer" id="btnToggle">
            <img class="w-[150px] logo-gradit" src="assets/logo/logo_lumintu.png" alt="Logo">
        </div>
     <hr class="border-[1px] border-opacity-50 border-[#93BFC1]">
        <div>
            <ul class="flex flex-col gap-y-1">
                <li>
                    <?php if ($user->is_admin(Session::get('email')) || $user->is_mentor(Session::get('email'))) : ?>
                    <a href="dashboard.php"
                        class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                        <img class="w-5" src="assets/icons/home_icon.svg" alt="Dashboard Icon">
                        <p class="font-semibold">Beranda</p>
                    </a>
                    <?php else: ?>
                    <a href="home.php"
                        class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                        <img class="w-5" src="assets/icons/home_icon.svg" alt="Dashboard Icon">
                        <p class="font-semibold">Beranda</p>
                    </a>
                    <?php endif; ?>
                </li>
                <?php if ($user->is_admin(Session::get('email'))) : ?>
                    <li>
                        <a href="https://lumintulearning.tech/lessons/auth.php?token=<?= $_SESSION['jwt'] ?>&expiry=<?php echo $_SESSION['expiry'] ?>"
                            class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                            <img class="w-5 fill-black" src="assets/icons/course_icon.svg" alt="Dashboard Icon">
                            <p class="font-semibold">Materi</p>
                        </a>
                    </li>
                <?php elseif ($user->is_mentor(Session::get('email'))) : ?>
                <li>
                    <a href="https://lumintulearning.tech/lessons/auth.php?token=<?= $_SESSION['jwt'] ?>&expiry=<?php echo $_SESSION['expiry'] ?>"
                        class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                        <img class="w-5 fill-black" src="assets/icons/course_icon.svg" alt="Dashboard Icon">
                        <p class="font-semibold">Materi</p>
                    </a>
                </li>
                <li>
                    <a href="https://lumintulearning.tech/assigement/auth.php?token=<?= $_SESSION['jwt']; ?>&expiry=<?= $_SESSION['expiry']; ?>&page=index"
                        class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                        <img class="w-5" src="assets/icons/attendance_icon.svg" alt="Dashboard Icon">
                        <p class="font-semibold">Penugasan</p>
                    </a>
                </li>

                <li>
                    <a href="https://lumintulearning.tech/consultation/auth.php?token=<?= $_SESSION['jwt']; ?>&expiry=<?= $_SESSION['expiry']; ?>"
                        class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                        <img class="w-5" src="assets/icons/discussion_icon.svg" alt="Dashboard Icon">
                        <p class="font-semibold"> Konsultasi</p>
                    </a>
                </li> 
                <li>
                    <a href="https://lumintulearning.tech/schedule/auth.php?token=<?= ($_SESSION['jwt']); ?>&expiry=<?= $_SESSION["expiry"]; ?>"
                        class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                        <img class="w-5" src="assets/icons/schedule_icon.svg" alt="Dashboard Icon">
                        <p class="font-semibold">Jadwal</p>
                    </a>
                </li>      
                <?php elseif (!$user->is_mentor(Session::get('email')) && !$user->is_admin(Session::get('email'))): ?>
                <li>
                    <a href="https://lumintulearning.tech/assigment/auth.php?token=<?= $_SESSION['jwt']; ?>&expiry=<?= $_SESSION['expiry']; ?>&page=index"
                        class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                        <img class="w-5" src="assets/icons/attendance_icon.svg" alt="Dashboard Icon">
                        <p class="font-semibold">Penugasan</p>
                    </a>
                </li>
                <li>
                    <a href="https://lumintulearning.tech/assigment/auth.php?token=<?= $_SESSION['jwt']; ?>&expiry=<?= $_SESSION['expiry']; ?>&page=score"
                        class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                        <img class="w-5" src="assets/icons/score_icon.svg" alt="Dashboard Icon">
                        <p class="font-semibold">Nilai</p>
                    </a>
                </li>

                <li>
                    <a href="https://lumintulearning.tech/consultation/auth.php?token=<?= $_SESSION['jwt']; ?>&expiry=<?= $_SESSION['expiry']; ?>"
                        class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                        <img class="w-5" src="assets/icons/discussion_icon.svg" alt="Dashboard Icon">
                        <p class="font-semibold"> Konsultasi</p>
                    </a>
                </li> 
                <li>
                    <a href="https://lumintulearning.tech/schedule/auth.php?token=<?= ($_SESSION['jwt']); ?>&expiry=<?= $_SESSION["expiry"]; ?>"
                        class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                        <img class="w-5" src="assets/icons/schedule_icon.svg" alt="Dashboard Icon">
                        <p class="font-semibold">Jadwal</p>
                    </a>
                </li>      
                <?php endif; ?>                 
            </ul>
        </div>
    </div>
    <div>
        <ul class="flex flex-col ">
            <li>
                <a href="faq.php"
                    class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                    <img class="w-5" src="assets/icons/help_icon.svg" alt="Help Icon">
                    <p class="font-semibold">Bantuan</p>
                </a>
            </li>
            <li>                
                <a id="bantu2" data-modal-toggle="popup-modal"
                    class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                    <img class="w-5" src="assets/icons/logout_icon.svg" alt="Log out Icon">
                    <p class="font-semibold">Keluar</p>
                </a>
            </li>
        </ul>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
