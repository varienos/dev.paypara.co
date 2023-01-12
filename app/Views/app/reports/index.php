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
                <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">Reports</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold fs-base my-1">
                  <li class="breadcrumb-item text-muted">
                    <a href="dashboard" class="text-muted">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item text-dark">Reports</li>
                </ul>
              </div>
              <div class="d-flex d-lg-none align-items-center ms-n2 me-2">
                <div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
                  <span class="svg-icon svg-icon-1 mt-1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" /><path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" /></svg>
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
          <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="container-xxl" id="kt_content_container">

            <div class="row">
              <div class="col-12">
                <div class="card card-bordered card-flush mb-5">
                  <div class="card-header py-5 py-sm-0">
                    <div class="card-title w-100 w-sm-auto">
                      <h3 class="fw-bold w-100 d-flex flex-center flex-sm-start">Monthly Reports</h3>
                    </div>
                    <div class="card-toolbar d-flex flex-center w-100 w-sm-auto">
                      <!-- Sadece aylari gostermeli (Bu Ay, Geçen Ay, Özel Aralık: Yil/Ay Listesi) -->
                      <!-- Bunun icin CSS ile gun araligi gizlenebilir. Ornek: https://stackoverflow.com/a/30619736 -->
                      <div id="reportsDate" data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left" data-kt-daterangepicker-range="month" class="btn btn-sm btn-light d-flex flex-center border px-4 mw-225px">
                        <div class="text-gray-600 fw-bold">Loading date range...</div>
                        <span class="svg-icon svg-icon-1 ms-2 me-0">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" /><path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" /><path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
                          </svg>
                        </span>
                      </div>
                      <div class="w-150px ms-3">
                        <select class="form-select form-select-solid border" data-control="select2" data-hide-search="true">
                          <option value="1" selected>All Firms</option>
                          <option value="2">Firm 1</option>
                          <option value="3">Firm 2</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card card-bordered card-flush mb-5">
                  <div class="card-body d-flex justify-content-between flex-column pb-0 px-0 pt-1">
                    <div class="d-flex flex-wrap flex-center gap-5 w-100 px-9 py-5 my-5 mb-sm-0 mt-sm-5">
                      <div class="me-md-2">
                        <div class="fs-6 fw-semibold text-gray-600 w-100 text-center mb-1">Total Deposits</div>
                        <div class="d-flex mb-2">
                          <span class="fs-4 fw-semibold text-gray-600 me-1">₺</span>
                          <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">10.401.170,65</span>
                        </div>
                      </div>
                      <div class="ps-md-10 pe-md-7 me-md-5">
                        <div class="fs-6 fw-semibold text-gray-600 w-100 text-center mb-1">Total Withdrawals</div>
                        <div class="d-flex mb-2">
                          <span class="fs-4 fw-semibold text-gray-600 me-1">₺</span>
                          <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">4.160.468,45</span>
                        </div>
                      </div>
                      <div class="m-0">
                        <div class="fs-6 fw-semibold text-gray-600 w-100 text-center mb-1">Average Daily Deposit</div>
                        <div class="d-flex align-items-center mb-2">
                          <span class="fs-4 fw-semibold text-gray-600 align-self-start me-1">₺</span>
                          <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">1.945.117,99</span>
                        </div>
                      </div>
                    </div>
                    <div class="row d-none d-sm-block mx-0">
                      <div class="col-12 d-flex flex-center px-0">
                        <div id="chart-reports-main" class="min-h-auto w-100 h-300px px-4"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <? if(partner === true): ?>
              <?php require appViewPath().'reports/_partner.php' ?>
            <? else: ?>
              <?php require appViewPath().'reports/_admin.php' ?>
            <? endif; ?>

            </div>
          </div>
          <?php require appViewPath().'layout/_footer.php' ?>
        </div>
      </div>
    </div>
    <?php require appViewPath().'layout/footer/footer.php' ?>