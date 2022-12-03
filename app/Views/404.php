<!DOCTYPE html>
<html data-theme="light" lang="en">

<head>
    <base href="<?=base_url() ?>" />
    <title>Paypara - 404 Not Found</title>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?=base_url('assets/branding/favicon.ico') ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="<?=base_url('assets/v8/plugins/global/plugins.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/v8/css/style.bundle.css') ?>" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <script>
        let themeMode, defaultThemeMode = "light";
        document.documentElement && ("system" === (themeMode = document.documentElement.hasAttribute(
                "data-theme-mode") ? document.documentElement.getAttribute("data-theme-mode") : null !==
                localStorage.getItem("data-theme") ? localStorage.getItem("data-theme") : defaultThemeMode) && (
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"), document
            .documentElement.setAttribute("data-theme", themeMode));
    </script>
    <style>
        body {
            background-image: url("<?= base_url('assets/v8/media/auth/bg10.jpeg') ?>")
        }

        [data-theme=dark] body {
            background-image: url("<?= base_url('assets/v8/media/auth/bg10-dark.jpeg') ?>")
        }

        .border-end {
            border-right: none !important
        }

        @media (min-width:992px) {
            .border-end {
                border-right: 1px solid #e4e6ed !important
            }
        }
    </style>

    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-column-fluid flex-center">
            <div class="d-flex flex-lg-row flex-column">
                <div class="text-center">
                    <h1 class="fs-4x fw-bolder text-dark border-end pe-lg-10 pb-5 pb-lg-7 m-0"><?=PROTOCOL.HOSTNAME.'/' ?></h1>
                </div>
                <div class="ms-lg-9 d-flex flex-column flex-center flex-lg-start">
                    <div class="text-center text-lg-start">
                        <h1 class="fs-4x fw-bolder m-0 mb-2 mb-lg-0">Page not found</h1>
                        <h1 class="fs-2 text-gray-600 fw-normal m-0">Please check the URL in the address bar and try
                            again.</h1>
                    </div>
                    <a href="javascript:history.back()" class="btn btn-dark mt-15">Go back</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>