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
                <? $pageTitle = segment[2] === "deposit" ? "Deposits" : "Withdrawals" ?>
                <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">
                  <? echo($pageTitle) ?>
                </h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold fs-base my-1">
                  <li class="breadcrumb-item text-muted">
                    <a href="dashboard" class="text-muted">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item text-muted">Transactions</li>
                  <li class="breadcrumb-item text-dark">
                    <? echo($pageTitle) ?>
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
              <div class="d-flex align-items-center ms-auto me-n2">
                <div class="btn btn-icon btn-color-gray-700 btn-active-color-primary btn-outline w-40px w-sm-200px h-40px position-relative" id="accounts-toggle">
                  <i class="fs-1 bi bi-person-gear p-0 me-0 me-sm-2"></i>
                  <span class="d-none d-sm-block">Manage Accounts</span>
                </div>
              </div>
              <?php require appViewPath().'layout/header/__topbar.php' ?>
            </div>
          </div>
          <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="container-xxl" id="kt_content_container">
              <div class="card border">
                <div class="card-header border-0 pt-6 px-7">
                  <div class="card-title w-100 w-xxl-auto">
                    <div class="d-flex align-items-center w-100 w-xxl-auto my-1">
                      <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                          <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                        </svg>
                      </span>
                      <input type="text" data-kt-customer-table-filter="search" id="search" id="searchStr" class="form-control form-control-solid border border-1 w-100 w-xxl-225px ps-15" placeholder="Search transaction" />
                    </div>
                  </div>
                  <div class="card-toolbar w-100 w-xxl-auto">
                    <div class="d-flex flex-wrap justify-content-center justify-content-xxl-end gap-3 w-100 w-xxl-auto">
                      <input class="form-control form-control-solid border border-1 mw-225px" placeholder="Select a date range" value="<?=date("Y-m-d") ?>" name="transactionDate" id="transactionDate" />
                      <div>
                        <button type="button" class="btn btn-light ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" id="filtre">
                          <i class="fs-3 bi bi-funnel-fill p-0"></i>
                        </button>
                        <div class="menu menu-sub menu-sub-dropdown w-300px" data-kt-menu="true" id="filterMenu">
                          <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bold">Filter</div>
                          </div>
                          <div class="separator border-gray-200"></div>
                          <div class="px-7 py-5" data-kt-user-table-filter="form">
                            <div class="row mb-3">
                              <div class="col-4 d-flex align-items-center">
                                <label class="form-label fs-6 fw-semibold text-end w-100 m-0">Method:</label>
                              </div>
                              <div class="col ps-0">
                                <select class="form-select form-select-solid border border-1 fw-bold" name="method" id="method" data-kt-select2="true" data-placeholder="All" data-allow-clear="true" data-hide-search="true" app-onchange-datatable-reload>
                                  <option></option>
                                  <option value="bank">Bank</option>
                                  <option value="papara">Papara</option>
                                  <option value="cross">Cross</option>
                                  <option value="match">Match</option>
                                  <option value="pos">Virtual POS</option>
                                </select>
                              </div>
                            </div>

                            <div class="row mb-3">
                              <div class="col-4 d-flex align-items-center">
                                <label class="form-label fs-6 fw-semibold text-end w-100 m-0">Firm:</label>
                              </div>
                              <div class="col ps-0">
                                <select class="form-select form-select-solid border border-1 fw-bold" name="siteId" id="siteId" data-kt-select2="true" data-placeholder="All" data-allow-clear="true" data-hide-search="true" app-onchange-datatable-reload>
                                  <option></option>
                                  <? $site = explode(",",$update->perm_site); foreach($siteSelect as $row){ ?>
                                  <option value="<?=$row->id ?>"> <?=$row->site_name ?></option>
                                  <? } ?>
                                </select>
                              </div>
                            </div>

                            <div class="row mb-3">
                              <div class="col-4 d-flex align-items-center">
                                <label class="form-label fs-6 fw-semibold text-end w-100 m-0">Account:</label>
                              </div>
                              <div class="col ps-0">
                                <input type="text" class="form-control form-control-solid border border-1 fw-bold" name="accountIdFilter" id="accountIdFilter" placeholder="All" app-onchange-datatable-reload>
                              </div>
                            </div>

                            <div class="row mb-3">
                              <div class="col-4 d-flex align-items-center">
                                <label class="form-label fs-6 fw-semibold text-end w-100 m-0">Status:</label>
                              </div>
                              <div class="col ps-0">
                                <select class="form-select form-select-solid border border-1 fw-bold" name="status" id="status" data-kt-select2="true" data-placeholder="All" data-allow-clear="true" data-hide-search="true" app-onchange-datatable-reload>
                                  <option></option>
                                  <option value="beklemede">Pending</option>
                                  <option value="onaylandı">Approved</option>
                                  <option value="reddedildi">Rejected</option>
                                </select>
                              </div>
                            </div>

                            <div class="d-flex justify-content-end">
                              <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset" app-onclick-datatable-reset>Reset</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div>
                        <a class="btn btn-light ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" id="islemler">
                          <i class="fs-3 bi bi-gear-fill p-0"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6" data-kt-menu="true">
                          <div class="menu-item px-5">
                            <div class="menu-content text-muted pb-2 px-5 fs-7 text-uppercase">Actions</div>
                          </div>
                          <? if((segment[2] == "deposit" && edit_transaction_deposit === true) || segment[2] == "withdraw" && edit_transaction_withdraw === true): ?>
                          <div class="menu-item px-3">
                            <div class="menu-content px-3">
                              <label class="form-check form-switch form-check-custom form-check-solid">
                                <div class="form-check-label text-gray-800 fs-6 ps-2 me-3" for="notifications">Notifications</div>
                                <input class="form-check-input w-35px h-20px" type="checkbox" value="" name="notifications" <? if(notificationSound==1): ?>checked="checked"
                                <? endif; ?> id="notifications" />
                              </label>
                            </div>
                          </div>
                          <? endif ?>
                          <div class="menu-item px-3">
                            <div class="menu-content px-3">
                              <label class="form-check form-switch form-check-custom form-check-solid">
                                <div class="form-check-label text-gray-800 fs-6 ps-2 me-3" for="sync">Auto Refresh</div>
                                <input class="form-check-input w-35px h-20px" type="checkbox" value="" " name=" sync" checked="checked" id="sync" />
                              </label>
                            </div>
                          </div>
                          <? if((segment[2] == "deposit" && edit_transaction_deposit === true) || segment[2] == "withdraw" && edit_transaction_withdraw === true): ?>
                          <div class="separator my-3"></div>
                          <div class="menu-item px-5">
                            <div class="menu-content text-muted pb-2 px-5 fs-7 text-uppercase">
                              <? echo($pageTitle) ?>
                            </div>
                          </div>
                          <div class="menu-item ps-5" id="reject-all-button">
                            <a class="menu-link text-danger ps-5">Reject pending transactions</a>
                          </div>
                          <? endif ?>
                        </div>
                      </div>
                      <button type="button" class="btn btn-light" id="refresh">
                        <span class="svg-icon svg-icon-2 m-0">
                          <i class="fs-2 bi bi-arrow-repeat p-0"></i>
                        </span>
                      </button>
                      <button type="button" class="btn btn-light" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" id="export">
                        <i class="fs-3 bi bi-box-arrow-down p-0"></i>
                      </button>
                      <div id="datatableExport" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true"></div>
                    </div>
                  </div>
                </div>
                <div class="card-body pt-0 px-7">
                  <div class="table-responsive">
                    <table class="table table-striped table-row-bordered align-middle dataTable fs-6 gy-3" id="datatable_content">
                      <thead>
                        <? if(segment[2] === "deposit"): ?>
                        <?php require appViewPath() . 'transaction/include/tableHeadDeposit.php' ?>
                        <? else: ?>
                        <?php require appViewPath() . 'transaction/include/tableHeadWithdraw.php' ?>
                        <? endif; ?>
                      </thead>
                      <tbody class="fw-semibold text-gray-700"></tbody>
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
    <?php require appViewPath().'transaction/modal/inspect.php' ?>
    <?php require appViewPath().'transaction/modal/accounts.php' ?>
    <?php require appViewPath().'transaction/modal/transaction.php' ?>
    <?php require appViewPath().'layout/footer/footer.php' ?>