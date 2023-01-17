<div id="kt_header" class="header">
  <div class="container d-flex flex-stack flex-wrap gap-2" id="kt_header_container">
    <?php require appViewPath().'layout/header/__page-title.php' ?>
    <div class="d-flex d-lg-none align-items-center ms-n2 me-2">
      <div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
        <span class="svg-icon svg-icon-1 mt-1">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
            <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
          </svg>
        </span>
      </div>
      <a href="dashboard" class="d-flex align-items-center">
        <img alt="Logo" src="<?=baseUrl('assets/core/images/logo.png') ?>" class="theme-light-show h-30px" />
        <img alt="Logo" src="<?=baseUrl('assets/core/images/logo.png') ?>" class="theme-dark-show h-30px" />
      </a>
    </div>
    <?php require appViewPath().'layout/header/__topbar.php' ?>
  </div>
</div>