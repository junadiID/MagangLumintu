<tr class="bg-white border-b">
    <td class="px-8 py-4">
        <ul id="myUL">
            <li>
                <span class="caret text-black text-lg" id="materi-1"><?= $modulId['data']['modul_name']; ?></span>
                <ul class="nested">
                    <li>
                    <li>
                        <?php foreach ($modulId['data']['child'] as $key) : ?>
                            <span class="caret flex bg-gray-100 shadow-sm p-2 rounded items-center ml-3 mt-2">
                                <?php if (empty($modulId['data']['child'])) : ?>
                                    <div class="bg-gray-100 shadow-sm p-2 rounded items-center ml-3 mt-2">Tidak ada SubModul</div>
                                <?php else : ?>
                                    <div class="flex-1">
                                        <a href="" class=" text-black text-[15px]"><?= $key["modul_name"]; ?></a>
                                        <p class=" text-justify text-xs text-black p-1 "><?= $key["modul_desc"]; ?></p>

                                    </div>

                                    <!-- Modal toggle -->
                                <?php
                                endif;
                                ?>
                            </span>
                        <?php endforeach; ?>
                        <ul class="nested ml-5">
                            <li>
                                <?php if (empty($modulId['data']['child'][0])) : ?>
                                    <div class="caret flex bg-gray-100 shadow-sm p-2 rounded items-center ml-3 mt-2">
                                        <div class="flex-1">
                                            <a href="" class=" text-black text-[15px]"><?= $modulId['data']['child'][0]["child"][0]['modul_name']; ?></a>
                                        </div>
                                        <!-- Modal toggle -->
                                    </div>
                            </li>
                        </ul>
                    <?php
                     endif;
                    ?>
                    </li>
            </li>
        </ul>
        </li>
        </ul>
    </td>
</tr>