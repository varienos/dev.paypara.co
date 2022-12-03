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
    <style>body{background-image:url('<?=baseUrl(gulpAssets().'/media/auth/bg10.jpeg') ?>')}[data-theme=dark] body{background-image:url('<?=baseUrl(gulpAssets().'/media/auth/bg10-dark.jpeg') ?>')} .logo:hover {filter: drop-shadow(0 0 2rem #d95158)};</style>
    <div class="d-flex my-auto">
      <div class="d-flex flex-column flex-center mx-auto">
        <div class="mb-15">
          <img alt="Logo" src="<?=baseUrl('assets/branding/logo.png') ?>" class="logo theme-light-show h-60px h-sm-70px">
          <img alt="Logo" src="<?=baseUrl('assets/branding/logo.png') ?>" class="logo theme-dark-show h-60px h-sm-70px">
        </div>
        <div class="bg-body d-flex flex-center rounded border shadow p-10 min-w-sm-450px">
          <form class="form w-100" method="post" action="<?=baseUrl('secure/authentication') ?>">
            <div class="row mb-8">
              <h1 class="text-dark text-center m-0">Hesabınıza giriş yapın</h1>
            </div>
            <div class="row mb-3 d-none">
              <div class="alert alert-danger d-flex align-items-center px-5 py-3">
                <span class="svg-icon svg-icon-1 svg-icon-danger me-2">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect><rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"></rect><rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"></rect></svg>
                </span>
                <div class="d-flex flex-column">
                    <h5 class="fw-semibold m-0">Kullanıcı bilgilerini hatalı girdiniz</h5>
                </div>
              </div>
            </div>
            <div class="row mb-5">
              <label class="form-label fs-5 fw-bold">E-Posta</label>
              <input type="text" placeholder="E-posta adresiniz" name="x" autocomplete="off" class="form-control border-gray-300 bg-light bg-opacity-50">
            </div>
            <div class="row position-relative mb-8" data-kt-password-meter="true">
              <label class="form-label fs-5 fw-bold">Şifre</label>
              <input type="password" placeholder="••••••••" name="y" autocomplete="off" class="form-control border-gray-300 bg-light bg-opacity-50"/>
              <span class="btn btn-sm btn-icon position-absolute top-50 end-0 me-2 pb-1" data-kt-password-meter-control="visibility">
                <i class="bi bi-eye-slash fs-2"></i>
                <i class="bi bi-eye fs-2 d-none"></i>
              </span>
            </div>
            <div class="row">
              <button type="submit" class="btn btn-dark">Giriş Yap</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script src="<?=baseUrl(gulpAssets().'/plugins/global/plugins.bundle.js') ?>"></script>
    <script src="<?=baseUrl(gulpAssets().'/js/scripts.bundle.js') ?>"></script>
  </body>
</html