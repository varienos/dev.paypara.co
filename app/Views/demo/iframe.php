<!DOCTYPE html>
<html data-theme="light" lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paypara'ya Hoşgeldin!</title>
    <link rel="shortcut icon" href="<?=baseUrl() ?>/<?=assetsPath() ?>/iframe/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=baseUrl() ?>/<?=assetsPath() ?>/plugins/global/plugins.bundle.css?v=<?=getVersion() ?>">
    <link rel="stylesheet" href="<?=baseUrl() ?>/<?=assetsPath() ?>/css/style.bundle.css?v=<?=getVersion() ?>">
    <link rel="stylesheet" href="<?=baseUrl() ?>/<?=assetsPath() ?>/iframe/css/app.css?v=<?=md5(microtime()) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script data-token="8BA6K8H77930" async src="https://cdn.splitbee.io/sb.js"></script>
  </head>

  <body onload="preloader()">
    <config id="statusTxPending" value="<?= $pending ?>"></config>
    <config id="statusTransaction" value="<?= $transactionStatus ?>"></config>
    <config id="statusMaintenance" value="<?= $maintenance ?>"></config>
    <config id="statusCross" value="<?= $crossSystem ?>"></config>
    <config id="statusPOS" value="<?= $virtualPOS ?>"></config>
    <config id="statusBank" value="<?= $bankTransfer ?>"></config>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-11">
          <div class="d-flex pb-20 pb-md-0 min-vh-100 align-items-center">
            <div class="container-wrap d-flex align-items-stretch rounded-3 overflow-hidden w-100 shadow-lg bg-white">
              <div class="col-xl-3 d-none d-xl-flex">
                <video class="hero-media" autoplay muted loop>
                  <source src="<?= base_url() ?>/<?=assetsPath() ?>/iframe/images/backgrounds/hero-video.mp4" type="video/mp4">
                </video>
              </div>
              <div class="col-12 col-xl-9">
                <div class="progress h-5px rounded-0">
                  <div aria-valuemax="100" aria-valuemin="0" class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 0%"></div>
                </div>
                <div class="content p-8 px-lg-14 d-flex flex-column">
                  <div class="d-flex flex-column-reverse flex-md-row justify-content-md-between align-items-center align-items-md-start">
                    <div class="mt-12 mt-md-0 text-center text-md-start">
                      <div class="d-flex justify-content-center justify-content-md-start">
                        <img src="<?= base_url() ?>/<?=assetsPath() ?>/iframe/images/emojis/waving-hand.png" width="24px" height="24px">
                        <h3 id="header" class="fs-1 fw-bolder ms-2 mb-4 mb-md-1">Hoşgeldin <?= strtok($userName, " ") ?>,</h3>
                      </div>
                      <p id="description" class="fs-6 text-gray-700 fw-normal text-wrap"><span class="fw-bold text-dark"><?= $clientName ?></span> hesabına bakiye yüklemek için adımları takip et.</p>
                    </div>
                    <img src="<?= base_url() ?>/<?=assetsPath() ?>/iframe/images/logo.png" class="m-0 logo" width="146px" height="47px" alt="Paypara Logo">
                  </div>
                  <div class="steps-wrapper d-flex flex-row flex-center h-100">
                    <!-- API Status -->
                    <div id="api-status" class="d-none">
                      <div class="d-flex flex-column text-center">
                        <div class="mb-8">
                          <img class="h-100px h-md-125px" src="<?= base_url() ?>/<?=assetsPath() ?>/iframe/images/svg/warning.svg">
                        </div>
                        <p id="api-status-title" class="fs-2x fw-bolder text-gradient">Geçersiz İşlem</p>
                        <p id="api-status-desc" class="fs-3 fw-semibold mw-500px">Denediğin işlemin süresi doldu veya artık geçersiz<br>Lütfen geri dönerek yeni talep oluştur</p>
                      </div>
                    </div>
                    <!-- Maintenance -->
                    <div id="maintenance" class="d-none">
                      <div class="d-flex flex-column text-center">
                        <div class="mb-6 mb-md-3">
                          <img class="h-100px h-md-150px" src="<?= base_url() ?>/<?=assetsPath() ?>/iframe/images/svg/maintenance-<?php echo rand(1, 4); ?>.svg">
                        </div>
                        <p class="fw-semibold fs-4 mw-400px mt-0 mt-md-8">
                          Sorunsuz hizmet vermeye kaldığımız yerden devam edebilmek için şu an güncelleme altındayız.<br><br>
                          <span class="underline position-relative">Lütfen daha sonra tekrar dene.</span>
                        </p>
                      </div>
                    </div>
                    <!-- User Check -->
                    <div id="user-check" class="d-none">
                      <div class="d-flex flex-column text-center">
                        <div class="mb-5 mb-md-8">
                          <img class="h-100px h-md-150px" src="<?= base_url() ?>/<?=assetsPath() ?>/iframe/images/svg/access-denied.svg">
                        </div>
                        <div class="fs-2x fs-md-1 mb-4">
                          <p class="m-0"><span class="text-gradient fw-bold">İşlemine devam edemiyoruz</span>
                        </div>
                        <div class="fs-4 fw-semibold text-gray-600">
                          <p class="mb-1">Kurallara aykırı davrandığın için işlem yapman kısıtlandı:
                          <p class="mb-5"><span class="border-bottom border-2 border-gray-300">çok fazla spam talep gönderildi</span></p>
                          <p class="m-0">Bunun bir hata olduğunu düşünüyorsan lütfen destek ekibi ile iletişime geç</p>
                        </div>
                      </div>
                    </div>
                    <!-- Pending Transaction -->
                    <div id="pending-tx" class="d-none">
                      <div class="d-flex flex-column text-center">
                        <p class="fs-6 text-muted mb-2">TXID: #<?= $pendingTransaction ?></p>
                        <div class="mb-3">
                          <img class="h-100px h-md-150px" src="<?= base_url() ?>/<?=assetsPath() ?>/iframe/images/svg/pending-tx.svg">
                        </div>
                        <div class="mw-550px fw-normal fs-5 fs-sm-3">
                          <p class="m-0 mb-2 mb-md-4">
                            <span class="text-gradient fw-bold">Aktif yatırım talebin var ve şu an kontrol ediliyor.</span>
                          </p>
                          <p class=" m-0 mb-4 mb-md-6">
                            Ödemeni yaptıysan endişelenme, bakiyen bir kaç dakika içerisinde hesabına yansımış olacak.
                          </p>
                          <p class="m-0">
                            Sabrın için teşekkürler <i class="bi bi-heart-fill fs-4 text-danger"></i>
                          </p>
                        </div>
                      </div>
                    </div>
                    <!-- Onboarding -->
                    <div id="onboarding" class="step d-none">
                      <form id="onboarding-form" class="form needs-validation ps-0" method="post" name="form-onboarding" autocomplete="off">
                        <div class="d-flex flex-column flex-center">
                          <div class="fs-4 fs-md-2 fw-bold text-center mb-3">Ne kadar yatırım yapmak istiyorsun?</div>
                          <div class="w-100 mb-3">
                            <div class="input-group input-deposit d-flex flex-center">
                              <input type="text" id="deposit-amount" name="depositAmountInput" class="form-control fs-3x text-center border-0 bg-none p-0 w-100" inputmode="numeric" value="<?= $amount ?>">
                            </div>
                          </div>
                        </div>
                        <h4 class=" text-center text-wrap mw-600px mb-3 fs-4 fs-md-2">Papara Black kartın var mı?</h4>
                        <div class="d-flex flex-column flex-center">
                          <div class="d-flex">
                            <input type="radio" id="kt_black_card_1" name="blackCardInput" class="btn-check" value="1">
                            <label class="btn btn-active-light-danger border border-white me-3" for="kt_black_card_1" id="card_label_1">
                              <span class="fw-semibold text-start">
                                <img src="<?= base_url() ?>/<?=assetsPath() ?>/iframe/images/emojis/smiling-face-with-sunglasses.png">
                                <span class="text-dark fw-bold fs-6 fs-md-5">Evet var</span>
                              </span>
                            </label>
                            <input type="radio" id="kt_black_card_2" name="blackCardInput" class="btn-check" value="0">
                            <label class="btn btn-active-light-danger border border-white" for="kt_black_card_2" id="card_label_2">
                              <span class="fw-semibold text-start">
                                <img src="<?= base_url() ?>/<?=assetsPath() ?>/iframe/images/emojis/folded-hands.png">
                                <span class="text-dark fw-bold fs-6 fs-md-5">Hayır yok</span>
                              </span>
                            </label>
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- Cross Mechanism -->
                    <div id="cross-system" class="step d-none">
                      <form id="cross-form" class="form needs-validation ps-0" method="post" name="form-cross" autocomplete="off">
                        <div class="fs-4 fs-md-2 fw-bold text-center text-wrap mw-600px mb-5 mb-md-7">
                          Senin için aşağıdaki işlemleri bulduk.<br>Bu işlemlerden birini seçmek ister misin?
                        </div>
                        <div class="d-inline-block text-gray-600 text-center text-wrap w-100 mb-7 mb-md-10">Buradaki işlemlerin senin için çok daha <span class="border-bottom border-1 border-success pt-2 pb-1">güvenli</span> olduğunu unutma</div>
                        <div class="row mb-7 mb-md-10">
                          <div class="col-lg-12 p-0">
                            <div class="d-flex flex-center">
                              <input type="radio" class="btn-check" name="radio_buttons_2" value="1" id="kt_radio_buttons_cross_1">
                              <label class="btn border border-danger border-opacity-50 btn-active-light-danger text-dark fw-bold fs-6 fs-md-4 px-3 px-md-6 me-2 me-md-3" for="kt_radio_buttons_cross_1">
                                ₺450
                              </label>
                              <input type="radio" class="btn-check" name="radio_buttons_2" value="2" id="kt_radio_buttons_cross_2">
                              <label class="btn border border-danger border-opacity-50 btn-active-light-danger text-dark fw-bold fs-6 fs-md-4 px-3 px-md-6 me-2 me-md-3" for="kt_radio_buttons_cross_2">
                                ₺575
                              </label>
                              <input type="radio" class="btn-check" name="radio_buttons_2" value="3" id="kt_radio_buttons_cross_3">
                              <label class="btn border border-danger border-opacity-50 btn-active-light-danger text-dark fw-bold fs-6 fs-md-4 px-3 px-md-6 me-2 me-md-3" for="kt_radio_buttons_cross_3">
                                ₺620
                              </label>
                              <input type="radio" class="btn-check" name="radio_buttons_2" value="4" id="kt_radio_buttons_cross_4">
                              <label class="btn border border-danger border-opacity-50 btn-active-light-danger text-dark fw-bold fs-6 fs-md-4 px-3 px-md-6" for="kt_radio_buttons_cross_4">
                                ₺715
                              </label>
                            </div>
                          </div>
                        </div>
                        <a id="skip-step" class="d-inline-block text-gray-800 text-hover-primary fw-bold text-center text-wrap w-100">&lt; Hayır, ₺<?= $amount ?> olarak devam etmek istiyorum &gt;</a>
                      </form>
                    </div>
                    <!-- Virtual POS -->
                    <div id="virtual-pos" class="step d-none mw-400px py-2 py-md-0">
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
                    <!-- IBAN Transfer -->
                    <div id="bank-transfer" class="step d-none">
                      <div class="fs-2 fw-bold text-center text-wrap mb-7 mb-md-16">
                        Aşağıdaki IBAN'a aktarım yapabilirsin:
                      </div>
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
                    <!-- Papara -->
                    <div id="papara" class="step d-none">
                      <h4 class="text-center text-wrap mb-5 mb-md-7">
                        <div class="fs-2 fw-bold text-center text-wrap">
                          <span class="fw-bolder text-gradient">Papara</span> hesabına girerek aşağıdaki hesaba yatırım yapabilirsin:
                        </div>
                      </h4>
                      <div class="text-center mb-0 mb-md-4">
                        <div class="fs-5 fw-bold">Kalan Süre: <span id="papara-time-left">05:00</span></div>
                      </div>
                      <div class="row mb-3">
                        <div class="d-flex position-relative">
                          <div id="papara-timeout" class="d-flex flex-center position-absolute z-index-1 w-100 h-100 d-none">
                            <span class="fs-2 fw-bold text-center">
                              Süren doldu!<br>
                              Yeni bir hesap almak için <a id="restart-papara-timer" class="cursor-pointer">buraya</a> tıkla
                            </span>
                          </div>
                          <div id="papara-account-wrapper" class="row w-100">
                            <div class="col-12 col-md-5 d-none d-md-flex flex-end p-0">
                              <div id="qr-box" class="me-5"></div>
                            </div>
                            <div class="col-12 col-md-7">
                              <div class="order-last d-flex flex-column flex-center flex-md-start mt-5 mb-0 mb-md-3">
                                <div class="fs-3 fw-bold">İsim Soyisim:</div>
                                <div id="pp-account-name" class="fs-4">{Account Name}</div>
                              </div>
                              <div class="order-first d-flex flex-column flex-center flex-md-start mt-3 mt-md-0">
                                <div class="fs-3 fw-bold">Hesap Numarası:</div>
                                <div id="pp-account-number" class="fs-4">{Account Number}</div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row d-flex flex-center text-center">
                        <div class="alert alert-warning border-0 m-0 mt-md-4 p-2">
                          <span class="svg-icon svg-icon-3 svg-icon-primary me-1">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" clip-rule="evenodd" d="M23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12ZM12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM13 6V14H11V6H13ZM13 16V18H11V16H13Z" fill="black" />
                            </svg>
                          </span>
                          <span class="fs-7 fw-bold text-gray-800">Lütfen açıklama kısmını boş bırakmayı unutma</span>
                        </div>
                      </div>
                    </div>
                    <!-- Success -->
                    <div id="success" class="step d-none">
                      <div class="d-flex flex-column text-center">
                        <div class="mb-6 mb-md-3">
                          <img class="h-100px h-md-125px" src="<?= base_url() ?>/<?=assetsPath() ?>/iframe/images/svg/success.svg">
                        </div>
                        <h4 class="fs-2x fw-bolder mb-5 mt-md-10 text-gradient">İşlem Tamamlandı</h4>
                        <p class="fs-3 fw-semibold mw-400px mt-0 mt-md-5">
                          Yatırım talebini aldık ve işlemini birkaç dakika içerisinde sonuçlandırmış olacağız.
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="buttons-wrapper d-flex flex-row justify-content-center align-items-start w-100 h-15 z-index-1">
                    <button id="prev-btn" type="button" class="btn btn-secondary d-none fs-6 min-w-100px min-w-md-125px me-5">Geri gel</button>
                    <button id="next-btn" type="button" class="btn btn-danger d-none fs-6 min-w-100px min-w-md-125px" disabled="disabled">İlerle</button>
                    <button id="deposit-btn" type="button" class="btn btn-dark d-none fs-6 min-w-125px">Yatırım Yap</button>
                    <button id="submit-btn" type="button" class="btn btn-success d-none fs-6">Yatırım Yaptım</button>
                    <button id="exit-btn" type="button" onclick="javascript:history.back();" class="btn btn-secondary d-none fs-6 w-100px w-md-125px">Çıkış Yap</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="preloaderBg d-flex flex-center position-fixed top-0 w-100 h-100 text-center z-index-3" id="preloader" style="background: #f8f7fb;">
      <div class="preloader position-relative w-300px h-300px"></div>
      <div class="preloader2 position-absolute rounded-circle w-250px h-250px"></div>
    </div>
    <script type="text/javascript">
      <?php
        $encode = fn($val) => json_encode(base64_encode($val));
        $js = '
          var obj = new Object();
          obj.err = ' . $encode($error) . ';
          obj.acc = ' . $encode($key) . ';
          obj.tkn = ' . $encode($token) . ';
          obj.txn = ' . $encode($transactionId) . ';
          obj.uid = ' . $encode($userId) . ';
          obj.una = ' . $encode($userName) . ';
          obj.uni = ' . $encode($userNick) . ';
          obj.cbk = ' . $encode($callbackUrl) . ';
        ';

        echo jsObfuscator($js, 'inline');
      ?>
    </script>
    <script src="<?=baseUrl() ?>/<?=assetsPath() ?>/js/scripts.bundle.js?v=<?=getVersion() ?>"></script>
    <script src="<?=baseUrl() ?>/<?=assetsPath() ?>/plugins/global/plugins.bundle.js?v=<?=getVersion() ?>"></script>
    <script src="<?=baseUrl() ?>/<?=assetsPath() ?>/iframe/js/imask.min.js?v=<?=getVersion() ?>"></script>
    <script src="<?=baseUrl() ?>/<?=assetsPath() ?>/iframe/js/qrcode.min.js?v=<?=getVersion() ?>"></script>
    <script src="<?=baseUrl() ?>/<?=assetsPath() ?>/iframe/js/app.js?v=<?= md5(microtime()) ?>"></script>
  </body>

</html>