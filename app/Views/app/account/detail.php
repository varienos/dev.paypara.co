<?php require appViewPath() . 'layout/header/header.php' ?>

<body id="kt_body" class="sidebar-disabled">
  <?php require appViewPath() . 'partials/theme-mode/_init.php' ?>
  <div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
      <?php require appViewPath() . 'layout/aside/_base.php' ?>
      <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
          <div id="kt_header" class="header">
            <div class="container d-flex flex-stack flex-wrap gap-2" id="kt_header_container">
              <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-5 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">Edit Account</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold fs-base my-1">
                  <li class="breadcrumb-item text-muted">
                    <a href="dashboard" class="text-muted">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item text-muted">Accounts</li>
                  <? if ($update->dataType == 1): ?>
                  <li class="breadcrumb-item text-muted"><a href="account/index/1" class="text-muted">Papara Accounts</a></li>
                  <? endif; ?>
                  <? if ($update->dataType == 2): ?>
                  <li class="breadcrumb-item text-muted"><a href="account/index/2" class="text-muted">Matching Accounts</a></li>
                  <? endif; ?>
                  <? if ($update->dataType == 3): ?>
                  <li class="breadcrumb-item text-muted"><a href="account/index/3" class="text-muted">Bank Accounts</a></li>
                  <? endif; ?>
                  <li class="breadcrumb-item text-dark"><?=$update->account_name?></li>
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
              <?php require appViewPath() . 'layout/header/__topbar.php' ?>
            </div>
          </div>
          <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="container-xxl" id="kt_content_container">
              <div class="d-flex flex-column flex-xl-row">
                <div class="flex-column flex-lg-row-auto w-100 w-xl-300px mb-10">
                  <div class="card card-flush border pt-4 mb-4">
                    <div class="card-header">
                      <div class="card-title flex-column border-1 border-bottom border-secondary w-100">
                        <h3 class="w-100 text-center text-gray-800 my-3"><?=$update->account_name?></h3>
                        <h5 class="w-100 text-center text-gray-600 mb-5"><?=$update->account_number?></h5>
                      </div>
                    </div>
                    <div class="card-body py-0">
                      <div class="d-flex flex-column gap-7">
                        <div class="mb-10">
                          <table class="table fs-6 fw-semibold gs-0 mb-2">
                            <tbody>
                              <tr>
                                <td class="text-gray-800">Account ID:</td>
                                <td class="text-gray-800">#<?=$id?></td>
                              </tr>
                              <tr>
                                <td class="text-gray-800">Created At:</td>
                                <td class="text-gray-800"><?=$update->createTime?></td>
                              </tr>
                              <tr>
                                <td class="text-gray-800">First TX:</td>
                                <td class="text-gray-800"><?=$update->firstProcess == "" ? "none" : $update->firstProcess ?> </td>
                              </tr>
                              <tr>
                                <td class="text-gray-800">Last TX:</td>
                                <td class="text-gray-800"><?=$update->lastProcess == "" ? "none" : $update->lastProcess ?> </td>
                              </tr>
                              <tr>
                                <td class="text-gray-800">Type:</td>
                                <td>
                                  <? if ($update->dataType == 1): ?>
                                  <span class="badge badge-light-danger">Papara Account</span>
                                  <? elseif ($update->dataType == 2): ?>
                                  <span class="badge badge-light-info">Matching Account</span>
                                  <? elseif ($update->dataType == 3): ?>
                                  <span class="badge badge-light-dark">Bank Account</span>
                                  <? endif; ?>
                                </td>
                              </tr>
                              <tr>
                                <td class="text-gray-800">Status:</td>
                                <td>
                                  <div class="form-check form-switch form-switch-sm form-check-success form-check-custom form-check-solid">
                                    <input class="form-check-input h-20px w-45px" type="checkbox" data-set="switch" value="1" <? if ($update->status == "on"): ?>checked="checked"
                                    <? endif ?>>
                                    <label class="form-check-label text-gray-800"></label>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card card-flush border py-4 flex-row-fluid">
                    <div class="card-header">
                      <div class="card-title">
                        <h2>Deposit Summary</h2>
                      </div>
                    </div>
                    <div class="card-body py-0">
                      <div class="table-responsive">
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-200px">
                          <tbody class="fw-semibold text-gray-600">
                            <tr>
                              <td class="text-muted">
                                <div class="d-flex align-items-center">
                                  <i class="bi bi-person fs-2x me-2"></i>Clients
                                </div>
                              </td>
                              <td class="fw-bold text-end"> <?=$update->totalCustomer == 0 ? "None" : $update->totalCustomer . " client" ?> </td>
                            </tr>
                            <tr>
                              <td class="text-muted">
                                <div class="d-flex align-items-center">
                                  <i class="bi bi-arrow-repeat fs-2x me-2"></i>Transactions
                                </div>
                              </td>
                              <td class="fw-bold text-end"><?=$update->totalProcess == 0 ? "None" : $update->totalProcess . " total" ?></td>
                            </tr>
                            <tr>
                              <td class="text-muted">
                                <div class="d-flex align-items-center">
                                  <i class="bi bi-cash-stack fs-2x me-2"></i>Deposits
                                </div>
                              </td>
                              <td class="fw-bold text-end"> <?=$update->totalDeposit == "" ? "None" : "₺" . number_format($update->totalDeposit, 2) ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="flex-lg-row-fluid ms-xl-15">
                  <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                    <li class="nav-item">
                      <a class="nav-link text-active-dark border-hover-dark border-active-dark pb-4 active" data-bs-toggle="tab" href="#account_information">Account Information</a>
                    </li>
                    <? if ($update->dataType == 2): ?>
                    <li class="nav-item">
                      <a class="nav-link text-active-dark border-hover-dark border-active-dark pb-4" data-bs-toggle="tab" href="#matched-clients">Matching Settings</a>
                    </li>
                    <? endif; ?>
                    <li class="nav-item">
                      <a class="nav-link text-active-dark border-hover-dark border-active-dark pb-4" data-bs-toggle="tab" href="#payment-clients">Transaction History</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="account_information" role="tabpanel">
                      <form class="form" action="javascript:" id="modalForm" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="dataType" value="<?=$update->dataType ?>" />
                        <input type="hidden" name="id" value="<?=$id ?>" />
                        <input type="hidden" name="status" value="<?=$update->status ?>" />
                        <div class="card card-flush border py-4">
                          <div class="card-body pt-0">
                            <div class="d-flex flex-column gap-5 gap-md-7">
                              <div class="d-flex flex-column flex-xxl-row gap-5 mt-5">
                                <div class="flex-row-fluid">
                                  <label class="required form-label">Name Surname</label>
                                  <input class="form-control" placeholder="" value="<?=$update->account_name?>" name="account_name" id="account_name" maxlength="40" />
                                </div>
                                <div class="flex-row-fluid">
                                  <label class="required form-label">
                                    <? if ($update->dataType == 3){ ?>IBAN Number
                                    <? } else { ?>Account Number
                                    <? } ?>
                                  </label>
                                  <?php if ($update->dataType == 3) { ?>
                                  <input class="form-control" value="<?=$update->account_number?>" name="account_number" id="account_number" maxlength="32" />
                                  <?php } else { ?>
                                  <input class="form-control" value="<?=$update->account_number?>" name="account_number" id="account_number" maxlength="10" />
                                  <?php } ?>
                                </div>
                              </div>
                              <? if ($update->dataType == 1): ?>
                              <div class="row d-flex flex-column flex-xxl-row">
                                <div class="col">
                                  <label class="form-label">Monthy Transaction Limit</label>
                                  <div class="input-group">
                                    <input type="text" class="form-control" value="<?=$update->limitProcess?>" name="limitProcess" id="limitProcess" placeholder="Total" max="1000" maxlength="4" />
                                    <span class="input-group-text">transactions</span>
                                  </div>
                                  <div class="text-gray-600 fs-7 mt-2">Account will be disabled at the stated transaction limit.</div>
                                </div>
                                <div class="col mt-5 mt-xxl-0">
                                  <label class="form-label">Monthly Deposit Limit</label>
                                  <div class="input-group">
                                    <span class="input-group-text">₺</span>
                                    <input type="text" class="form-control" value="<?=$update->limitDeposit?>" name="limitDeposit" id="limitDeposit" placeholder="Amount" max="1000000" maxlength="7" />
                                  </div>
                                  <div class="text-gray-600 fs-7 mt-2">Account will be disabled at the stated deposit limit.</div>
                                </div>
                              </div>
                              <div class="flex-row-fluid">
                                <label class="form-label">Active Firms</label>
                                <select class="form-select form-select form-select-lg" data-control="select2" data-close-on-select="false" data-placeholder="All firms" name="perm_site[]" data-allow-clear="true" multiple="multiple">
                                  <option></option>
                                  <? $site = explode(",", $update->perm_site);
                                  foreach ($siteSelect as $row) {
                                    $selected = in_array($row->id, $site) ? "selected" : null; ?>
                                  <option value="<?=$row->id?>" <?=$selected ?>> <?=$row->site_name ?></option>
                                  <?
                                  } ?>
                                </select>
                              </div>
                              <? endif; ?>
                              <? if ($update->dataType == 3): ?>
                              <div class="d-flex flex-column gap-5 gap-md-7">
                                <div class="row d-flex flex-column flex-xxl-row">
                                  <div class="col">
                                    <label class="form-label">Bank</label>
                                    <select class="form-select form-select-lg" name="bank_id" data-control="select2" data-placeholder="Select bank" required>
                                      <option></option>
                                      <? foreach (bankArray() as $key => $value) { ?>
                                      <option value="<?=$key ?>" <?=($update->bank_id == $key ? "selected" : null) ?>><?=$value ?></option>
                                      <? } ?>
                                    </select>
                                    <div class="text-gray-600 fs-7 mt-2">Bank which account belong to.</div>
                                  </div>
                                  <div class="col mt-5 mt-xxl-0">
                                    <label class="form-label">Monthly Deposit Limit</label>
                                    <div class="input-group">
                                      <span class="input-group-text">₺</span>
                                      <input type="text" class="form-control" value="<?=$update->limitDeposit?>" name="limitDeposit" id="limitDeposit" placeholder="Amount" max="1000000" maxlength="7" />
                                    </div>
                                    <div class="text-gray-600 fs-7 mt-2">Account will be disabled at the stated deposit limit.</div>
                                  </div>
                                </div>
                                <div class="row d-flex flex-column flex-xxl-row">
                                  <div class="col">
                                    <label class="form-label">Monthly Transaction Limit</label>
                                    <div class="input-group">
                                      <input type="text" class="form-control" value="<?=$update->limitProcess?>" name="limitProcess" id="limitProcess" placeholder="Total" max="1000" maxlength="4" />
                                      <span class="input-group-text">işlem</span>
                                    </div>
                                    <div class="text-gray-600 fs-7 mt-2">Account will be disabled at the stated transaction limit.</div>
                                  </div>
                                  <div class="col mt-5 mt-xxl-0">
                                    <label class="form-label">Active Firms</label>
                                    <select class="form-select form-select-lg" data-control="select2" data-close-on-select="false" data-placeholder="All firms" name="perm_site[]" data-allow-clear="true" multiple="multiple">
                                      <option></option>
                                      <? $site = explode(",", $update->perm_site);
                                      foreach ($siteSelect as $row) {
                                        $selected = in_array($row->id, $site) ? "selected" : null; ?>
                                      <option value="<?=$row->id?>" <?=$selected ?>> <?=$row->site_name ?></option>
                                      <?
                                      } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <? endif; ?>
                              <? if ($update->dataType == 2): ?>
                              <div class="d-flex flex-column gap-5 gap-md-7">
                                <div class="row d-flex flex-column flex-xxl-row">
                                  <div class="col">
                                    <label class="form-label">Monthly Transaction Limit</label>
                                    <div class="input-group">
                                      <input type="text" class="form-control" value="<?=$update->limitProcess?>" name="limitProcess" id="limitProcess" placeholder="Total" max="1000" maxlength="4" />
                                      <span class="input-group-text">transactions</span>
                                    </div>
                                    <div class="text-gray-600 fs-7 mt-2">Account will be disabled at the stated transaction limit.</div>
                                  </div>
                                  <div class="col mt-5 mt-xxl-0">
                                    <label class="form-label">Monthly Deposit Limit</label>
                                    <div class="input-group">
                                      <span class="input-group-text">₺</span>
                                      <input type="text" class="form-control" value="<?=$update->limitDeposit?>" name="limitDeposit" id="limitDeposit" placeholder="Amount" max="1000000" maxlength="7" />
                                    </div>
                                    <div class="text-gray-600 fs-7 mt-2">Account will be disabled at the stated deposit limit.</div>
                                  </div>
                                </div>
                                <div class="d-flex flex-column flex-xxl-row gap-5">
                                  <div class="flex-row-fluid">
                                    <label class="form-label">Match Limit</label>
                                    <input type="text" class="form-control" name="match_limit" value="<?=$update->match_limit?>" />
                                    <div class="text-gray-600 fs-7 mt-2">How many different clients the account should be shared with?</div>
                                  </div>
                                  <div class="flex-row-fluid">
                                    <label class="form-label">Active Firms</label>
                                    <select class="form-select form-select-lg" data-control="select2" data-close-on-select="false" data-placeholder="All firms" name="perm_site[]" data-allow-clear="true" multiple="multiple">
                                      <option></option>
                                      <? $site = explode(",", $update->perm_site);
                                        foreach ($siteSelect as $row){
                                          $selected = in_array($row->id, $site) ? "selected" : null; ?>
                                      <option value="<?=$row->id?>" <?=$selected ?>> <?=$row->site_name ?></option>
                                      <?
                                        } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <?endif; ?>
                            </div>
                          </div>
                          <div class="card-footer pt-0 pe-9 pb-5 pl-0">
                            <div class="d-flex justify-content-end">
                              <button type="button" id="formReset" onclick="this.form.reset();" class="btn btn-light min-w-125px me-5">Clear</button>
                              <button type="submit" class="btn btn-light-primary min-w-125px">Save</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <? if ($update->dataType == 2): ?>
                    <div class="tab-pane fade" id="matched-clients" role="tabpanel">
                      <div class="card card-flush border py-4 mt-5">
                        <div class="card-header">
                          <div class="card-title">
                            <h2>Active Matchings</h2>
                            <span class="badge badge badge-circle badge-light-dark ms-2 mb-5"><?=count((array)$listMatch) ?></span>
                          </div>
                          <div class="card-toolbar">
                            <div class="d-flex flex-shrink-0 align-items-center justify-content-end">
                              <div class="">
                                <span class="svg-icon svg-icon-1 position-absolute ms-4 mt-3">
                                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                  </svg>
                                </span>
                                <input type="text" data-kt-ecommerce-edit-order-filter="search" onfocusout="$.varien.account.detail.customerQueryFocusOut()" onkeyup="$.varien.account.detail.customerQuery(this.value,<?=$id ?>)" id="customerQueryInput" name="gamers_ids" value="<?=$update->gamers_ids ?>" class="form-control form-control-solid border w-100 ps-14" placeholder="Add new match" />
                                <div id="customerQuery" style="display:none">
                                  <ul></ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card-body py-0">
                          <div class="d-flex flex-column gap-10">
                            <div class="table-responsive">
                              <table class="table overflow-auto align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_edit_order_product_table">
                                <thead>
                                  <tr class="text-center text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-50px">User ID</th>
                                    <th class="min-w-100px text-start">User Info</th>
                                    <th class="min-w-50px">Firm</th>
                                    <th class="min-w-75px">Total TXN</th>
                                    <th class="min-w-75px">Deposited</th>
                                    <th class="min-w-75px">Last TXN</th>
                                    <th class="min-w-50px text-end pe-5">Actions</th>
                                  </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600 text-center" id="listMatch"></tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card card-flush border py-4 mt-5">
                        <div class="card-header">
                          <div class="card-title">
                            <h2 class="text-muted">Previous Matchings</h2>
                          </div>
                        </div>
                        <div class="card-body py-0">
                          <div class="d-flex flex-column gap-10">
                            <div class="table-responsive">
                              <table class="table overflow-auto align-middle table-row-dashed fs-6 gy-5" id="listDisableMatch">
                                <thead>
                                  <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-50px text-center">User ID</th>
                                    <th class="min-w-100px text-start">User Info</th>
                                    <th class="min-w-50px text-center">Firm</th>
                                    <th class="min-w-75px text-center">Total TXN</th>
                                    <th class="min-w-75px text-center">Deposited</th>
                                    <th class="min-w-100px text-center">Last TXN</th>
                                  </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-400"></tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?endif; ?>
                    <div class="tab-pane fade" id="payment-clients" role="tabpanel">
                      <div class="card border">
                        <div class="card-header border-0 pt-6">
                          <div class="card-title w-100 w-md-auto">
                            <div class="d-flex align-items-center w-100 my-1">
                              <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                  <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                </svg>
                              </span>
                              <input type="text" data-kt-customer-table-filter="search" id="search" class="form-control form-control-solid border border-1 w-100 w-md-200px ps-15" placeholder="Search transaction" />
                            </div>
                          </div>
                          <div class="card-toolbar w-100 w-md-auto flex-center flex-md-end gap-3">
                            <div class="d-flex gap-3">
                              <input class="form-control form-control-solid border border-1 mw-225px" placeholder="Select date range" value="<?=date("Y-m-d") ?>" name="transactionDate" id="transactionDate" />
                              <button type="button" class="btn btn-light" id="filtre" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="fs-3 bi bi-funnel-fill p-0"></i>
                              </button>
                              <div class="menu menu-sub menu-sub-dropdown w-300px" data-kt-menu="true">
                                <div class="px-7 py-5">
                                  <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                </div>
                                <div class="separator border-gray-200"></div>
                                <div class="px-7 py-5" data-kt-user-table-filter="form">
                                  <div class="row mb-3">
                                    <div class="col-4 d-flex align-items-center">
                                      <label class="form-label fs-6 fw-semibold text-end w-100 m-0">Firm:</label>
                                    </div>
                                    <div class="col">
                                      <select class="form-select form-select-solid border border-1 fw-bold" name="siteId" id="siteId" data-kt-select2="true" data-placeholder="All" data-allow-clear="true" data-kt-user-table-filter="role" data-hide-search="true" app-onchange-datatable-reload>
                                        <option></option>
                                        <? $site = explode(",",$update->perm_site); foreach($siteSelect as $row){ ?>
                                        <option value="<?=$row->id ?>"> <?=$row->site_name ?></option>
                                        <? } ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <div class="col-4 d-flex align-items-center">
                                      <label class="form-label fs-6 fw-semibold text-end w-100 m-0">Status:</label>
                                    </div>
                                    <div class="col">
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
                              <div>
                                <button type="button" class="btn btn-light" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                  <i class="fs-3 bi bi-box-arrow-down p-0"></i>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-export data-kt-menu="true"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <style>
                        div.dataTables_length+div.dataTables_info {
                          font-size: 10px !important;
                        }
                        </style>
                        <div class="card-body pt-0">
                          <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-4 dataTable no-footer" id="accountTransactions">
                              <thead datatable-head>
                                <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                  <th class="min-w-150px text-center table-sort-desc">DATE</th>
                                  <th class="min-w-50px text-center table-sort-desc">TXID</th>
                                  <th class="min-w-50px text-center table-sort-desc">USER ID</th>
                                  <th class="min-w-55px text-center table-sort-desc">FIRM</th>
                                  <th class="min-w-150px text-center table-sort-desc">NAME SURNAME</th>
                                  <th class="min-w-85px text-center table-sort-desc">AMOUNT</th>
                                  <th class="min-w-50px text-center table-sort-desc">STATUS</th>
                                </tr>
                              </thead>
                              <tbody class="fw-semibold text-gray-600 text-center"></tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php require appViewPath() . 'layout/_footer.php' ?>
          </div>
        </div>
      </div>
      <?php require appViewPath() . 'layout/footer/footer.php' ?>