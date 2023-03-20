<!-- Virtual POS -->
<div id="virtual-pos" class="mw-400px py-2 py-md-0">
  <form id="pos-form" class="form needs-validation ps-0" method="post" name="form-pos" autocomplete="off">
    <div class="fs-2 fw-bold text-center text-wrap mb-5">Papara Black kart bilgilerini girerek yatırım yapabilirsin</div>
    <div class="row d-flex mb-4 mb-md-7">
      <div class="d-flex flex-column mb-1">
        <div class="form-floating mb-3 mb-md-4">
          <input type="text" id="card-holder-name" name="cardHolderName" class="form-control form-control-solid" placeholder="Kartının üzerinde yazan isim soyisim" />
          <label class="required fs-6 fw-semibold form-label" for="card_name">İsim Soyisim</label>
        </div>
        <div class="form-floating mb-2 mb-md-3">
          <input type="text" id="card-number" name="cardNumber" inputmode="numeric" class="form-control form-control-solid" placeholder="16 haneli kart numaran" />
          <label class="required fs-6 fw-semibold form-label" for="card_number">Kart Numarası</label>
        </div>
      </div>
      <div class="d-flex">
        <div class="col-8">
          <div class="">
            <label class="required fs-6 fw-semibold form-label mb-2">Geçerlilik Tarihi</label>
            <div class="d-flex">
              <select id="card-expiry-month" name="cardExpMonth" class="form-select form-select-solid mw-md-125px" data-control="select2" data-hide-search="true">
                <option disabled selected>Ay</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
              <select id="card-expiry-year" name="cardExpYear" class="form-select form-select-solid mw-md-125px" data-control="select2" data-hide-search="true">
                <option disabled selected>Yıl</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
                <option value="2031">2031</option>
                <option value="2032">2032</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="">
            <label class="required fs-6 fw-semibold form-label mb-2">CVV</label>
            <input type="text" id="card-cvv" name="cardCVV" class="form-control form-control-solid" minlength="3" maxlength="3" min="100" max="999" inputmode="numeric" placeholder="CVV" />
          </div>
        </div>
      </div>
    </div>
    <a id="skip-step" class="d-inline-block text-gray-800 text-hover-primary fw-bold text-center text-wrap w-100 my-3 my-md-0">&lt; Kartsız devam etmek istiyorum &gt;</a>
  </form>
</div>