// Steps
const stepApiStatus = document.getElementById("api-status");
const stepMaintenance = document.getElementById("maintenance");
const stepUserCheck = document.getElementById("user-check");
const stepPendingTX = document.getElementById("pending-tx");
const stepOnboarding = document.getElementById("onboarding");
const stepCross = document.getElementById("cross-system");
const stepVirtualPOS = document.getElementById("virtual-pos");
const stepBankTransfer = document.getElementById("bank-transfer");

// Buttons
const prevBtn = document.getElementById("prev-btn");
const nextBtn = document.getElementById("next-btn");
const skipBtn = document.querySelectorAll("[id='skip-step']");
const exitBtn = document.getElementById("exit-btn");
const depositBtn = document.getElementById("deposit-btn");
const submitBtn = document.getElementById("submit-btn");

// Timer elements
const bankTimeLeft = document.getElementById("bank-time-left");
const restartBankTimer = document.getElementById("restart-bank-timer");
const bankAccWrapper = document.getElementById("bank-account-wrapper");
const bankTimeout = document.getElementById("bank-timeout");

const paparaTimeLeft = document.getElementById("papara-time-left");
const restartPaparaTimer = document.getElementById("restart-papara-timer");
const paparaAccWrapper = document.getElementById("papara-account-wrapper");
const paparaTimeout = document.getElementById("papara-timeout");

// Page Elements
const headerElement = document.getElementById("header");
const contentElement = document.getElementsByClassName("content")[0];
const descriptionElement = document.getElementById("description");
const depositAmount = document.getElementById("deposit-amount");
const onboardRadios = document.getElementsByName('blackCardInput');
const cardStatus = document.getElementById("kt_black_card_1");
const cardHolderName = document.getElementById("card-holder-name");
const cardNumber = document.getElementById("card-number");
const cardExpMonth = document.getElementById("card-expiry-month");
const cardExpYear = document.getElementById("card-expiry-year");
const cardCVV = document.getElementById("card-cvv");
const paparaAccountName = document.getElementById("pp-account-name");
const paparaAccountNumber = document.getElementById("pp-account-number");
const bankAccountNumber = document.getElementById("iban-value");

// Misc
const domain = window.location.host.split('.').slice(-1);

// QR Code Generator
const qrCode = new QRCode(document.getElementById("qr-box"), {
  width: 140,
  height: 140,
  colorDark: "#000000",
  colorLight: "#ffffff",
  correctLevel: QRCode.CorrectLevel.M
});

// BlockUI
const blockMessage = '<div class="blockui-message"><span class="spinner-border text-primary"></span> Lütfen Bekleyin...</div>';
var blockUI = new KTBlockUI(contentElement, {
  message: blockMessage,
});

// Timer
const timerLength = 299;
let bankTimerActive = false;
let paparaTimerActive = false;

// Papara Card Status
let userHasPPCard = null;

// System Status
const statusMaintenance = document.getElementById('statusMaintenance').getAttribute("value") === "true" ? true : false;
const statusTxPending = document.getElementById('statusTxPending').getAttribute("value") === "true" ? true : false;
const statusTransaction = document.getElementById('statusTransaction').getAttribute("value");
const statusCross = document.getElementById('statusCross').getAttribute("value") === "true" ? true : false;
let statusPOS = document.getElementById('statusPOS').getAttribute("value") === "true" ? true : false;
let statusBank = document.getElementById('statusBank').getAttribute("value") === "true" ? true : false;

// Steps info
let allSteps = [];
let stepCount = 0;
let currentStep = 0;
let availableSteps = [];

document.addEventListener("DOMContentLoaded", function () {
  validateStatus();
  setActiveSteps();

  for (var i = 0; i < onboardRadios.length; i++) {
    onboardRadios[i].addEventListener('change', function () {
      nextBtn.removeAttribute('disabled');
    });
  }
});

function validateStatus() {
  if (statusMaintenance) {
    stepMaintenance.classList.replace("d-none", "d-block");
    exitBtn.classList.replace("d-none", "d-inline-block");
    return;
  }

  if (statusTxPending) {
    stepPendingTX.classList.replace("d-none", "d-block");
    exitBtn.classList.replace("d-none", "d-inline-block");
    return;
  }

  if (statusTransaction === "reddedildi" || statusTransaction === "onaylandı") {
    descriptionElement.classList.add('d-none');
    stepApiStatus.classList.replace("d-none", "d-block");
    exitBtn.classList.replace("d-none", "d-inline-block");
    return;
  }

  const errorResponse = atob(obj.err) === '' ? null : JSON.parse(atob(obj.err));
  if (errorResponse != null) {
    switch (errorResponse.id) {
      case 12:
        stepPendingTX.classList.replace("d-none", "d-block");
        exitBtn.classList.replace("d-none", "d-inline-block");
        break;
      case 11: case 27: case 409: case 410: case 419:
        headerElement.innerHTML = "Hoşgeldin";
        descriptionElement.classList.add('d-none');
        stepApiStatus.classList.replace("d-none", "d-block");
        exitBtn.classList.replace("d-none", "d-inline-block");
        break;
      case 401: case 402: case 403: case 404: case 405: case 406: case 407:
        headerElement.innerHTML = "Hoşgeldin";
        descriptionElement.classList.add('d-none');
        stepApiStatus.classList.replace("d-none", "d-block");
        document.getElementById("api-status-title").innerHTML = "Geçersiz Parametre";
        document.getElementById("api-status-desc").innerHTML = "İşlem oluşturulurken hata oluştu<br><br>Yeni talep oluşturarak tekrar deneyebilirsin<br>Eğer sorun devam ediyorsa lütfen bunu bize bildir";
        exitBtn.classList.replace("d-none", "d-inline-block");
        break;
      case 415:
        stepUserCheck.classList.replace("d-none", "d-block");
        exitBtn.classList.replace("d-none", "d-inline-block");
        break;
      default:
        stepOnboarding.classList.replace("d-none", "d-block");
        nextBtn.classList.replace("d-none", "d-inline-block");
        break;
    }
  } else {
    stepOnboarding.classList.replace("d-none", "d-block");
    nextBtn.classList.replace("d-none", "d-inline-block");
  }
}

function setActiveSteps() {
  allSteps = document.getElementsByClassName("step");

  if (statusCross === false) stepCross.classList.remove("step");
  if (statusPOS === false) stepVirtualPOS.classList.remove("step");
  if (statusBank === false) stepBankTransfer.classList.remove("step");

  availableSteps = [];
  for (var i = 0; i < allSteps.length; i++)
    availableSteps[i] = allSteps[i].id;

  stepCount = availableSteps.length;
}

function generateQR(accountNumber, amount, clear = false) {
  try {
    if (clear) qrCode.clear();
    qrCode.makeCode("https://www.papara.com/personal/qr?accountNumber=" + accountNumber + "&currency=0&amount=" + amount);
  } catch { }
}

function startTimer(display, duration, activeStep) {
  if (activeStep === "bank") bankTimerActive = true;
  if (activeStep === "papara") paparaTimerActive = true;

  var timer = duration, minutes, seconds;
  var intervalTimer = setInterval(function () {
    minutes = parseInt(timer / 60, 10);
    seconds = parseInt(timer % 60, 10);

    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;

    display.textContent = minutes + ":" + seconds;

    if (--timer < 0) {
      if (activeStep === "bank") bankTimerActive = false;
      if (activeStep === "papara") paparaTimerActive = false;
      clearInterval(intervalTimer);

      if (display.id === "bank-time-left") {
        bankAccWrapper.classList.add("blur");
        bankTimeout.classList.replace("d-none", "d-block");
        if (availableSteps[currentStep] === "bank-transfer")
          submitBtn.setAttribute("disabled", "disabled");

        return;
      } else {
        paparaAccWrapper.classList.add("blur");
        paparaTimeout.classList.replace("d-none", "d-block");
        if (availableSteps[currentStep] === "papara")
          submitBtn.setAttribute("disabled", "disabled");

        return;
      }
    }
  }, 1000);
}

function goNextStep() {
  currentStep++;
  setActiveSteps();
  switch (availableSteps[currentStep]) {
    case "onboarding":
      break;
    case "cross-system":
      nextBtn.classList.replace('d-inline-block', 'd-none');
      prevBtn.classList.replace("d-none", "d-inline-block");
      submitBtn.classList.replace("d-inline-block", "d-none");
      depositBtn.classList.replace("d-none", "d-inline-block");
      break;
    case "virtual-pos":
      nextBtn.classList.replace('d-inline-block', 'd-none');
      prevBtn.classList.replace("d-none", "d-inline-block");
      submitBtn.classList.replace("d-inline-block", "d-none");
      depositBtn.classList.replace("d-none", "d-inline-block");
      break;
    case "bank-transfer":
      nextBtn.classList.replace('d-inline-block', 'd-none');
      prevBtn.classList.replace("d-none", "d-inline-block");
      submitBtn.classList.replace("d-none", "d-inline-block");
      depositBtn.classList.replace("d-inline-block", "d-none");
      break;
    case "papara":
      nextBtn.classList.replace('d-inline-block', 'd-none');
      prevBtn.classList.replace("d-none", "d-inline-block");
      submitBtn.classList.replace("d-none", "d-inline-block");
      depositBtn.classList.replace("d-inline-block", "d-none");
      break;
    case "success":
      break;
  }

  if (currentStep === 1)
    prevBtn.classList.replace('d-inline-block', 'd-none');

  allSteps[currentStep].classList.replace("d-none", "d-block");
  allSteps[currentStep - 1].classList.replace("d-block", "d-none");
  progress((100 / (stepCount - 1)) * currentStep);

  console.log(`Step changed to: ${availableSteps[currentStep]}(${currentStep})`);
}

let requestId = null;
async function getAccount(url, reload = false) {
  let data = new FormData();
  data.append("apiKey", atob(obj.acc));
  data.append("token", atob(obj.tkn));
  data.append("amount", currencyMask.unmaskedValue);
  data.append("transactionId", atob(obj.txn));
  data.append("userId", atob(obj.uid));
  data.append("userName", atob(obj.una));
  data.append("userNick", atob(obj.uni));
  data.append("callback", atob(obj.cbk));
  if (reload) data.append("action", "reload");

  try {
    const response = await fetch(url, { method: 'POST', body: data });
    const result = await response.json();

    requestId = result.status === true ? result.requestId : null;

    return result;
  } catch (e) {
    return false;
  }
}

async function approveTransaction(url) {
  try {
    url += "/" + atob(obj.acc) + "/" + requestId;
    const response = await fetch(url, { method: 'GET' });
    const result = await response.json();

    return result;
  } catch (e) {
    return false;
  }
}

nextBtn.addEventListener('click', async function (e) {
  e.preventDefault();
  if (currentStep >= stepCount - 1) return;

  userHasPPCard = cardStatus.checked ? true : false;
  if (!userHasPPCard) {
    statusPOS = false;
    statusBank = false;
    setActiveSteps();
  }

  if (currentStep + 1 <= stepCount) {
    if (currentStep + 1 === availableSteps.indexOf("cross-system")) {
      blockUI.block();

      const timer = ms => new Promise(res => setTimeout(res, ms));
      timer(1000).then(() => {
        blockUI.release();
        goNextStep();
      });
      return;
    }

    if (currentStep + 1 === availableSteps.indexOf("virtual-pos")) {
      goNextStep();
      return;
    }

    if (currentStep + 1 === availableSteps.indexOf("bank-transfer")) {
      if (!bankTimerActive) {
        blockUI.block();
        const response = await getAccount(`https://api.dev.paypara.${domain}/v1/new-deposit/bank/pre-request`);

        if (response === false) {
          toastr.error(`İşlem gerçekleştirilirken hata oluştu.<br>Lütfen daha sonra tekrar dene.`, `Hata (500)`);
          blockUI.release();
          return;
        }

        if (response.status) {
          bankAccountNumber.innerHTML = response.account.account_number;
          startTimer(bankTimeLeft, timerLength, "bank");
          bankAccWrapper.classList.remove("blur");
          bankTimeout.classList.replace("d-block", "d-none");
          submitBtn.removeAttribute("disabled", "disabled");
          blockUI.release();
          goNextStep();
          return;
        } else {
          toastr.error(`İşlem gerçekleştirilirken hata oluştu.<br>Lütfen daha sonra tekrar dene.`, `Hata (${response.id})`);
          console.log(`${response.id}: ${response.error}`)
          blockUI.release();
          return;
        }
      } else {
        goNextStep();
        return;
      }
    }

    if (currentStep + 1 === availableSteps.indexOf("papara")) {
      if (!paparaTimerActive) {
        blockUI.block();
        const response = await getAccount(`https://api.dev.paypara.${domain}/v1/new-deposit/papara/pre-request`);

        if (response === false) {
          toastr.error(`İşlem gerçekleştirilirken hata oluştu.<br>Lütfen daha sonra tekrar dene.`, `Hata (500)`);
          blockUI.release();
          return;
        }

        if (response.status) {
          paparaAccountName.innerHTML = response.account.account_name;
          paparaAccountNumber.innerHTML = response.account.account_number;
          generateQR(response.account.account_number, currencyMask.unmaskedValue);
          startTimer(paparaTimeLeft, timerLength, "papara");
          paparaAccWrapper.classList.remove("blur");
          paparaTimeout.classList.replace("d-block", "d-none");
          submitBtn.removeAttribute("disabled", "disabled");
          blockUI.release();
          goNextStep();
        } else {
          toastr.error(`İşlem gerçekleştirilirken hata oluştu.<br>Lütfen daha sonra tekrar dene.`, `Hata (${response.id})`);
          console.log(`${response.id}: ${response.error}`)
          blockUI.release();
          return;
        }
      } else {
        goNextStep();
        return;
      }
    }
  }
});

prevBtn.addEventListener("click", () => {
  if (currentStep - 1 === 0) return;

  if (currentStep > 0) {
    currentStep--;
    let previousStep = currentStep + 1;
    allSteps[currentStep].classList.replace("d-none", "d-block");
    allSteps[previousStep].classList.replace("d-block", "d-none");

    if (currentStep === availableSteps.indexOf("bank-transfer") || currentStep === availableSteps.indexOf("papara")) {
      depositBtn.classList.replace("d-inline-block", "d-none");
      submitBtn.classList.replace("d-none", "d-inline-block");
    } else {
      depositBtn.classList.replace("d-none", "d-inline-block");
      submitBtn.classList.replace("d-inline-block", "d-none");
    }
  }

  // prevent going back to onboarding
  if (currentStep === 1) {
    prevBtn.classList.replace("d-inline-block", "d-none");
  }

  progress((100 / (stepCount - 1)) * currentStep);
  console.log(`Step changed to: ${availableSteps[currentStep]}(${currentStep})`);
});

// Submit deposit
submitBtn.addEventListener("click", (e) => {
  e.preventDefault();

  Swal.fire({
    html: `<strong>Yatırım yaptığını onaylıyor musun?</strong><br><br>Bu işleme yatırım yapmadan onay vermemelisin.`,
    buttonsStyling: false,
    showDenyButton: true,
    confirmButtonText: "Evet yaptım",
    denyButtonText: "Hayır yapmadım",
    customClass: {
      confirmButton: "btn btn-sm btn-success",
      denyButton: "btn btn-sm btn-danger",
    },
  }).then(async (result) => {
    if (result.isConfirmed) {
      let activeStep = availableSteps[currentStep];
      if (activeStep === "bank-transfer") {
        blockUI.block();
        const response = await approveTransaction(`https://api.dev.paypara.${domain}/v1/approve`);

        if (response === false) {
          toastr.error(`İşlem gerçekleştirilirken hata oluştu.<br>Lütfen daha sonra tekrar dene.`, `Hata (500)`);
          blockUI.release();
          return;
        }

        if (response.status) {
          blockUI.release();
          document.getElementById(availableSteps[currentStep]).classList.replace("d-block", "d-none");
          document.getElementById("success").classList.replace("d-none", "d-block");
          submitBtn.classList.replace("d-inline-block", "d-none");
          prevBtn.classList.replace("d-inline-block", "d-none");
          exitBtn.classList.replace("d-none", "d-inline-block");
          progress(100);
        } else {
          toastr.error(`İşlem gerçekleştirilirken hata oluştu.<br>Lütfen daha sonra tekrar dene.`, `Hata (${response.id})`);
          console.log(`${response.id}: ${response.error}`)
          blockUI.release();
          return;
        }
      }

      if (activeStep === "papara") {
        blockUI.block();
        const response = await approveTransaction(`https://api.dev.paypara.${domain}/v1/approve/`);

        if (response === false) {
          toastr.error(`İşlem gerçekleştirilirken hata oluştu.<br>Lütfen daha sonra tekrar dene.`, `Hata (500)`);
          blockUI.release();
          return;
        }

        if (response.status) {
          blockUI.release();
          document.getElementById(availableSteps[currentStep]).classList.replace("d-block", "d-none");
          document.getElementById("success").classList.replace("d-none", "d-block");
          submitBtn.classList.replace("d-inline-block", "d-none");
          prevBtn.classList.replace("d-inline-block", "d-none");
          exitBtn.classList.replace("d-none", "d-inline-block");
          progress(100);
        } else {
          toastr.error(`İşlem gerçekleştirilirken hata oluştu.<br>Lütfen daha sonra tekrar dene.`, `Hata (${response.id})`);
          console.log(`${response.id}: ${response.error}`)
          blockUI.release();
          return;
        }
      }
    }
  });
});

// Begin custom deposit methods
depositBtn.addEventListener("click", () => {
  toastr.error(`Yöntem henüz aktif değil<br>(${availableSteps[currentStep]})`);
});

// Get new bank account
restartBankTimer.addEventListener("click", async () => {
  blockUI.block();
  const response = await getAccount('/api/deposit/bank/pre-request', true);

  if (response === false) {
    toastr.error(`İşlem gerçekleştirilirken hata oluştu.<br>Lütfen daha sonra tekrar dene.`, `Hata (500)`);
    blockUI.release();
    return;
  }

  if (response.status) {
    bankAccountNumber.innerHTML = response.account.account_number;

    bankAccWrapper.classList.remove("blur");
    bankTimeout.classList.replace("d-block", "d-none");
    submitBtn.removeAttribute("disabled", "disabled");
    startTimer(bankTimeLeft, timerLength, "bank");
    blockUI.release();
  } else {
    toastr.error(`İşlem gerçekleştirilirken hata oluştu.<br>Lütfen daha sonra tekrar dene.`, `Hata (${response.id})`);
    console.log(`${response.id}: ${response.error}`)
    blockUI.release();
    return;
  }
});

// Get new Papara account
restartPaparaTimer.addEventListener("click", async () => {
  blockUI.block();
  const response = await getAccount(`https://api.dev.paypara.${domain}/v1/new-deposit/papara/pre-request`, true);

  if (response === false) {
    toastr.error(`İşlem gerçekleştirilirken hata oluştu.<br>Lütfen daha sonra tekrar dene.`, `Hata (500)`);
    blockUI.release();
    return;
  }

  if (response.status) {
    paparaAccountName.innerHTML = response.account.account_name;
    paparaAccountNumber.innerHTML = response.account.account_number;
    generateQR(response.account.account_number, currencyMask.unmaskedValue, true);

    paparaAccWrapper.classList.remove("blur");
    paparaTimeout.classList.replace("d-block", "d-none");
    submitBtn.removeAttribute("disabled", "disabled");
    startTimer(paparaTimeLeft, timerLength, "papara");
    blockUI.release();
  } else {
    toastr.error(`İşlem gerçekleştirilirken hata oluştu.<br>Lütfen daha sonra tekrar dene.`, `Hata (${response.id})`);
    console.log(`${response.id}: ${response.error}`)
    blockUI.release();
    return;
  }
});

// Skip to next step
for (var i = 0; i < skipBtn.length; i++) {
  skipBtn[i].addEventListener("click", () => {
    nextBtn.click();
  });
}

// Redirect to Firms page
exitBtn.addEventListener("click", () => {
  location.href = document.referrer;
});

// Progress bar
const progress = (value) => {
  document.getElementsByClassName("progress-bar")[0].style.width = `${value}%`;
};

// Inputmask (unmasked value: currencyMask.unmaskedValue)
var currencyMask = IMask(
  depositAmount,
  {
    mask: '₺{num}',
    lazy: false,
    blocks: {
      num: {
        mask: Number,
        min: 250,
        max: 15000,
        padFractionalZeros: false,
        thousandsSeparator: '.'
      }
    }
  }
);

// Clipboard
const target = document.getElementById("iban-value");
const button = document.getElementById('clipboard');
clipboard = new ClipboardJS(button, {
  target: target,
  text: function () {
    return target.innerHTML;
  }
});

clipboard.on('success', function () {
  var checkIcon = button.querySelector('.bi.bi-check');
  var svgIcon = button.querySelector('.svg-icon');

  if (checkIcon) {
    return;
  }

  checkIcon = document.createElement('i');
  checkIcon.classList.add('bi');
  checkIcon.classList.add('bi-check');
  checkIcon.classList.add('fs-2x');
  button.appendChild(checkIcon);

  const classes = ['text-success', 'fw-boldest'];
  target.classList.add(...classes);
  button.classList.add('btn-light-success');
  svgIcon.classList.add('d-none');

  setTimeout(function () {
    svgIcon.classList.remove('d-none');
    button.removeChild(checkIcon);
    target.classList.remove(...classes);
    button.classList.remove('btn-light-success');
  }, 2000);
});

// Toastr
toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toastr-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "7500",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};

// Preloader
function preloader() {
  setTimeout(function () {
    document.getElementById("preloader").classList.add("d-none");
  }, 500);
}
