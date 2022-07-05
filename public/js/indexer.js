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
// const myStorage = window.localStorage;

document.addEventListener('DOMContentLoaded', () => {
    printKeys()
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
    
    const forms = document.querySelectorAll('.indexer__form');
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
                    console.log(response);
                    localStorage.setItem('batchId', response);
                    printKeys();

                })
                .catch((err) => console.error(err));
        });
    });

});

const totalJobs = document.querySelector('.totalJobs');
const processedJobs = document.querySelector('.processedJobs');
const progress = document.querySelector('.progressbar');
const progressBar = document.getElementById('progress');


function getProgress(formData) {

    fetch('/progress',{
        method: 'POST',

          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
          },
        credentials: 'same-origin',
        body: formData
    })
    .then((response) => {
      return response.json();
    })
    .then((data) => {
    //   console.log(data);
    //   stats.innerText = JSON.stringify(data);
      totalJobs.innerText = data.totalJobs;
      processedJobs.innerText = data.processedJobs;
      progress.innerText = data.progress;
      progressBar.style.width = `${data.progress}%`;
    });

}

function clearList() {
    // const tables = document.querySelectorAll('table');
    //     tables.forEach(table => table.textContent = '');
    display.textContent = '';
    keysWrapper.textContent = '';
}



// audioObj = new Audio('notice.mp3');

async function printList(data) {
    

    console.log(data);




                const row  = document.createElement("pre");
                row.innerText = JSON.stringify(data.responce, undefined, 2);
                // row.innerText = responce;
                display.appendChild(row);


        // audioObj.play();
    }

async function printKeys() {
    
    let getData = await fetch('/keys/keylimits')
    let readyJson = await getData.json()


    if (readyJson == "") {

        alert('ошибка запроса ключей')
    } else {

        for (key in readyJson) {
            console.log(readyJson[key]);
            const keyBox  = document.createElement("div");
            keyBox.classList.add('key__wrapper');
            keyBox.innerText = 'ключ: '+key+' запросов: '+readyJson[key];
            keysWrapper.appendChild(keyBox);
          }



    }
}

class CustomTextarea {
    constructor(element) {
        this.element = element;
        this.textarea = this.element.querySelector('.textarea');
        this.numbers = this.element.querySelector('.linenumbers');
        
        this.numberOfNumbers = 0;

        this.addMoreNumbers();
        this.initEventListeners();
    }

    addMoreNumbers() {
        let html = '';

        for (let i = this.numberOfNumbers; i < this.numberOfNumbers + 100; i++) {
            html += `<div class='number'>${ i }</div>`;
        }

        this.numberOfNumbers += 100;
        this.numbers.innerHTML += html;
    }

    initEventListeners() {
        this.textarea.addEventListener('scroll', () => {
            this.numbers.style.transform = `translateY(-${ this.textarea.scrollTop }px)`;
            
            if (Math.abs(
                this.numbers.offsetHeight
                    - this.textarea.offsetHeight
                    - this.textarea.scrollTop) < 100) {
                this.addMoreNumbers();
            }
        });
    }
};

const textarea = new CustomTextarea(document.querySelector('.custom-textarea'));



// printData();

// sendButton = document.getElementById('send_button');

// sendButton.addEventListener(onclick, printTasks);


// array1.forEach(element => console.log(element));