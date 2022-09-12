<!-- get dari api https://lessons.lumintulogic.com/api/modul/read_moduls_tree_batch.php -->
<?php foreach ($json["data"] as $modul) : ?>
   <tr class="bg-white border-b" data-filesection="<?= $modul['id']; ?>">
      <td class="px-2 py-3">
         <ul id="myUL">
            <li id="bantuSub">
               <span class="caret flex text-black font-semibold text-md p-2 items-center mr-2 mb-1" id="materi-1"><?= $modul["modul_name"]; ?>
               </span>
               <!--   Modal edit -->
               <div id="authentication-modal<?= $modul["id"]; ?>">
                  <div class="relative">
                     <!-- Modal content -->
                  </div>
               </div>
               <ul id="introA" class="nested">
                  <li>
                     <!-- untuk menampilkan sub topik nya  -->
                     <?php if (empty($modul["child"])) : ?>
                        <div class="bg-gray-100 shadow-sm p-2 rounded items-center ml-3 mt-2">Tidak ada SubModul</div>
                     <?php else : ?>
                        <?php foreach ($modul["child"] as $sub1) : ?>
                  <li id="bantuSub1">
                     <span class="caret flex bg-gray-100 shadow-sm p-2 rounded items-center ml-3 mt-2 mb-2">
                        <div class="flex-1">
                           <a class="text-black text-md text-left font-semibold"><?= $sub1["modul_name"]; ?></a>
                           <p class=" text-justify text-xs text-black p-1 "><?= htmlspecialchars_decode($sub1["modul_desc"]); ?></p>
                        </div>
                        <div class="grid sm:grid-cols-3 lg:grid-cols-3 sm:grid-cols-1 md:grid-cols-1 gap-1">

                           <a href="https://assignment.lumintulogic.com/auth.php?token=<?php echo ($_COOKIE['X-LUMINTU-REFRESHTOKEN']); ?>&expiry=<?php echo $_SESSION["expiry"]; ?>&page=assignment&subject_id=<?= $sub1["id"]; ?>" id="bantu06" onclick="javascript:loadin();" class="flex text-white bg-gradient-to-t from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300  font-medium rounded-lg  sm:text-sm  text-xs  text-center  items-center justify-center py-1 px-1  text-center"><i class="bi bi-plus-square-fill mr-1"></i> Tambah Tugas
                           </a>
                           <a onclick="javascript:loadin();" href="edit.php?modulId=<?= $sub1["id"]; ?>" id="bantu07" class="flex text-white bg-gradient-to-t from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg  sm:text-sm  text-xs text-center  items-center justify-center py-1 px-2 text-center space-y-1">
                              <i class="bi bi-pencil-fill mr-1"></i> Edit
                           </a>
                           <a onclick="deleteSubModul(<?= $sub1['id']; ?>)" id="bantu08" class="flex text-white bg-gradient-to-t from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300  font-medium rounded-lg  sm:text-sm  text-xs  text-center cursor-pointer items-center justify-center py-1 px-1  text-center space-y-1">
                              <i class="bi bi-trash-fill mr-1"></i> Hapus
                           </a>
                        </div>
                     </span>
                     <ul class="nested ml-3">
                        <?php if (empty($sub1["child"])) : ?>
                           <a onclick="javascript:loadin();" href="tambah.php?modulId=<?= $sub1["id"]; ?>" class="bg-gray-100 shadow-sm font-semibold p-2 rounded items-center ml-2 mt-2 mb-2"><i class="bi hover:text-blue-500 text-black text-md bi-file-earmark-plus-fill mr-2"></i>Tambah SubModul</a>
                        <?php else : ?>
                           <?php foreach ($sub1["child"] as $sub2) : ?>
                              <li>
                                 <span class="caret flex bg-gray-100 shadow-sm p-2 rounded items-center ml-3 mt-2 mb-2">
                                    <div class="flex-1">
                                       <a class=" text-black text-md text-left font-semibold"><?= $sub2["modul_name"]; ?></a>
                                    </div>
                                    <p class=" text-justify text-xs text-black p-1 "><?= htmlspecialchars_decode($sub2["modul_desc"]); ?></p>
                                    <div class="grid sm:grid-cols-3 lg:grid-cols-3 sm:grid-cols-1 md:grid-cols-1 gap-1">
                                       <a href="https://assignment.lumintulogic.com/auth.php?token=<?php echo ($_COOKIE['X-LUMINTU-REFRESHTOKEN']); ?>&expiry=<?php echo $_SESSION["expiry"]; ?>&page=assignment&subject_id=<?= $sub2["id"]; ?>" id="bantu06" onclick="javascript:loadin();" class="flex text-white bg-gradient-to-t from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300  font-medium rounded-lg  sm:text-sm  text-xs  text-center  items-center justify-center py-1 px-1  text-center"><i class="bi bi-plus-square-fill mr-1"></i> Tambah Tugas
                                       </a>
                                       <a onclick="javascript:loadin();" href="edit.php?modulId=<?= $sub2["id"]; ?>" id="bantu06" class="flex text-white bg-gradient-to-t from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg  sm:text-sm  text-xs text-center  items-center justify-center py-1 px-1  text-center">
                                          <i class="bi bi-pencil-fill mr-1 text-center"></i> Edit
                                       </a>
                                       <a onclick="deleteSubModul(<?= $sub2['id']; ?>)" id="bantu08" class="flex text-white bg-gradient-to-t from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300  font-medium rounded-lg  sm:text-sm  text-xs  text-center cursor-pointer items-center justify-center py-1 px-1  text-center">
                                          <i class="bi bi-trash-fill mr-1"></i> Hapus
                                       </a>
                                    </div>
                                 </span>
                                 <ul class="nested ml-3">
                                    <?php if (empty($sub2["child"])) : ?>
                                       <a onclick="javascript:loadin();" href="tambah.php?modulId=<?= $sub2["id"]; ?>" class="bg-gray-100 shadow-sm font-semibold p-2 rounded items-center ml-2 mt-1 mb-2"><i class="bi hover:text-blue-500 text-black text-xl bi-file-earmark-plus-fill mr-2"></i>Tambah SubModul</a>
                                    <?php else : ?>
                                       <?php foreach ($sub2["child"] as $sub3) : ?>
                                          <li>
                                             <span class="caret flex bg-gray-100 shadow-sm p-2 rounded items-center ml-3 mt-2 mb-2">
                                                <div class="flex-1">
                                                   <a class=" text-black text-md font-semibold"><?= $sub3["modul_name"]; ?></a>
                                                </div>
                                                <p class=" text-justify text-xs text-black p-1 "><?= htmlspecialchars_decode($sub3["modul_desc"]); ?></p>
                                                <div class="grid sm:grid-cols-3 lg:grid-cols-3 sm:grid-cols-1 md:grid-cols-1 gap-1">
                                                   <a href="https://assignment.lumintulogic.com/auth.php?token=<?php echo ($_COOKIE['X-LUMINTU-REFRESHTOKEN']); ?>&expiry=<?php echo $_SESSION["expiry"]; ?>&page=assignment&subject_id=<?= $sub3["id"]; ?>" id="bantu06" onclick="javascript:loadin();" class="flex text-white bg-gradient-to-t from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300  font-medium rounded-lg  sm:text-sm  text-xs  text-center  items-center justify-center py-1 px-1  text-center"><i class="bi bi-plus-square-fill mr-1"></i> Tambah Tugas
                                                   </a>
                                                   <a onclick="javascript:loadin();" href="edit.php?modulId=<?= $sub3["id"]; ?>" id="bantu06" class="flex text-white bg-gradient-to-t from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg  sm:text-sm  text-xs text-center  items-center justify-center py-1 px-1  text-center">
                                                      <i class="bi bi-pencil-fill mr-1 text-center"></i> Edit
                                                   </a>
                                                   <a onclick="deleteSubModul(<?= $sub3['id']; ?>)" id="bantu08" class="flex text-white bg-gradient-to-t from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300  font-medium rounded-lg  sm:text-sm  text-xs  text-center cursor-pointer items-center justify-center py-1 px-1  text-center">
                                                      <i class="bi bi-trash-fill mr-1"></i> Hapus
                                                   </a>
                                                </div>
                                             </span>
                                             <ul class="nested ml-3">
                                                <?php if (empty($sub3["child"])) : ?>
                                                   <a onclick="javascript:loadin();" href="tambah.php?modulId=<?= $sub3["id"]; ?>" class="bg-gray-100 shadow-sm font-semibold p-2 rounded items-center ml-2 mt-1 mb-2 "><i class="bi hover:text-blue-500 text-black text-md bi-file-earmark-plus-fill mr- "></i>Tambah SubModul</a>
                                                <?php else : ?>
                                                   <?php foreach ($sub3["child"] as $sub4) : ?>
                                                      <li>
                                                         <span class="caret flex bg-gray-100 shadow-sm p-2 rounded items-center ml-3 mt-2 mb-2">
                                                            <div class="flex-1">
                                                               <a class=" text-black  text-md font-semibold"><?= $sub4["modul_name"]; ?></a>
                                                               <p class=" text-justify text-xs text-black p-1 "><?= htmlspecialchars_decode($sub4["modul_desc"]); ?></p>
                                                            </div>
                                                            <div class="grid sm:grid-cols-3 lg:grid-cols-3 sm:grid-cols-1 md:grid-cols-1 gap-1">
                                                               <a href="https://assignment.lumintulogic.com/auth.php?token=<?php echo ($_COOKIE['X-LUMINTU-REFRESHTOKEN']); ?>&expiry=<?php echo $_SESSION["expiry"]; ?>&page=assignment&subject_id=<?= $sub4["id"]; ?>" id="bantu06" onclick="javascript:loadin();" class="flex text-white bg-gradient-to-t from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300  font-medium rounded-lg  sm:text-sm  text-xs  text-center  items-center justify-center py-1 px-1  text-center"><i class="bi bi-plus-square-fill mr-1"></i> Tambah Tugas
                                                               </a>
                                                               <a onclick="javascript:loadin();" href="edit.php?modulId=<?= $sub4["id"]; ?>" id="bantu06" class="flex text-white bg-gradient-to-t from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg  sm:text-sm  text-xs text-center  items-center justify-center py-1 px-1  text-center">
                                                                  <i class="bi bi-pencil-fill mr-1 text-center"></i> Edit
                                                               </a>
                                                               <a onclick="deleteSubModul(<?= $sub4['id']; ?>)" id="bantu08" class="flex text-white bg-gradient-to-t from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300  font-medium rounded-lg  sm:text-sm  text-xs  text-center cursor-pointer items-center justify-center py-1 px-1  text-center">
                                                                  <i class="bi bi-trash-fill mr-1"></i> Hapus
                                                               </a>
                                                            </div>
                                                         </span>
                                                         <ul class="nested ml-3">
                                                            <?php if (empty($sub4["child"])) : ?>
                                                               <a onclick="javascript:loadin();" href="tambah.php?modulId=<?= $sub4["id"]; ?>" class="bg-gray-100 shadow-sm font-semibold p-2 rounded items-center ml-2 mt-1 mb-2 "><i class="bi hover:text-blue-500 text-black text-md bi-file-earmark-plus-fill mr- "></i>Tambah SubModul</a>
                                                            <?php else : ?>
                                                               <?php foreach ($sub4["child"] as $sub5) : ?>
                                                                  <li>
                                                                     <span class="caret flex bg-gray-100 shadow-sm p-2 rounded items-center ml-3 mt-2 mb-2">
                                                                        <div class="flex-1">
                                                                           <a class=" text-black text-md font-semibold"><?= $sub5["modul_name"]; ?></a>
                                                                           <p class=" text-justify text-xs text-black p-1 "><?= htmlspecialchars_decode($sub5["modul_desc"]); ?></p>
                                                                        </div>
                                                                        <div class="grid sm:grid-cols-3 lg:grid-cols-3 sm:grid-cols-1 md:grid-cols-1 gap-1">
                                                                           <a href="https://assignment.lumintulogic.com/auth.php?token=<?php echo ($_COOKIE['X-LUMINTU-REFRESHTOKEN']); ?>&expiry=<?php echo $_SESSION["expiry"]; ?>&page=assignment&subject_id=<?= $sub5["id"]; ?>" id="bantu06" onclick="javascript:loadin();" class="flex text-white bg-gradient-to-t from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300  font-medium rounded-lg  sm:text-sm  text-xs  text-center  items-center justify-center py-1 px-1  text-center"><i class="bi bi-plus-square-fill mr-1"></i> Tambah Tugas
                                                                           </a>
                                                                           <a onclick="javascript:loadin();" href="edit.php?modulId=<?= $sub5["id"]; ?>" id="bantu06" class="flex text-white bg-gradient-to-t from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg  sm:text-sm  text-xs text-center  items-center justify-center py-1 px-1  text-center">
                                                                              <i class="bi bi-pencil-fill mr-1 text-center"></i> Edit
                                                                           </a>
                                                                           <a onclick="deleteSubModul(<?= $sub5['id']; ?>)" id="bantu08" class="flex text-white bg-gradient-to-t from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300  font-medium rounded-lg  sm:text-sm  text-xs  text-center cursor-pointer items-center justify-center py-1 px-1  text-center">
                                                                              <i class="bi bi-trash-fill mr-1"></i> Hapus
                                                                           </a>
                                                                        </div>
                                                                     </span>
                                                                  </li>
                                                               <?php endforeach; ?>
                                                            <?php endif; ?>
                                                         </ul>
                                                      </li>
                                                   <?php endforeach; ?>
                                                <?php endif; ?>
                                             </ul>
                                          </li>
                                       <?php endforeach; ?>
                                    <?php endif; ?>
                                 </ul>
                              </li>
                           <?php endforeach; ?>
                        <?php endif; ?>
                     </ul>
                  </li>
               <?php endforeach; ?>
            <?php endif; ?>
            </li>
         </ul>
         </li>
         </ul>
      </td>
      <td class="px-2.5 py-2">
         <!-- tombol di tree view  -->
         <div class="gap-1 grid sm:grid-cols-4 lg:grid-cols-4 sm:grid-cols-3 md:grid-cols-2 sm:grid-cols-2">
            <a id="bantuView" onclick="javascript:loadin();" href="viewmodul.php?modulId=<?= $modul['id'];  ?>&batchId=<?= $modul['batch_id']; ?>" data-modal-toggle="authentication-modal<?= $modul['id']; ?>" class="flex text-white bg-gradient-to-t from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300  font-medium rounded-lg  sm:text-sm  text-xs items-center justify-center py-1 px-1  text-center ">
               <i class="bi bi-eye-fill mr-1"></i> View
            </a>
            <!-- tombol modal edit  -->
            <button id="myButton" data-modal-toggle="edit-modal" class="flex text-white bg-gradient-to-t from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg  sm:text-sm  text-xs text-center  items-center justify-center py-1 px-1  text-center" onclick="openModal(<?= $modul['id']; ?>)">
               <i class="bi bi-pencil-fill mr-1 text-center"></i> Edit
            </button>
            <a id="bantu04" onclick="javascript:loadin();" class="flex text-white bg-gradient-to-t from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300  font-medium rounded-lg  sm:text-sm  text-xs  text-center  items-center justify-center py-1 px-1  text-center" href="tambah.php?modulId=<?= $modul["id"]; ?>"><i class="bi bi-plus-square-fill mr-1"></i> Tambah
            </a>
            <a id="bantu05" onclick="deleteModul(<?= $modul['id']; ?>)" class="flex text-white bg-gradient-to-t from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300  font-medium rounded-lg  sm:text-sm  text-xs  text-center cursor-pointer items-center justify-center py-1 px-1  text-center">
               <i class="bi bi-trash-fill mr-1"></i> Hapus
            </a>
         </div>
         <!-- modal edit di tree view  -->
         <?php include 'form-modal.php'; ?>
      </td>
   </tr>
<?php endforeach; ?>