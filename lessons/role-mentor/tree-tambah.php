

<!-- tree view -->
<tr class="bg-white border-b">
    <td class="px-8 py-4">
        <ul id="myUL">
            <li>
                <span class="caret text-black text-lg" id="materi-1"><?= $modulId['data']['modul_name']; ?></span>
                <ul class="nested">
                    <li>
                        <?php if (empty($modulId['data']['child'])) : ?>
                            <div class="bg-gray-100 shadow-sm p-2 rounded items-center ml-3 mt-2">Tidak ada SubModul</div>
                        <?php else : ?>
                            <?php foreach ($modulId['data']['child'] as $key) : ?>
                                <span class="caret flex bg-gray-100 shadow-sm p-2 rounded items-center ml-3 mt-2">
                                    <div class="flex-1">
                                        <a class=" text-black text-[15px]"><?= $key["modul_name"]; ?></a>
                                        <p class=" text-justify text-xs text-black p-1 "><?= htmlspecialchars_decode($key["modul_desc"]); ?></p>
                                    </div>
                                    <!-- Modal toggle -->
                                </span>
                                <ul class="nested ml-3">
                                    <?php if (empty($key['child'])) : ?>
                                        <div class="bg-gray-100 shadow-sm p-2 rounded items-center ml-3 mt-2">Tidak ada SubModul</div>
                                    <?php else : ?>
                                        <?php foreach ($key['child'] as $key1) : ?>
                                            <li>
                                                <div class="caret flex bg-gray-100 shadow-sm p-2 rounded items-center ml-3 mt-2">
                                                    <div class="flex-1">
                                                        <span class=" text-black text-[15px]">
                                                            <div class="flex-1">
                                                                <a class=" text-black text-[15px]"><?= $key1["modul_name"]; ?></a>
                                                                <p class=" text-justify text-xs text-black p-1 "><?= $key1["modul_desc"]; ?></p>
                                                            </div>
                                                        </span>
                                                        <ul>
                                                            <?php if (empty($key1["child"])) : ?>
                                                                <button type="submit" class="items-center bg-gray-100 font-semibold shadow-sm p-1 rounded items-center ml-3 mt-2"><i class="bi text-black text-2xl bi-file-earmark-plus-fill mr-2"></i>Tambah Lagi SubModul </button>
                                                            <?php else : ?>
                                                                <?php foreach ($key1["child"] as $key2) : ?>
                                                                    <li>
                                                                        <span class="caret flex bg-gray-100 shadow-sm p-2 rounded items-center ml-3 mt-2">
                                                                            <div class="flex-1">
                                                                                <a class=" text-black text-[15px]"><?= $key2["modul_name"]; ?></a>
                                                                            </div>
                                                                        </span>
                                                                        <ul class="nested ml-3">
                                                                            <?php if (empty($key2["child"])) : ?>
                                                                                <button type="submit" class="items-center font-semibold bg-gray-100 shadow-sm p-1 rounded items-center ml-3 mt-2"><i class="bi text-black text-2xl bi-file-earmark-plus-fill mr-2"></i>Tambah Lagi SubModul </button>
                                                                            <?php else : ?>
                                                                                <?php foreach ($key2["child"] as $key4) : ?>
                                                                                    <li>
                                                                                        <span class="flex bg-gray-100 shadow-sm p-2 rounded items-center ml-3 mt-2 text-black text-[15px]"><?= $key4["modul_name"]; ?></span>
                                                                                    </li>
                                                                                <?php endforeach; ?>
                                                                            <?php endif; ?>
                                                                        </ul>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>

                                                        </ul>
                                                    </div>
                                                    <!-- Modal toggle -->
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </li>
                </ul>
            </li>
        </ul>
    </td>
</tr>

