<!DOCTYPE html>
<html data-theme="light" lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paypara Payment Demo</title>
    <link rel="shortcut icon" href="<?=baseUrl() ?>/<?=assetsPath() ?>/iframe/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=baseUrl() ?>/<?=assetsPath() ?>/plugins/global/plugins.bundle.css">
    <link rel="stylesheet" href="<?=baseUrl() ?>/<?=assetsPath() ?>/css/style.bundle.css">
    <link rel="stylesheet" href="<?=baseUrl() ?>/<?=assetsPath() ?>/iframe/css/app.css?v=<?=md5(microtime()) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <base href="<?=base_url() ?>" />
  </head>

  <body>
    <div class="container overflow-hidden">
      <div class="row justify-content-center">
        <div class="d-flex pb-20 pb-md-0 min-vh-100 align-items-center">
          <div class="d-flex align-items-stretch rounded-3 w-100 shadow-lg bg-white" style="height: 565px;">
            <div class="col-12">
              <div class="content p-8 px-lg-14 d-flex flex-column">
                <div class="d-flex justify-content-center justify-content-sm-between align-items-center mb-5">
                  <div class="d-flex">
                    <i class="bi-code-slash fs-2hx text-dark me-3"></i>
                    <h3 id="header" class="fs-2x fw-bolder d-flex align-items-center"></i>Payment Demo</h3>
                  </div>
                  <img src="<?=baseUrl() ?>/<?=assetsPath() ?>/iframe/images/logo.png" class="logo d-none d-sm-block m-0" width="110px" height="37px" alt="Paypara Logo">
                </div>
                <div class="overflow-auto rounded border p-10 h-100">
                  <form id="demoForm" class="form ps-0" method="post" enctype="multipart/form-data" target="_blank" autocomplete="off">
                    <div class="row">
                      <div class="col-12 col-sm-6">
                        <div class="mb-2">
                          <label class="required form-label">API Key:</label>
                          <input id="apiKey" name="apiKey" type="text" class="form-control bg-white text-gray-700" placeholder="Firma API anahtarı" value="3d1a8a25-7492-4042-89ee-f554c0ba5c1a" readonly="readonly" />
                        </div>
                        <div class="mb-2">
                          <label class="required form-label">Transaction ID:</label>
                          <input id="transactionId" name="transactionId" type="tel" class="form-control" placeholder="İşlem Transaction ID" value="" />
                        </div>
                        <div class="mb-2">
                          <label class="required form-label">User ID:</label>
                          <input id="userId" name="userId" type="tel" class="form-control" placeholder="Üye User ID" value="" />
                        </div>
                        <div class="mb-2">
                          <label class="required form-label">User Name:</label>
                          <input id="userName" name="userName" type="text" class="form-control" placeholder="Üye adı soyadı" value="" />
                        </div>
                      </div>
                      <div class="col-12 col-sm-6">
                        <div class="mb-2">
                          <label class="required form-label">User Nick:</label>
                          <input id="userNick" name="userNick" type="text" class="form-control" placeholder="Üye kullanıcı adı" value="" />
                        </div>
                        <div class="mb-2">
                          <label class="required form-label">Amount:</label>
                          <div class="input-group">
                            <span class="input-group-text">₺</span>
                            <input id="amount" name="amount" type="tel" class="form-control" placeholder="Yatırım tutarı" value="250" />
                          </div>
                        </div>
                        <div class="mb-2">
                          <label class="required form-label">Callback:</label>
                          <input id="callback" name="callback" type="text" class="form-control" placeholder="İşlem callback URL" value="demo.com" />
                        </div>
                        <div class="d-flex justify-content-between align-items-center h-45px mt-10">
                          <div id="error" class="border border-danger" style="padding: 5px; font-size: 10px; border-radius: 15px;"></div>
                          <button id="refresh" class="btn btn-icon btn-sm btn-secondary rounded-circle w-40px h-40px p-0">
                            <i class="fs-3 bi bi-arrow-clockwise"></i>
                          </button>
                        </div>
                      </div>
                      <div class="d-flex flex-center mt-5 mt-md-8">
                        <button id="call" type="button" class="btn btn-dark fs-6 w-200px">İşlem Başlat</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="<?=baseUrl() ?>/<?=assetsPath() ?>/js/scripts.bundle.js"></script>
    <script src="<?=baseUrl() ?>/<?=assetsPath() ?>/plugins/global/plugins.bundle.js"></script>
    <script>
    <?=jsObfuscator(getJsClientData,'inline'); ?>
    </script>
    <!--<script src="https://dev.paypara.co/<?=assetsPath() ?>/js/app.core.error.handler.js?v=<?=md5(microtime()) ?>"></script>-->
    <script src="<?=baseUrl() ?>/<?=assetsPath() ?>/iframe/js/demo.js?v=<?=md5(microtime()) ?>"></script>
  </body>

</html>