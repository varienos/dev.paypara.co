<?php require appViewPath().'layout/header/header.php' ?>

<body id="kt_body" class="sidebar-disabled">
  <?php require appViewPath().'partials/theme-mode/_init.php' ?> <div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
      <?php require appViewPath().'layout/aside/_base.php' ?> <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
          <div id="kt_header" class="header">
            <div class="container d-flex flex-stack flex-wrap gap-2" id="kt_header_container">
              <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-5 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                <? $pageTitle = segment[2] === "1" ? "Papara" : (segment[2] === "2" ? "Matching" : "Bank") ?>
                <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">
                  <? echo($pageTitle) ?> Accounts
                </h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold fs-base my-1">
                  <li class="breadcrumb-item text-muted">
                    <a href="dashboard" class="text-muted">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item text-muted">Accounts</li>
                  <li class="breadcrumb-item text-dark">
                    <? echo($pageTitle) ?> Accounts
                  </li>
                </ul>
              </div>
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
          <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="container-xxl" id="kt_content_container">
              <div class="card border">
                <div class="card-header border-0 pt-6">
                  <div class="card-title w-100 w-md-auto">
                    <div class="d-flex align-items-center position-relative w-100 my-1">
                      <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                          <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                        </svg>
                      </span>
                      <input type="text" data-kt-customer-table-filter="search" id="search" class="form-control form-control-solid border border-1 w-100 w-md-250px ps-15" placeholder="Search accounts" />
                    </div>
                  </div>
                  <div class="card-toolbar w-100 w-md-auto">
                    <div class="d-flex flex-center flex-md-end flex-wrap gap-3 w-100">
                      <form id="formFilter">
                        <select class="form-select form-select-solid border border-1" id="accountStatus" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-ecommerce-order-filter="status">
                          <option></option>
                          <option value="status::all">All</option>
                          <option value="status::on">Active</option>
                          <option value="status::0">Deactive</option>
                        </select>
                      </form>
                      <? if(((segment[2] == 1 || segment[2] == 2) && edit_papara_account === true) || (segment[2] == 3 && edit_bank_account === true)): ?>
                      <a class="btn btn-light ps-7 ml-0 text-nowrap" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-offset="0px, 5px">Actions <span class="svg-icon svg-icon-2 me-0">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
                          </svg>
                        </span>
                      </a>
                      <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6" data-kt-menu="true">
                        <div class="menu-item px-5">
                          <div class="menu-content text-muted pb-2 px-5 fs-7 text-uppercase">
                            <? echo($pageTitle) ?> Accounts
                          </div>
                        </div>
                        <div class="menu-item px-5 my-1">
                          <a href="javascript:" class="menu-link text-success px-5" data-set="status-set-all" data-status="on">Enable all</a>
                        </div>
                        <div class="menu-item px-5">
                          <a href="javascript:" class="menu-link text-danger px-5" data-set="status-set-all" data-status="0">Disable all</a>
                        </div>
                      </div>
                      <? endif ?>
                      <? if((segment[2] == 1 || segment[2] == 2) && add_papara_account === true): ?>
                      <button type="button" class="btn btn-primary text-nowrap" data-url="account/form/<?=segment[2] ?>" id="formAjax" data-bs-toggle="modal" data-bs-target="#ajaxModal" data-bs-delay='1000'>Add New Account</button>
                      <? endif; ?>
                      <? if(segment[2] == 3 && add_bank_account === true): ?>
                      <button type="button" class="btn btn-primary text-nowrap" data-url="account/form/<?=segment[2] ?>" id="formAjax" data-bs-toggle="modal" data-bs-target="#ajaxModal" data-bs-delay='1000'>Add New Account</button>
                      <? endif; ?>
                    </div>
                  </div>
                </div>
                <div class="card-body pt-0">
                  <div id="datatableContent_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="table-responsive">
                      <table class="table table-responsive table-row-dashed align-middle dataTable fs-6 gy-5" id="datatable_content">
                        <thead>
                          <!-- 1 papara, 2 match, 3 banka -->
                          <? if(segment[2] === "1"): ?>
                          <?php require appViewPath() . 'account/include/tableHeadPapara.php' ?>
                          <? elseif(segment[2] === "2"): ?>
                          <?php require appViewPath() . 'account/include/tableHeadMatch.php' ?>
                          <? else: ?>
                          <?php require appViewPath() . 'account/include/tableHeadBank.php' ?>
                          <? endif; ?>
                        </thead>
                        <tbody class="fw-semibold text-gray-600 text-center"></tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php require appViewPath().'layout/_footer.php' ?>
        </div>
      </div>
    </div>
  </div>
  <?php require appViewPath().'layout/footer/footer.php' ?>