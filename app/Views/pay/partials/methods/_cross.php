<div class="my-auto">
  <form id="cross-form" method="post" autocomplete="off">
    <input type="hidden" name="step" value="cross">
    <div class="fs-4 fs-md-2 fw-bold text-center text-wrap mb-5 mb-md-7">
      Senin için aşağıdaki işlemleri bulduk.<br>Bu işlemlerden birini seçmek ister misin?
    </div>
    <div class="d-inline-block text-gray-600 text-center text-wrap w-100 mb-7 mb-md-10">Buradaki işlemlerin senin için çok daha <span class="border-bottom border-1 border-success pt-2 pb-1">güvenli</span> olduğunu unutma</div>
    <div class="row mb-7 mb-md-10">
      <div class="col-md-12 p-0">
        <div class="d-flex flex-center">
          <input type="radio" class="d-none" name="payment" value="0" checked>

          <input type="radio" class="btn-check" name="payment" value="1" id="payment-1">
          <label class="btn border border-danger border-opacity-50 btn-active-light-danger text-dark fw-bold fs-6 fs-md-4 px-3 px-md-6 me-2 me-md-3" for="payment-1">
            ₺450
          </label>

          <input type="radio" class="btn-check" name="payment" value="2" id="payment-2">
          <label class="btn border border-danger border-opacity-50 btn-active-light-danger text-dark fw-bold fs-6 fs-md-4 px-3 px-md-6 me-2 me-md-3" for="payment-2">
            ₺575
          </label>

          <input type="radio" class="btn-check" name="payment" value="3" id="payment-3">
          <label class="btn border border-danger border-opacity-50 btn-active-light-danger text-dark fw-bold fs-6 fs-md-4 px-3 px-md-6 me-2 me-md-3" for="payment-3">
            ₺620
          </label>

          <input type="radio" class="btn-check" name="payment" value="4" id="payment-4">
          <label class="btn border border-danger border-opacity-50 btn-active-light-danger text-dark fw-bold fs-6 fs-md-4 px-3 px-md-6 me-2 me-md-3" for="payment-4">
            ₺715
          </label>

          <input type="radio" class="btn-check" name="payment" value="5" id="payment-5">
          <label class="btn border border-danger border-opacity-50 btn-active-light-danger text-dark fw-bold fs-6 fs-md-4 px-3 px-md-6" for="payment-5">
            ₺1045
          </label>
        </div>
      </div>
    </div>
    <a id="next" class="d-inline-block text-gray-800 text-hover-primary fw-bold text-center text-wrap w-100">&lt; Hayır, ₺<?= $amount ?> olarak devam etmek istiyorum &gt;</a>
  </form>
</div>