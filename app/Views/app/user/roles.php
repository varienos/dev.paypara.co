<?php require appViewPath().'layout/header/header.php' ?>
<body id="kt_body" class="sidebar-disabled">
  <?php require appViewPath().'partials/theme-mode/_init.php' ?>
  <div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
      <?php require appViewPath().'layout/aside/_base.php' ?>
      <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
          <div id="kt_header" class="header">
            <div class="container d-flex flex-stack flex-wrap gap-2" id="kt_header_container">
              <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-5 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">Yetkilendirme</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold fs-base my-1">
                  <li class="breadcrumb-item text-muted">
                    <a href="dashboard" class="text-muted">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item text-muted">
                    <a href="/user/index" class="text-muted">Kullanıcılar</a>
                  </li>
                  <li class="breadcrumb-item text-dark">Yetkilendirme</li>
                </ul>
              </div>
              <div class="d-flex d-lg-none align-items-center ms-n2 me-2">
                <div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
                  <span class="svg-icon svg-icon-1 mt-1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" /><path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" /></svg>
                  </span>
                </div>
                <a href="dashboard" class="d-flex align-items-center">
                  <img alt="Logo" src="<?=baseUrl('assets/branding/logo.png') ?>" class="theme-light-show h-30px" />
                  <img alt="Logo" src="<?=baseUrl('assets/branding/logo.png') ?>" class="theme-dark-show h-30px" />
                </a>
              </div>
              <?php require appViewPath().'layout/header/__topbar.php' ?>
            </div>
          </div>
          <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="container-xxl" id="kt_content_container">
              <div class="card mb-5 mb-xxl-10 border">
                <div class="card-header">
                  <div class="card-title justify-content-between w-100 m-0">
                    <h2>Yetkiler</h2>
                    <? if (add_role === true): ?>
                    <button type="button" class="btn btn-sm btn-light-primary" id="formAjax" data-bs-toggle="modal" data-bs-target="#ajaxModal" data-url="user/role/0">
                      <i class="bi bi-plus-circle fs-5"></i>Yeni Yetki Ekle
                    </button>
                    <? endif; ?>
                  </div>
                </div>
                <div class="card-body p-9">
                  <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fw-semibold text-gray-600 fs-6 gy-5" id="datatableRole">
                      <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                          <th class="min-w-200px">Yetki adı</td>
                          <th class="min-w-200px">Kullanıcılar</td>
                          <th class="min-w-150px text-end">İşlemler</td>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php require appViewPath().'layout/_footer.php' ?>
        </div>
      </div>
    </div>
    <?php require appViewPath().'layout/footer/footer.php' ?>