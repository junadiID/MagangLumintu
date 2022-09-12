
let jml = 1;

        function tambah_item() {

            const load = document.querySelector('.load_content');
            const row = document.createElement("tr");
            const criteria = document.createElement("td");
            const bobot = document.createElement("td");
            const action = document.createElement("td");


            //memasukkan elemen kedalam tabel body
            load.appendChild(row);
            row.appendChild(criteria);
            row.appendChild(bobot);
            row.appendChild(action);


            //membuat text criteria on
            
            const text_criteria = document.createElement("input");
            text_criteria.className = "mt-1 mr-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500";
            text_criteria.setAttribute("type", 'text');
            text_criteria.setAttribute("name", "competenceName[]"); //
            text_criteria.setAttribute("id", "criteria[" + jml + "]");
            text_criteria.setAttribute("placeholder", "masukkan kompetensi");
            text_criteria.setAttribute("maxlength", "10");
            //membuat text bobot 
            const text_bobot = document.createElement("input");
            text_bobot.className = "mt-1 ml-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500";
            text_bobot.setAttribute("type", 'text');
            text_bobot.setAttribute("name", "competenceWeight[]"); //
            text_bobot.setAttribute("id", "bobot[" + jml + "]");
            text_bobot.setAttribute("placeholder", "masukkan bobot kompetensi");
            text_bobot.setAttribute("maxlength", "50");

            //membuat action delete
            const delete_element = document.createElement("span");
            delete_element.className = "ml-4 bi bi-trash2-fill text-3xl";
            delete_element.innerHTML = "<a href='#'></a>";


            action.appendChild(delete_element);
            //memasukkan text criteria kedalam criteria
            criteria.appendChild(text_criteria);
            bobot.appendChild(text_bobot);
            delete_element.onclick = function() {
                row.parentNode.removeChild(row);
            }

            jml++;

            
        }
