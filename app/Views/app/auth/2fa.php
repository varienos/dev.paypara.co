<!DOCTYPE html>
<html data-theme="light" lang="en">
  <head>
    <base href="<?=baseUrl() ?>" />
    <title>Paypara</title>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?=baseUrl(gulpAssets().'/iframe/images/favicon.ico') ?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="<?=baseUrl(gulpAssets().'/plugins/global/plugins.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?=baseUrl(gulpAssets().'/css/style.bundle.css') ?>" rel="stylesheet" type="text/css" />
  </head>
  <body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
  <style>body{background-image:url('<?=baseUrl(gulpAssets().'/media/background.jpeg') ?>')}[data-theme=dark] body{background-image:url('<?=baseUrl(gulpAssets().'/media/background-dark.jpeg') ?>')} .logo:hover {filter: drop-shadow(0 0 2rem #d95158)};</style>
    <div class="d-flex my-auto">
      <div class="d-flex flex-column flex-center mx-auto">
        <div class="mb-15">
          <img alt="Logo" src="<?=baseUrl('assets/core/images/logo.png') ?>" class="logo theme-light-show h-60px h-sm-70px">
          <img alt="Logo" src="<?=baseUrl('assets/core/images/logo.png') ?>" class="logo theme-dark-show h-60px h-sm-70px">
        </div>
        <div class="bg-body d-flex flex-center rounded border shadow p-10 min-w-sm-450px">
          <form class="form w-100" method="post" action="">
            <div class="row mb-8">
              <h2 class="fw-bold m-0"><i class="fs-2 bi bi-lock-fill text-dark"></i> 2FA Verification</h2>
            </div>
            <div class="row my-7">
                <div class="col-8 pe-0">
                    <input type="text" placeholder="Enter code" name="verificationCode" verificationCode autocomplete="off" class="form-control border-gray-300 bg-light bg-opacity-50">
                </div>
                <div class="col-4">
                    <button type="button" verify class="btn btn-light-dark w-100">Verify</button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script src="<?=baseUrl(gulpAssets().'/plugins/global/plugins.bundle.js') ?>"></script>
    <script src="<?=baseUrl(gulpAssets().'/js/scripts.bundle.js') ?>"></script>
    <script src="<?=activeDomain() . "/" . coreAssets() . "/js/2fa.js?v=" . md5(microtime()); ?>"></script>
  </body>
</html>