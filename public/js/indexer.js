const display = document.querySelector(".list");
const keysWrapper = document.querySelector(".keys");

document.addEventListener("DOMContentLoaded", () => {
  printKeys();
  const ajaxSend = async (formData) => {

    display.classList.add("_active");

    const fetchResp = await fetch("/indexer", {
      method: "POST",
      body: formData,
    });
    if (!fetchResp.ok) {
      throw new Error(
        `Ошибка по адресу ${url}, статус ошибки ${fetchResp.status}`
      );
    }
    return await fetchResp.text();
  };

  const forms = document.querySelectorAll(".indexer__form");
  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(this);
      clearList();
      ajaxSend(formData)
        .then((responce) => {
          clearList();
          display.classList.remove("_active");
          let responceObj = JSON.parse(responce);
          let batchId = responceObj.batchId;
          console.log(batchId);
          localStorage.setItem('batchId', batchId);
          if (responceObj.hasOwnProperty('message')){
            alert(responceObj.message);
          }
          printKeys();
        })
        .catch((err) => console.error(err));
    });
  });
});

const progressBar = document.getElementById("progress");

const toggleProgress= function() {

let progressData = progressBar.style.width;

let progressWrapper = document.querySelector('.progress__stats');

if ( (progressData == "0%") || (progressData == "100%")) {
progressWrapper.classList.add('prg-hide');
printKeys();
} else {
    progressWrapper.classList.remove('prg-hide');
}
};
const progressObserver = new MutationObserver(toggleProgress);

progressObserver.observe(progressBar, {attributes: true});


function getProgress(formData) {
  const totalJobs = document.querySelector(".totalJobs");
  const processedJobs = document.querySelector(".processedJobs");
  const progress = document.querySelector(".progressbar");
  
  fetch("/progress", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
      "X-Requested-With": "XMLHttpRequest",
      "X-CSRF-TOKEN": document.head.querySelector("meta[name=csrf-token]")
        .content,
    },
    credentials: "same-origin",
    body: formData,
  })
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      totalJobs.innerText = data.totalJobs;
      processedJobs.innerText = data.processedJobs;
      progress.innerText = data.progress;
      progressBar.style.width = `${data.progress}%`;
    });
}

function clearList() {
  display.textContent = "";
  keysWrapper.textContent = "";
}

async function printList(data) {
  let resultItems = document.querySelectorAll('pre').length;
  const row = document.createElement("pre");
  row.innerText = (resultItems+1) + ')' + JSON.stringify(data.responce, undefined, 2).replace(/{|}|"/g, "");
  display.appendChild(row);
}

async function printKeys() {
    keysWrapper.textContent = "";
  let getData = await fetch("/keys/keylimits");
  let readyJson = await getData.json();
  if (readyJson == "") {
    alert("ошибка запроса ключей");
  } else {
    for (key in readyJson) {
      const keyBox = document.createElement("p");
      keyBox.classList.add('badge', 'badge-soft-dark', 'px-l');
      const keyIcon = document.createElement("i");
      keyIcon.classList.add('mdi', 'mdi-account-key-outline');
      keyBox.appendChild(keyIcon);
      const keyName = document.createElement("span");
      keyName.innerText = ' '+key+' ';
      keyBox.appendChild(keyName);
      const keyBadge = document.createElement("span");
      keyBadge.innerText = readyJson[key];
      if (readyJson[key] <= 50) {
        keyBadge.classList.add('badge', 'bg-danger');
      } else if ((readyJson[key] > 50) && (readyJson[key] <= 150)) {
        keyBadge.classList.add('badge', 'bg-warning');
      } else {
        keyBadge.classList.add('badge', 'bg-primary');
      } 
      keyBox.appendChild(keyBadge);
      keysWrapper.appendChild(keyBox);

    }
  }
}
class CustomTextarea {
  constructor(element) {
    this.element = element;
    this.textarea = this.element.querySelector(".textarea");
    this.numbers = this.element.querySelector(".linenumbers");

    this.numberOfNumbers = 0;

    this.addMoreNumbers();
    this.initEventListeners();
  }

  addMoreNumbers() {
    let html = "";

    for (let i = this.numberOfNumbers; i < this.numberOfNumbers + 100; i++) {
      html += `<div class='number'>${i}</div>`;
    }

    this.numberOfNumbers += 100;
    this.numbers.innerHTML += html;
  }

  initEventListeners() {
    this.textarea.addEventListener("scroll", () => {
      this.numbers.style.transform = `translateY(-${this.textarea.scrollTop}px)`;

      if (
        Math.abs(
          this.numbers.offsetHeight -
            this.textarea.offsetHeight -
            this.textarea.scrollTop
        ) < 100
      ) {
        this.addMoreNumbers();
      }
    });
  }
}

const textarea = new CustomTextarea(document.querySelector(".custom-textarea"));

let autoKeysCheckbox = document.getElementById('flexSwitchCheckChecked');

let keySelector = document.getElementById('key-selector');

autoKeysCheckbox.addEventListener('change', function() {
   
   if (autoKeysCheckbox.checked) {
    console.log(keySelector);
    keySelector.setAttribute('style', 'display:none !important');
   } else {
    keySelector.setAttribute('style', 'display:inline !important');
   }
    
});

