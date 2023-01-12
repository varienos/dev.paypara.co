<!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?=baseUrl() ?>" />
    <title>Paypara</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:site_name" content="Paypara" />
    <link rel="shortcut icon" href="<?=base_url("assets/core/images/favicon.ico") ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link rel="stylesheet" href="<?=baseUrl() ?>/<?=gulpAssets() ?>/plugins/global/plugins.bundle.css?v=<?=getVersion() ?>">
    <link rel="stylesheet" href="<?=baseUrl() ?>/<?=gulpAssets() ?>/css/style.bundle.css?v=<?=getVersion() ?>">
    <link rel="stylesheet" href="<?=baseUrl() ?>/<?=coreAssets() ?>/css/app.min.css?v=<?=md5(microtime()) ?>">
</head>
<? if(maintenanceStatus=="on"): ?>
<div class="notice d-flex flex-center shadow-lg bg-danger position-fixed h-45px w-100" style="z-index: 999;">
    <span class="svg-icon svg-icon-2hx svg-icon-warning me-2">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
            <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"></rect>
            <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"></rect>
        </svg>
    </span>
    <h4 class="text-white fw-bold m-0">Maintenance mode is active, all payments are halted!</h4>
</div>
<? endif; ?>