    <!-- Main modal -->
    <!-- <div id="modal1">

    </div> -->


    <div id="edit-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[100]  w-full md:inset-0 h-modal md:h-full">

        <div class="relative p-4 w-full max-w-md h-full md:h-auto  max-h-md">

            <!-- Modal content -->
            <div id="modul-content" class="relative bg-white rounded-lg shadow ">
                <!-- loading  -->
                <div id="modal-loader" class="hidden">
                    <div class="p-1 space-y-2  items-center justify-center" id="file-content">
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
                </div>
                <!-- end loading  -->

                <div id="modal-content">
                    <button onclick="document.getElementById('').value = ''" type="button" id="clos" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="edit-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <div class="py-6 px-6 lg:px-8">
                        <h1 class="mb-4 text-2xl justify-center text-center items-start font-medium text-gray-900 ">Edit Modul</h1>
                        <form class="space-y-2 form-prevent1" action="" onsubmit="updateModul(<?= $modul['id']; ?>)" method="POST">
                            <input type="text" hidden id="modul-ID" value="">
                            <div>
                                <label for="modul_name" class="block mb-2 text-sm font-semibold text-gray-900 ">Masukkan Modul Utama</label>
                                <input type="modul_name" name="modul_name1" id="main_modul1" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Masukan nama modul disini" required>
                            </div>

                            <div>
                                <label for="modul_desc" class="block mb-2 text-sm font-semibold text-gray-900 ">Masukan Deskripsi</label>
                                <textarea name="modul_description1" id="modul_desc1" rows="4" class=" block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 " placeholder="masukan deskripsi disini..."></textarea>

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
                                    </div>
                                </div>
                                <input id="bobot_id2" name="bobot_id2" autocomplete="off" type="number" min="1" max="100" step="any" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder=" Masukan bobot disini" required>
                            </div>

                            <div>
                                <input type="hidden" name="parent_id1" id="parentid1" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Masukan nama modul disini">
                            </div>

                            <div class="batch-id mt-2">
                                <label for="" class="font-semibold text-md ">Masukkan Batch ID</label>
                                <select name="batch_id1" id="batch-id1" class="overflow-y bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 blohttp://localhost/lessons/role-mentor/list-modul.phpck w-full p-2.5" required>
                                    <?php foreach ($take1["batch"] as $bid) : ?>
                                        <option selected class="overflow-y" value="<?= $bid["batch_id"]; ?>"> <?= $bid["batch_name"]; ?> | <?= $bid["batch_start_date"]; ?> | <?= $bid["batch_end_date"]; ?> </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <div class="grid sm:grid-cols-2 gap-3">
                                <button type="submit" id="btn-simpan2" onclick="loading()" name="save" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 "> Simpan </button>

                                <button id="btn-loader2" disabled type="button" class="hidden item-center justify-center text-center text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 inline-flex items-center mb-2">
                                    <svg role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB" />
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor" />
                                    </svg>
                                    Loading...
                                </button>

                                <button type="button" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300  font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2" data-modal-toggle="edit-modal">
                                    Kembali
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>