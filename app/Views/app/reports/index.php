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
                <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">Raporlar</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold fs-base my-1">
                  <li class="breadcrumb-item text-muted">
                    <a href="dashboard" class="text-muted">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item text-dark">Raporlar</li>
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

            <div class="row">
              <div class="col-12 col-md-4">
                <div class="card card-bordered mb-5">
                  <div class="card-body">
                    <h5 class="card-title fw-semibold text-gray-700 m-0 pb-3">Aylık Yatırım</h5>
                    <h1 class="fw-bold text-dark m-0">₺10.401.170,00</h1>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-4">
                <div class="card card-bordered mb-5">
                  <div class="card-body">
                    <h5 class="card-title fw-semibold text-gray-700 m-0 pb-3">Aylık Çekim</h5>
                    <h1 class="fw-bold text-dark m-0">₺4.160.468,00</h1>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-4">
                <div class="card card-bordered mb-5">
                  <div class="card-body">
                    <h5 class="card-title fw-semibold text-gray-700 m-0 pb-3">Günlük Ortalama Yatırım</h5>
                    <h1 class="fw-bold text-dark m-0">₺1.040.117,00</h1>
                  </div>
                </div>
              </div>
            </div>

            <div class="card card-flush">
              <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <div class="card-title">
                  <h3 class="fw-bold m-0">İşlem Özeti <small class="text-gray-700">(Demoya özel temsili veriler gösterilmektedir)</small></h3>
                </div>
                <div class="card-toolbar flex-row-fluid justify-content-end">
                  <!-- $("#kt_daterangepicker").daterangepicker(); -->
                  <input class="form-control form-control-solid w-100 mw-250px me-3" placeholder="Tarih aralığı seçin" id="kt_daterangepicker"/>
                  <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <span class="svg-icon svg-icon-2 m-0">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="1" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor"></rect><path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="currentColor"></path><path opacity="1" d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="currentColor"></path></svg>
                    </span>
                  </button>
                  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                    <div class="menu-item px-3">
                      <a href="javascript:;" class="menu-link px-3" data-export-type="copy">Copy to Clipboard</a>
                    </div>
                    <div class="menu-item px-3">
                      <a href="javascript:;" class="menu-link px-3" data-export-type="excel">Export as Excel</a>
                    </div>
                    <div class="menu-item px-3">
                      <a href="javascript:;" class="menu-link px-3" data-export-type="csv">Export as CSV</a>
                    </div>
                    <div class="menu-item px-3">
                      <a href="javascript:;" class="menu-link px-3" data-export-type="pdf">Export as PDF</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body pt-0">
                <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                  <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="kt_reports_table">
                      <thead>
                        <tr class="text-start text-gray-600 fw-bold fs-7 text-uppercase gs-0">
                          <th class="min-w-100px sorting">TARİH</th>
                          <th class="text-end min-w-75px sorting">ÇAPRAZ</th>
                          <th class="text-end min-w-100px sorting">BANKA</th>
                          <th class="text-end min-w-75px sorting">SANAL POS</th>
                          <th class="text-end min-w-75px sorting">PAPARA</th>
                          <th class="fw-bold text-gray-700 text-end min-w-75px sorting">TOP. YATIRIM</th>
                          <th class="fw-bold text-gray-700 text-end min-w-75px sorting">TOP. ÇEKİM</th>
                        </tr>
                      </thead>
                      <tbody class="fw-semibold text-gray-600">
                        <tr>
                          <td>01.10.2022</td>
                          <td class="text-end pe-0">₺86.239,00</td>
                          <td class="text-end pe-0">₺141.721,00</td>
                          <td class="text-end pe-0">₺36.121,00</td>
                          <td class="text-end pe-0">₺884.774,00</td>
                          <td class="fw-bold text-gray-700 text-end pe-0">₺1.148.855,00</td>
                          <td class="fw-bold text-gray-700 text-end">₺459.542,00</td>
                        </tr>
                        <tr>
                          <td>02.10.2022</td>
                          <td class="text-end pe-0">₺30.762,00</td>
                          <td class="text-end pe-0">₺182.041,00</td>
                          <td class="text-end pe-0">₺46.855,00</td>
                          <td class="text-end pe-0">₺609.732,00</td>
                          <td class="fw-bold text-gray-700 text-end pe-0">₺869.390,00</td>
                          <td class="fw-bold text-gray-700 text-end">₺347.756,00</td>
                        </tr>
                        <tr>
                          <td>03.10.2022</td>
                          <td class="text-end pe-0">₺41.093,00</td>
                          <td class="text-end pe-0">₺107.280,00</td>
                          <td class="text-end pe-0">₺34.780,00</td>
                          <td class="text-end pe-0">₺670.676,00</td>
                          <td class="fw-bold text-gray-700 text-end pe-0">₺853.829,00</td>
                          <td class="fw-bold text-gray-700 text-end">₺341.531,60</td>
                        </tr>
                        <tr>
                          <td>04.10.2022</td>
                          <td class="text-end pe-0">₺40.493,00</td>
                          <td class="text-end pe-0">₺130.508,00</td>
                          <td class="text-end pe-0">₺26.821,00</td>
                          <td class="text-end pe-0">₺888.473,00</td>
                          <td class="fw-bold text-gray-700 text-end pe-0">₺1.086.295,00</td>
                          <td class="fw-bold text-gray-700 text-end">₺434.518,00</td>
                        </tr>
                        <tr>
                          <td>05.10.2022</td>
                          <td class="text-end pe-0">₺37.560,00</td>
                          <td class="text-end pe-0">₺136.598,00</td>
                          <td class="text-end pe-0">₺43.023,00</td>
                          <td class="text-end pe-0">₺797.685,00</td>
                          <td class="fw-bold text-gray-700 text-end pe-0">₺1.014.866,00</td>
                          <td class="fw-bold text-gray-700 text-end">₺405.946,40</td>
                        </tr>
                        <tr>
                          <td>06.10.2022</td>
                          <td class="text-end pe-0">₺19.994,00</td>
                          <td class="text-end pe-0">₺141.374,00</td>
                          <td class="text-end pe-0">₺48.347,00</td>
                          <td class="text-end pe-0">₺933.216,00</td>
                          <td class="fw-bold text-gray-700 text-end pe-0">₺1.142.931,00</td>
                          <td class="fw-bold text-gray-700 text-end">₺457.172,40</td>
                        </tr>
                        <tr>
                          <td>07.10.2022</td>
                          <td class="text-end pe-0">₺14.161,00</td>
                          <td class="text-end pe-0">₺134.602,00</td>
                          <td class="text-end pe-0">₺48.830,00</td>
                          <td class="text-end pe-0">₺982.502,00</td>
                          <td class="fw-bold text-gray-700 text-end pe-0">₺1.180.095,00</td>
                          <td class="fw-bold text-gray-700 text-end">₺472.038,00</td>
                        </tr>
                        <tr>
                          <td>08.10.2022</td>
                          <td class="text-end pe-0">₺44.030,00</td>
                          <td class="text-end pe-0">₺165.728,00</td>
                          <td class="text-end pe-0">₺26.550,00</td>
                          <td class="text-end pe-0">₺877.939,00</td>
                          <td class="fw-bold text-gray-700 text-end pe-0">₺1.114.247,00</td>
                          <td class="fw-bold text-gray-700 text-end">₺445.698,80</td>
                        </tr>
                        <tr>
                          <td>09.10.2022</td>
                          <td class="text-end pe-0">₺13.408,00</td>
                          <td class="text-end pe-0">₺180.369,00</td>
                          <td class="text-end pe-0">₺40.589,00</td>
                          <td class="text-end pe-0">₺587.944,00</td>
                          <td class="fw-bold text-gray-700 text-end pe-0">₺822.310,00</td>
                          <td class="fw-bold text-gray-700 text-end">₺328.924,00</td>
                        </tr>
                        <tr>
                          <td>10.10.2022</td>
                          <td class="text-end pe-0">₺31.451,00</td>
                          <td class="text-end pe-0">₺127.790,00</td>
                          <td class="text-end pe-0">₺21.644,00</td>
                          <td class="text-end pe-0">₺987.467,00</td>
                          <td class="fw-bold text-gray-700 text-end pe-0">₺1.168.352,00</td>
                          <td class="fw-bold text-gray-700 text-end">₺467.340,80</td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <!-- JavaScript: https://preview.keenthemes.com/html/metronic/docs/general/datatables/advanced#footer-callback -->
                        <tr class="fw-bold text-gray-700 border-top">
                          <th>Toplam:</th>
                          <th class="text-end pe-0">₺359.191,00</th>
                          <th class="text-end pe-0">₺1.448.011,00</th>
                          <th class="text-end pe-0">₺373.560,00</th>
                          <th class="text-end pe-0">₺8.220.408,00</th>
                          <th class="text-end pe-0">₺10.401.170,00</th>
                          <th class="text-end pe-0">₺4.160.468,00</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                      <div class="dataTables_length" id="kt_reports_table_length">
                        <label>
                          <select name="kt_reports_table_length" aria-controls="kt_reports_table" class="form-select form-select-sm form-select-solid">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="31">31</option>
                          </select>
                        </label>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                      <div class="dataTables_paginate paging_simple_numbers" id="kt_reports_table_paginate">
                        <ul class="pagination">
                          <li class="paginate_button page-item previous disabled" id="kt_reports_table_previous">
                            <a href="javascript:;" aria-controls="kt_reports_table" tabindex="0" class="page-link"><i class="previous"></i></a>
                          </li>
                          <li class="paginate_button page-item active">
                            <a href="javascript:;" aria-controls="kt_reports_table" tabindex="0" class="page-link">1</a>
                          </li>
                          <li class="paginate_button page-item ">
                            <a href="javascript:;" aria-controls="kt_reports_table" tabindex="0" class="page-link">2</a>
                          </li>
                          <li class="paginate_button page-item ">
                            <a href="javascript:;" aria-controls="kt_reports_table" tabindex="0" class="page-link">3</a>
                          </li>
                          <li class="paginate_button page-item next" id="kt_reports_table_next">
                            <a href="javascript:;" aria-controls="kt_reports_table" tabindex="0" class="page-link"><i class="next"></i></a>
                          </li>
                        </ul>
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