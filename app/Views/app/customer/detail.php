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
                <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1" data-account-type>Customer Profile</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold fs-base my-1">
                  <li class="breadcrumb-item text-muted">
                    <a href="dashboard" class="text-muted">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item text-muted">
                    <a href="customer/index" class="text-muted">Customers</a>
                  </li>
                  <li class="breadcrumb-item text-dark"><?=$customer->gamer_name ?></li>
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
              <div class="d-flex flex-column flex-xl-row">
                <div class="flex-column flex-lg-row-auto w-100 w-xl-300px mb-10">
                  <div class="card border mb-5 mb-xl-8">
                    <div class="card-body pt-15">
                      <div class="d-flex flex-center flex-column mb-5">
                        <div class="symbol symbol-100px symbol-circle mb-7">
                          <img src="<?=assetsPath() ?>/media/avatar.png" alt="image" />
                        </div>
                        <div class="fs-3 text-gray-800 fw-bold mb-1"><?=$customer->gamer_name ?></div>
                        <div class="fs-5 fw-semibold text-muted mb-6"><?=$customer->gamer_nick ?></div>
                        <div class="d-flex flex-wrap flex-center">
                          <div class="border border-gray-300 border-dashed rounded py-3 px-2 mb-3">
                            <div class="fs-4 fw-bold text-center text-gray-700">
                              <span class="w-75px"><?=$customer->totalDepositProcess ?></span>
                            </div>
                            <div class="fw-semibold text-muted text-center">Deposit</div>
                          </div>
                          <div class="border border-gray-300 border-dashed rounded py-3 px-2 mx-2 mb-3">
                            <div class="fs-4 fw-bold text-center text-gray-700">
                              <span class="w-50px"><?=$customer->totalWithdrawProcess ?></span>
                            </div>
                            <div class="fw-semibold text-muted ">Withdraw</div>
                          </div>
                          <div class="border border-gray-300 border-dashed rounded py-3 px-2 mb-3">
                            <div class="fs-4 fw-bold text-center text-gray-700">
                              <span class="w-50px"><?=$customer->totalRejectProcess ?></span>
                            </div>
                            <div class="fw-semibold text-muted text-center">Rejected</div>
                          </div>
                        </div>
                      </div>
                      <div class="d-flex flex-stack fs-4 py-3">
                        <div class="fw-bold">Details</div>
                        <? if($customer->isVip=="on"): ?>
                        <div class="badge badge-lg badge-light-danger d-inline">VIP User</div>
                        <? endif; ?>
                        <? if($customer->isVip=="0"): ?>
                        <div class="badge badge-lg badge-light-primary d-inline">Basic User</div>
                        <? endif; ?>
                      </div>
                      <div class="separator separator-dashed my-3"></div>
                      <div class="mt-5">
                        <div class="d-flex flex-stack">
                          <div class="fw-bold">User ID</div>
                          <div class="fw-bold text-gray-700 fs-7"><?=$customer->gamer_site_id ?></div>
                        </div>
                        <div class="d-flex flex-stack my-5">
                          <div class="fw-bold">Firm</div>
                          <div class="text-gray-700 badge badge-light-dark fs-7"><?=$customer->clientName ?></div>
                        </div>
                        <div class="d-flex flex-stack my-5">
                          <div class="fw-bold">First Transaction</div>
                          <div class="fw-bold text-gray-700 fs-7"><?= $customer->firstProcess == "" ? "No transaction" : $customer->firstProcess ?></div>
                        </div>
                        <div class="d-flex flex-stack">
                          <div class="fw-bold">Last Transaction</div>
                          <div class="fw-bold text-gray-700 fs-7"><?= $customer->lastProcess == "" ? "No transaction" : $customer->lastProcess ?></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card border mb-5 mb-xl-8">
                    <div class="card-header border-0">
                      <div class="card-title">
                        <h3 class="fw-bold m-0">Permissions</h3>
                      </div>
                    </div>
                    <div class="card-body pt-2">
                      <div class="py-2">
                        <div class="d-flex flex-stack">
                          <div class="d-flex">
                            <div class="svg-icon svg-icon-muted svg-icon-2qx me-4">
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor" /></svg>
                            </div>
                            <div class="d-flex flex-column">
                              <span class="fs-5 text-dark fw-bold pt-1">VIP</span>
                            </div>
                          </div>
                          <div class="d-flex justify-content-end">
                            <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                              <input class="form-check-input" type="checkbox" role="switch" id="isVip" data-set="switch" data-id="<?=$customer->id ?>" <?= edit_customer !== true ? "disabled" : null; ?> name="isVip" <? if($customer->isVip=="on") echo "checked" ?>>
                              <span class="form-check-label fw-semibold text-muted"></span>
                            </label>
                          </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="d-flex flex-stack">
                          <div class="d-flex">
                            <div class="svg-icon svg-icon-muted svg-icon-2qx me-4">
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.3" d="M11 13H7C6.4 13 6 12.6 6 12C6 11.4 6.4 11 7 11H11V13ZM17 11H13V13H17C17.6 13 18 12.6 18 12C18 11.4 17.6 11 17 11Z" fill="currentColor" /><path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM17 11H13V7C13 6.4 12.6 6 12 6C11.4 6 11 6.4 11 7V11H7C6.4 11 6 11.4 6 12C6 12.6 6.4 13 7 13H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V13H17C17.6 13 18 12.6 18 12C18 11.4 17.6 11 17 11Z" fill="currentColor" /></svg>
                            </div>
                            <div class="d-flex flex-column">
                              <span class="fs-5 text-dark fw-bold">Deposit</span>
                            </div>
                          </div>
                          <div class="d-flex justify-content-end">
                            <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                              <input class="form-check-input" type="checkbox" role="switch" id="deposit" data-set="switch" data-id="<?=$customer->id ?>" <?= edit_customer !== true ? "disabled" : null; ?> name="deposit" <? if($customer->deposit=="on") echo "checked" ?>>
                              <span class="form-check-label fw-semibold text-muted"></span>
                            </label>
                          </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="d-flex flex-stack">
                          <div class="d-flex">
                            <div class="svg-icon svg-icon-muted svg-icon-2qx me-4">
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM18 12C18 11.4 17.6 11 17 11H7C6.4 11 6 11.4 6 12C6 12.6 6.4 13 7 13H17C17.6 13 18 12.6 18 12Z" fill="currentColor" /></svg>
                            </div>
                            <div class="d-flex flex-column">
                              <span class="fs-5 text-dark fw-bold">Withdraw</span>
                            </div>
                          </div>
                          <div class="d-flex justify-content-end">
                            <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                              <input class="form-check-input" type="checkbox" role="switch" id="withdraw" data-set="switch" <?= edit_customer !== true ? "disabled" : null; ?> data-id="<?=$customer->id ?>" name="withdraw" <? if($customer->withdraw=="on") echo "checked" ?>>
                              <span class="form-check-label fw-semibold text-muted"></span>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="flex-lg-row-fluid ms-lg-15">
                  <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                    <li class="nav-item">
                      <a class="nav-link text-active-dark border-hover-dark border-active-dark pb-4 active" data-bs-toggle="tab" href="#kt_customer_view_overview_tab">Overview</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">
                      <div class="row mb-6">
                        <div class="col-12 col-xl-6 mb-6 mb-xl-0">
                          <div class="card border h-100">
                            <div class="card-header border-0">
                              <div class="card-title">
                                <h2>Summary</h2>
                              </div>
                            </div>
                            <div class="card-body py-0">
                              <div class="fs-5 fw-semibold text-gray-500 mb-4">Sum of all the transactions customer made</div>
                              <div class="d-flex flex-wrap flex-stack mb-5">
                                <div class="d-flex flex-wrap">
                                  <div class="border border-dashed border-gray-300 rounded my-3 p-4 me-6">
                                    <span class="fs-1 fw-bold text-gray-800 lh-1">
                                      <span data-kt-countup="true" data-kt-countup-value="<?=number_format($customer->totalDeposit,2) ?>" data-kt-countup-prefix="₺">0</span>
                                    </span>
                                    <span class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">Total Deposit</span>
                                  </div>
                                  <div class="border border-dashed border-gray-300 rounded my-3 p-4 me-6">
                                    <span class="fs-1 fw-bold text-gray-800 lh-1">
                                      <span class="" data-kt-countup="true" data-kt-countup-value="<?=number_format($customer->totalWithdraw,2) ?>" data-kt-countup-prefix="₺">0</span>
                                    </span>
                                    <span class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">Total Withdraw</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-xl-6">
                          <div class="card border h-100">
                            <div class="card-header border-0">
                              <div class="card-title">
                                <h2>Customer Note</h2>
                              </div>
                              <div class="card-toolbar">
                                <? if(edit_customer === true): ?>
                                <button type="button" class="btn btn-sm btn-flex btn-light-primary" id="customerNoteSave">
                                  <span class="svg-icon svg-icon-3">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.89557 13.4982L7.79487 11.2651C7.26967 10.7068 6.38251 10.7068 5.85731 11.2651C5.37559 11.7772 5.37559 12.5757 5.85731 13.0878L9.74989 17.2257C10.1448 17.6455 10.8118 17.6455 11.2066 17.2257L18.1427 9.85252C18.6244 9.34044 18.6244 8.54191 18.1427 8.02984C17.6175 7.47154 16.7303 7.47154 16.2051 8.02984L11.061 13.4982C10.7451 13.834 10.2115 13.834 9.89557 13.4982Z" fill="currentColor" /></svg>
                                  </span>
                                  Save
                                </button>
                                <? endif ?>
                              </div>
                            </div>
                            <div class="card-body py-0">
                              <div class="fs-5 fw-semibold text-gray-500 mb-3">Notes about the customer:</div>
                              <div class="row d-flex min-h-75 pb-5">
                                <textarea class="form-control form-control-solid rounded-3" style="resize: none;" id="customerNote" spellcheck="false" <?= edit_customer !== true ? "disabled" : null; ?>><?=$customer->note ?></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card border">
                        <div class="card-header border-0 pt-6">
                          <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                              <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" /><path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" /></svg>
                              </span>
                              <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid border border-1 w-225px ps-15" placeholder="Search transaction" />
                            </div>
                          </div>
                          <div class="card-toolbar">
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                              <input class="form-control form-control-solid border border-1 mw-225px me-3" placeholder="Select date range" value="<?=date("Y-m-d") ?>" name="transactionDate" id="transactionDate" />
                              <button type="button" class="btn btn-light me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <span class="svg-icon svg-icon-2 m-0">
                                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor" /></svg>
                                </span>
                              </button>
                              <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                                <div class="px-7 py-5">
                                  <div class="fs-5 text-dark fw-bold">Filter Options</div>
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
                                        <option value="cross">Cross System</option>
                                        <option value="match">Matching System</option>
                                        <option value="pos">Virtual POS</option>
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
                                    <button type="reset" class="btn btn-sm btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset" app-onclick-datatable-reset>Reset</button>
                                    <button type="submit" class="btn btn-sm btn-primary fw-semibold px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="filter" app-onclick-datatable-reload>Apply</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="card-toolbar">
                              <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <span class="svg-icon svg-icon-2 m-0">
                                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="1" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor" /><path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="currentColor" /><path opacity="1" d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="currentColor" /></svg>
                                </span>
                              </button>
                              <div id="datatableExport" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true"></div>
                            </div>
                          </div>
                        </div>
                        <style>div.dataTables_length + div.dataTables_info { font-size: 10px !important;}</style>
                        <div class="card-body pt-0">
                          <div id="kt_customers_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="table-responsive">
                              <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="kt_customers_table">
                                <div class="table-responsive">
                                  <table class="table table-responsive table-row-dashed align-middle dataTable fs-6 gy-4" id="customerTransactionTable">
                                    <thead>
                                      <tr class="text-gray-600 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-100px text-center">Date</th>
                                        <th class="min-w-80px text-center ps-0">TXID</th>
                                        <th class="min-w-70px text-center ps-0">Account</th>
                                        <th class="min-w-70px text-center ps-0">Method</th>
                                        <th class="min-w-70px text-center ps-0">Amount</th>
                                        <th class="min-w-100px text-center ps-0">Status</th>
                                        <th class="min-w-70px text-center ps-0">Actions</th>
                                      </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600"></tbody>
                                  </table>
                                </div>
                            </div>
                          </div>
                        </div>
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
      <?php require appViewPath().'layout/footer/footer.php' ?>