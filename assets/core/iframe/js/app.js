// Variables
const frame = document.getElementById("content-frame");
const blockFrame = document.querySelector(".block-frame");
const minDeposit = document?.getElementById("min-deposit");
const maxDeposit = document?.getElementById("max-deposit");
const depositAmount = document?.getElementById("deposit-amount");

// BlockUI
const blockMessage = '<div class="blockui-message"><span class="spinner-border text-primary"></span>Lütfen bekleyin...</div>';
var blocker = new KTBlockUI(blockFrame, { message: blockMessage });

// Domains
const apiDomains = {
  'pay.paypara.co': 'https://api.paypara.co',
  'pay.dev.paypara.co': 'https://api.dev.paypara.co',
  'pay.dev.paypara.dev': 'https://api.dev.paypara.dev',
  'pay.dev.paypara.localhost': 'https://api.dev.paypara.localhost',
};

const apiBaseUrl = `${apiDomains[window.location.hostname] || ''}`;

// Detect click events inside content frame
frame.addEventListener('click', (e) => {
  // Enabled next button if one of the radio input is selected
  if (document.querySelector('#onboarding-form')) {
    const select1 = document.querySelector('#papara-card-1');
    const select2 = document.querySelector('#papara-card-2');
    if(select1.checked || select2.checked) {
      document.querySelector('#next').removeAttribute('disabled');
    }
  }

  // Next button click
  if (e.target.matches('#next')) {
    const data = new FormData(document.querySelector('#content-frame form:first-of-type'));
    goToNextStep(data);
  }

  // Prev button click
  if (e.target.matches('#prevButton')) {
    console.log('prev button clicked');
  }
});

async function goToNextStep(data) {
  // Sanitize data before sending to server
  if (data.has('amount')) {
    data.set('amount', data.get('amount').substring(1));
  }

  try {
    console.log(data);
    blocker.block();

    const options = { method: 'POST', body: data };
    const token = window.location.pathname.replace('/papara/', '');
    const response = await fetch(`/frame/${token}`, options);
    if(response.ok) {
      const html = await response.text();
      frame.innerHTML = html;
      blocker.release();
    } else {
      throw new Error(response.status);
    }
  } catch (error) {
    blocker.release();
    toastr.error(`İşlemi gerçekleştiremedik.</br>Lütfen daha sonra tekrar dene.`, `Hata: ${error.message}`);
  }
}

if (depositAmount) {
  var currencyMask = IMask(
    depositAmount,
    {
      mask: '₺{num}',
      lazy: false,
      blocks: {
        num: {
          mask: Number,
          min: Number(minDeposit.value),
          max: Number(maxDeposit.value),
          padFractionalZeros: false,
          thousandsSeparator: '.'
        }
      }
    }
  );
}

// Progress bar
const progress = (value) => document.getElementsByClassName("progress-bar")[0].style.width = `${value}%`;

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