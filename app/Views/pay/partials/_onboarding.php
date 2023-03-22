<!-- Onboarding -->
<div div class="d-flex flex-center h-100">
  <option id="min-deposit" value="<?= $minDeposit ?>"></option>
  <option id="max-deposit" value="<?= $maxDeposit ?>"></option>

  <form id="onboarding-form" method="post" autocomplete="off">
    <input type="hidden" name="step" value="onboarding">
    <div class="d-flex flex-column flex-center">
      <div class="fs-4 fs-md-2 fw-bold text-center mb-3">Ne kadar yatırım yapmak istiyorsun?</div>
      <div class="w-100 mb-3">
        <div class="input-group input-deposit d-flex flex-center">
          <input type="text" id="deposit-amount" name="amount" class="form-control fs-3x text-center border-0 bg-none p-0 w-100" inputmode="numeric" value="<?= $amount ?>">
        </div>
      </div>
    </div>
    <h4 class="text-center text-wrap mb-3 fs-4 fs-md-2">Papara Black kartın var mı?</h4>
    <div class="d-flex flex-column flex-center">
      <div class="d-flex">
        <input type="radio" id="papara-card-1" name="hasCard" class="btn-check" value="1">
        <label class="btn btn-active-light-danger border border-white me-3" for="papara-card-1" id="card-label-1">
          <span class="fw-semibold text-start">
            <img src="<?= base_url() ?><?=assetsPath() ?>/iframe/images/emojis/smiling-face-with-sunglasses.png">
            <span class="text-dark fw-bold fs-6 fs-md-5">Evet var</span>
          </span>
        </label>
        <input type="radio" id="papara-card-2" name="hasCard" class="btn-check" value="0">
        <label class="btn btn-active-light-danger border border-white" for="papara-card-2" id="card-label-2">
          <span class="fw-semibold text-start">
            <img src="<?= base_url() ?><?=assetsPath() ?>/iframe/images/emojis/folded-hands.png">
            <span class="text-dark fw-bold fs-6 fs-md-5">Hayır yok</span>
          </span>
        </label>
      </div>
    </div>
  </form>
</div>

<div class="d-flex flex-row justify-content-center align-items-start w-100 h-15 z-index-1">
  <button id="next" type="button" class="btn btn-danger fs-6 min-w-100px min-w-md-125px" disabled>İlerle</button>
</div>