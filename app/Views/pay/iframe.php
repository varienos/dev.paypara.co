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
    <div class="container container-p-0">
      <div class="row d-flex flex-center vh-100">
        <div class="col-md-11 p-0">
          <div class="d-flex align-items-stretch rounded-3 overflow-hidden w-100 shadow-lg bg-white vh-100 h-md-550px">
            <div class="col-xl-3 d-none d-xl-flex">
              <video class="hero-media" autoplay muted loop>
                <source src="<?= base_url() ?><?=assetsPath() ?>/iframe/images/backgrounds/hero-video.mp4" type="video/mp4">
              </video>
            </div>
            <div class="col-12 col-xl-9 block-frame">
              <div class="progress h-5px rounded-0">
                <div aria-valuemax="100" aria-valuemin="0" class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 0%"></div>
              </div>
              <div class="frame p-8 px-md-14 d-flex flex-column">
                <div class="d-flex flex-column-reverse flex-md-row justify-content-md-between align-items-center align-items-md-start">
                  <div class="mt-12 mt-md-0 text-center text-md-start">
                    <div class="d-flex justify-content-center justify-content-md-start">
                      <img src="<?= base_url() ?><?=assetsPath() ?>/iframe/images/emojis/waving-hand.png" width="24px" height="24px">
                      <h3 id="header" class="fs-1 fw-bolder ms-2 mb-4 mb-md-1">Hoşgeldin <?= strtok($userName, " ") ?>,</h3>
                    </div>
                    <p id="description" class="fs-6 text-gray-700 fw-normal text-wrap"><span class="fw-bold text-dark"><?= $clientName ?></span> hesabına bakiye yüklemek için adımları takip et.</p>
                  </div>
                  <img src="<?= base_url() ?><?=assetsPath() ?>/iframe/images/logo.png" class="m-0 logo" width="146px" height="47px" alt="Paypara Logo">
                </div>

                <div id="content-frame" class="frame d-flex flex-column justify-content-between h-100 p-0">
                  <?= $content ?>
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

    <script src="<?=baseUrl() ?>/<?=assetsPath() ?>/js/scripts.bundle.js?v=<?=getVersion() ?>"></script>
    <script src="<?=baseUrl() ?>/<?=assetsPath() ?>/plugins/global/plugins.bundle.js?v=<?=getVersion() ?>"></script>
    <script src="<?=baseUrl() ?>/<?=assetsPath() ?>/iframe/js/imask.min.js?v=<?=getVersion() ?>"></script>
    <script src="<?=baseUrl() ?>/<?=assetsPath() ?>/iframe/js/qrcode.min.js?v=<?=getVersion() ?>"></script>
    <script src="<?=baseUrl() ?>/<?=assetsPath() ?>/iframe/js/app.js?v=<?= md5(microtime()) ?>"></script>
  </body>
</html>