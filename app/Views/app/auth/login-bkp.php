<!DOCTYPE html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <base href="<?=baseUrl() ?>" />
    <title>Paypara</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="<?=baseUrl('assets/media/logos/favicon.ico') ?>" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="<?=baseUrl(gulpAssets().'/plugins/global/plugins.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?=baseUrl(gulpAssets().'/css/style.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
  </head>
  <!--end::Head-->
  <!--begin::Body-->

  <body id="kt_body" class="app-blank">
    <!--begin::Theme mode setup on page load-->
    <script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
      if (document.documentElement.hasAttribute("data-theme-mode")) {
        themeMode = document.documentElement.getAttribute("data-theme-mode");
      } else {
        if (localStorage.getItem("data-theme") !== null) {
          themeMode = localStorage.getItem("data-theme");
        } else {
          themeMode = defaultThemeMode;
        }
      }
      if (themeMode === "system") {
        themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
      }
      document.documentElement.setAttribute("data-theme", themeMode);
    }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
      <!--begin::Authentication - Sign-in -->
      <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Body-->
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
          <!--begin::Form-->
          <div class="d-flex flex-center flex-column flex-lg-row-fluid">
            <!--begin::Wrapper-->
            <div class="w-lg-500px p-10">
              <!--begin::Form-->
              <form class="form w-100" novalidate="novalidate" class="login-form" method="post" action="<?=baseUrl('primeSecure/auth') ?>">
                <!--begin::Heading-->
                <div class="text-center mb-11">
                  <!--begin::Title-->
                  <h1 class="text-dark fw-bolder mb-3">Paypara</h1>
                  <!--end::Title-->
                  <!--begin::Subtitle-->
                  <div class="text-gray-500 fw-semibold fs-6">Sisteme giriş yapın</div>
                  <!--end::Subtitle=-->
                </div>
                <!--begin::Heading-->
                <!--begin::Login options-->

                <!--end::Login options-->
                <!--begin::Separator-->
                <div class="separator separator-content my-14">
                  <span class="w-125px text-gray-500 fw-semibold fs-7">Kullanıcı</span>
                </div>
                <!--end::Separator-->
                <!--begin::Input group=-->
                <div class="fv-row mb-8">
                  <!--begin::Email-->
                  <input type="text" placeholder="Email" name="x" autocomplete="off" class="form-control bg-transparent" />
                  <!--end::Email-->
                </div>
                <!--end::Input group=-->
                <div class="fv-row mb-3">
                  <!--begin::Password-->
                  <input type="password" placeholder="Password" name="y" autocomplete="off" class="form-control bg-transparent" />
                  <!--end::Password-->
                </div>
                <!--end::Input group=-->
                <!--begin::Wrapper-->
                <!--end::Wrapper-->
                <!--begin::Submit button-->
                <div class="d-grid mb-10">
                  <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                    <!--begin::Indicator label-->
                    <span class="indicator-label">Giriş Yap</span>
                    <!--end::Indicator label-->
                    <!--begin::Indicator progress-->
                    <span class="indicator-progress">Lütfen Bekleyiniz...
                      <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    <!--end::Indicator progress-->
                  </button>
                </div>
                <!--end::Submit button-->
              </form>
              <!--end::Form-->
            </div>
            <!--end::Wrapper-->
          </div>
          <!--end::Form-->
          <!--begin::Footer-->

          <!--end::Footer-->
        </div>
        <!--end::Body-->
        <!--begin::Aside-->
        <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url(assets/v8/login.jpg)">
          <!--begin::Content-->
          <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
            <!--begin::Logo-->
            <a href="#" class="mb-0 mb-lg-12">
              <img alt="Logo" src="<?=baseUrl('assets/branding/logo.png') ?>" class="h-60px h-lg-75px" />
            </a>
            <!--end::Logo-->
          </div>
          <!--end::Content-->
        </div>
        <!--end::Aside-->
      </div>
      <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <!--begin::Javascript-->
    <script>
    var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="<?=baseUrl(gulpAssets().'/plugins/global/plugins.bundle.js') ?>"></script>
    <script src="<?=baseUrl(gulpAssets().'/js/scripts.bundle.js') ?>"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used by this page)-->
    <script src="<?=baseUrl(gulpAssets().'/js/custom/authentication/sign-in/general.js') ?>"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
  </body>
  <!--end::Body-->

</html>