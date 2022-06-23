// readyData.replaceAll(/\W+/gu, ' ');



// const printTasks = function(jsonData) {
//     b = JSON.stringify(jsonData);

//     document.querySelector('.list').textContent = b;
//     // document.body.insertAdjacentHTML('afterbegin', a);
//     console.log(b);
// };

// clearList();

const display = document.querySelector('.list')
const keysWrapper = document.querySelector('.keys')


document.addEventListener('DOMContentLoaded', () => {
    // printKeys()
    const ajaxSend = async(formData) => {
        // clearList();
        display.classList.add('_active');

        const fetchResp = await fetch('/indexer', {
            method: 'POST',
            body: formData
        });
        if (!fetchResp.ok) {
            throw new Error(`Ошибка по адресу ${url}, статус ошибки ${fetchResp.status}`);
        }
        return await fetchResp.text();
    };

    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            clearList();
            ajaxSend(formData)
                .then((response) => {

                    // form.reset(); // очищаем поля формы
                    clearList();
                    display.classList.remove('_active');
                    printList(response);
                    // printKeys()

                })
                .catch((err) => console.error(err))
        });
    });

});


function clearList() {
    // const tables = document.querySelectorAll('table');
    //     tables.forEach(table => table.textContent = '');
    display.textContent = '';
    keysWrapper.textContent = '';
}



// audioObj = new Audio('notice.mp3');

async function printList(responce) {
    
    let readyJson = responce
    console.log(readyJson);

    if (readyJson == "") {
        // audioObj.play();
        alert('файл с ответами апи почему то пуст')
    } else {

        const row  = document.createElement("pre");
        row.innerText = readyJson;
        display.appendChild(row);


        // readyJson.forEach(object =>{
        //     Object.entries(object).forEach(element => {
        //         console.log(element[0]);
        //         const row  = document.createElement("pre");
        //         row.innerText = JSON.stringify(element);
        //         display.appendChild(row);
        //     });
        // })


        // audioObj.play();
    }
}
// async function printKeys() {
//     let getData = await fetch('php/keywatcher.php')
//     let readyJson = await getData.json()
//     // console.log(readyJson);

//     if (readyJson == "") {

//         alert('ошибка запроса ключей')
//     } else {

//         for (key in readyJson) {
//             console.log(readyJson[key]);
//             const keyBox  = document.createElement("div");
//             keyBox.classList.add('key__wrapper');
//             keyBox.innerText = 'ключ: '+key+' запросов: '+readyJson[key];
//             keysWrapper.appendChild(keyBox);
//           }

//     }
// }




// printData();

// sendButton = document.getElementById('send_button');

// sendButton.addEventListener(onclick, printTasks);


// array1.forEach(element => console.log(element));