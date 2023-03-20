<!-- IBAN Transfer -->
<div class="my-auto">
  <div class="fs-2 fw-bold text-center text-wrap mb-7 mb-md-16">Aşağıdaki IBAN'a aktarım yapabilirsin:</div>
  <div class="row text-center mb-5 mb-md-7">
    <div class="fs-5 fw-bold">Kalan Süre: <span id="bank-time-left">05:00</span></div>
  </div>
  <div class="mb-3">
    <div class="position-relative">
      <div id="bank-timeout" class="d-flex flex-center position-absolute z-index-1 w-100 d-none">
        <span class="fs-2 fw-bold text-center">
          Süren doldu!<br>
          Yeni bir hesap almak için <a id="restart-bank-timer" class="cursor-pointer">buraya</a> tıkla
        </span>
      </div>
      <div id="bank-account-wrapper" class="d-flex">
        <div class="d-flex flex-center flex-wrap w-100 mb-12 mt-md-5 mb-md-15">
          <span id="iban-value" class="fs-1 fs-md-2x fw-bold text-center text-dark" style="letter-spacing: -0.07rem;">{IBAN Number}</span>
          <button id="clipboard" class="btn btn-icon btn-sm btn-active-light w-35px h-35px ms-0 ms-md-2 p-0" data-clipboard-target="#iban-value" alt="Kopyala">
            <span class="svg-icon svg-icon-2">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.5" d="M18 2H9C7.34315 2 6 3.34315 6 5H8C8 4.44772 8.44772 4 9 4H18C18.5523 4 19 4.44772 19 5V16C19 16.5523 18.5523 17 18 17V19C19.6569 19 21 17.6569 21 16V5C21 3.34315 19.6569 2 18 2Z" fill="currentColor"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7857 7.125H6.21429C5.62255 7.125 5.14286 7.6007 5.14286 8.1875V18.8125C5.14286 19.3993 5.62255 19.875 6.21429 19.875H14.7857C15.3774 19.875 15.8571 19.3993 15.8571 18.8125V8.1875C15.8571 7.6007 15.3774 7.125 14.7857 7.125ZM6.21429 5C4.43908 5 3 6.42709 3 8.1875V18.8125C3 20.5729 4.43909 22 6.21429 22H14.7857C16.5609 22 18 20.5729 18 18.8125V8.1875C18 6.42709 16.5609 5 14.7857 5H6.21429Z" fill="currentColor"></path>
              </svg>
            </span>
          </button>
        </div>
      </div>
      <div class="row">
        <a id="skip-step" class="d-inline-block text-gray-800 text-hover-primary fw-bold text-center text-wrap w-100">&lt; Papara hesabı almak istiyorum &gt;</a>
      </div>
    </div>
  </div>
</div>