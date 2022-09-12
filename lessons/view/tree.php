<?php $i = 1; ?>
<?php foreach ($json["data"] as $modul) : ?>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 ">

        <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
            <?= $i; ?>
        </td>
        <?php $i++ ?>
        <td class="px-8 py-4">
            <ul id="myUL">
                <li><span class="caret text-black text-lg" id="materi-1"><?= $modul["modul_name"]; ?></span>
                    <ul class="nested">
                        <li>
                            <?php foreach ($modul["child"] as $sub1) : ?>
                        <li>
                            <span class="caret flex bg-gray-100 shadow-sm p-2 rounded items-center ml-3 mt-2">
                                <div class="flex-1">
                                    <a href="" class=" text-black text-[15px]"><?= $sub1["modul_name"]; ?></a>
                                    <p class=" text-justify text-xs text-black p-1 ">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Labore quasi architecto provident nesciunt dolor ipsam quos veritatis esse cumque inventore suscipit enim blanditiis consequatur necessitatibus itaque corrupti magnam, officiis ullam!</p>
                                </div>

                                <!-- Modal toggle -->
                                <img src="" alt="" class="block  font-medium rounded-lg w-8 text-center" type="button" data-modal-toggle="popup-modal">

                                <!-- Delete Product Modal -->
                                <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
                                    <div class="relative p-4  md:w-auto">
                                        <!-- Modal content -->
                                        <div class="relative bg-white   rounded-lg shadow dark:bg-gray-700">
                                            <!-- Modal body --><a class="text-black items-center mr-3 text-lg"><?= $sub1["modul_name"]; ?></a>

                                            <div class="m-2 text-center  md:flex grid md:grid-cols-6">
                                                <a href="#" data-modal-toggle="popup-modal" class="mt-2 focus:outline-none text-white bg-yellow-700 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-3 py-2 mr-2 mb-2 ">
                                                    <i class="bi bi-cloud-arrow-down-fill mr-1"></i> Unduh
                                                </a>
                                                <a href="../model/kompetensi.php" data-modal-toggle="popup-modal" class="mt-2 focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-2 mr-2 mb-2 ">
                                                    <i class="bi bi-eye-fill mr-1"></i> View
                                                </a>
                                                <a href="./model/edit-modul.php" data-modal-toggle="popup-modal" class="mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 mr-2 mb-2 ">
                                                    <i class="bi bi-pencil-fill mr-1 "></i>Edit
                                                </a>
                                                <a href="#" data-modal-toggle="popup-modal" class=" mt-2 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 mr-2 mb-2 ">
                                                    <i class="bi bi-trash-fill mr-1"></i> Hapus
                                                </a>
                                                <button type="button" class="mt-2 focus:outline-none text-white bg-indigo-700 hover:bg-indigo-600 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-3 py-2 mr-2 mb-2 dark:focus:ring-yellow-900" data-modal-toggle="popup-modal">
                                                    <i class="bi bi-x-circle-fill mr-1"></i> Batal
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </span>

                            <ul class="nested ml-5">
                                <?php foreach ($sub1["child"] as $sub2) : ?>
                                    <li>
                                        <div class="caret flex bg-gray-100 shadow-sm p-2 rounded items-center ml-3 mt-2">
                                            <div class="flex-1">
                                                <a href="" class=" text-black text-[15px]"><?= $sub2["modul_name"]; ?></a>
                                            </div>

                                            <!-- Modal toggle -->
                                            <img src="../Img/icon/setting.svg" alt="" class="block  font-medium rounded-lg w-6 text-center" type="button" data-modal-toggle="popup-modal">

                                            <!-- Delete Product Modal -->
                                            <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
                                                <div class="relative p-4 sm:w-full max-w-md s,:h-full md:h-auto">
                                                    <!-- Modal content -->
                                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                                                        <!-- Modal body -->

                                                        <div class="m-2 text-center items-center grid sm:grid-cols-6">
                                                            <a href="#" data-modal-toggle="popup-modal" class="mt-2 focus:outline-none text-white bg-yellow-700 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-3 py-2 mr-2 mb-2 ">
                                                                <i class="bi bi-cloud-arrow-down-fill mr-1"></i> Unduh
                                                            </a>
                                                            <a href="../model/kompetensi.php" data-modal-toggle="popup-modal" class="mt-2 focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-2 mr-2 mb-2 ">
                                                                <i class="bi bi-eye-fill mr-1"></i> View
                                                            </a>
                                                            <a href="./model/edit-modul.php" data-modal-toggle="popup-modal" class="mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 mr-2 mb-2 ">
                                                                <i class="bi bi-pencil-fill mr-1 "></i>Edit
                                                            </a>
                                                            <a href="#" data-modal-toggle="popup-modal" class=" mt-2 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 mr-2 mb-2 ">
                                                                <i class="bi bi-trash-fill mr-1"></i> Hapus
                                                            </a>
                                                            <button type="button" class="mt-2 focus:outline-none text-white bg-indigo-700 hover:bg-indigo-600 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-3 py-2 mr-2 mb-2 dark:focus:ring-yellow-900" data-modal-toggle="popup-modal">
                                                                <i class="bi bi-x-circle-fill mr-1"></i> Batal
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </li>

                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </li>


            </ul>
            </li>
            </ul>



        </td>
        <td class="px-6 py-4">admin</td>
    <?php endforeach; ?>

    </tr>