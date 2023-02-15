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

              <div class="row">
                <div class="col-12">
                  <div class="card card-bordered card-flush mb-5">
                    <div class="card-header py-5 py-sm-0">
                      <div class="card-title w-100 w-sm-auto">
                        <h3 class="fw-bold w-100 d-flex flex-center flex-sm-start">Monthly Reports</h3>
                      </div>
                      <div class="card-toolbar d-flex flex-center flex-sm-nowrap w-100 w-sm-auto">
                        <div class="d-flex py-5 gap-3">
                          <select id="month" class="form-select form-select-solid border" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-125px">
                            <?
                              for ($i = 1; $i <= 12; $i++) {
                                $month = date('F', mktime(0, 0, 0, $i, 1, date('Y')));
                                $selected = date('m') == $i ? " selected" : null;
                                echo '<option value="' . $i . '"' . $selected . '>' . $month . '</option>';
                              }
                            ?>
                          </select>

                          <select id="year" class="form-select form-select-solid border" data-control="select2" data-hide-search="true">
                            <option>2023</option>
                            <option>2024</option>
                            <option>2025</option>
                            <option>2026</option>
                            <option>2027</option>
                          </select>

                          <select id="firms" class="form-select form-select-solid border" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px">
                            <option value="0">All Firms</option>
                            <?php foreach ($userFirms as $firm) {
                              if ($firm['status'] == 'on') {
                                $selected = (count($userFirms) === 1 && $userFirms[0]['id'] == $firm['id']) ? " selected" : "";
                                echo "<option value='" . $firm['id'] . "'" . $selected . ">" . $firm['name'] . "</option>";
                              }
                            } ?>
                            <? if(root): ?>
                            <optgroup label="Inactive">
                              <?php foreach ($userFirms as $firm) {
                                if ($firm['status'] == 0) {
                                  $selected = (count($userFirms) === 1 && $userFirms[0]['id'] == $firm['id']) ? " selected" : "";
                                  echo "<option value='" . $firm['id'] . "'" . $selected . ">" . $firm['name'] . "</option>";
                                }
                              } ?>
                            </optgroup>
                            <? endif; ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="first-row" class="card card-bordered card-flush mb-5">
                    <div class="card-body d-flex justify-content-between flex-column pb-0 px-0 pt-1">
                      <div class="d-flex flex-wrap flex-center gap-5 w-100 px-9 py-5 my-5 mb-sm-0 mt-sm-5">
                        <div class="me-md-2">
                          <div class="fs-6 fw-semibold text-gray-600 w-100 text-center mb-1">Total Deposits</div>
                          <div class="d-flex mb-2">
                            <span class="fs-4 fw-semibold text-gray-600 me-1">₺</span>
                            <span id="totalDeposits" class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2"><?= number_format($summary['deposit'], 2) ?></span>
                          </div>
                        </div>
                        <div class="ps-md-10 pe-md-7 me-md-5">
                          <div class="fs-6 fw-semibold text-gray-600 w-100 text-center mb-1">Total Withdrawals</div>
                          <div class="d-flex mb-2">
                            <span class="fs-4 fw-semibold text-gray-600 me-1">₺</span>
                            <span id="totalWithdrawals" class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2"><?= number_format($summary['withdraw'], 2) ?></span>
                          </div>
                        </div>
                        <div class="m-0">
                          <div class="fs-6 fw-semibold text-gray-600 w-100 text-center mb-1">Average Daily Deposit</div>
                          <div class="d-flex align-items-center mb-2">
                            <span class="fs-4 fw-semibold text-gray-600 align-self-start me-1">₺</span>
                            <span id="dailyAverage" class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2"><?= number_format($summary['average'], 2) ?></span>
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

              <? if(partner): ?>
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

    <? if(count($monthlyDeposit) > 0 || count($monthlyWithdraw) > 0): ?>
    <script>
      const depositMonthly = <?= json_encode($monthlyDeposit) ?>;
      const withdrawMonthly = <?= json_encode($monthlyWithdraw) ?>;
    </script>
    <? endif; ?>

    <?php require appViewPath().'layout/footer/footer.php' ?>