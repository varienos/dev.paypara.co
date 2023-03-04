<div class="row g-5 d-flex justify-content-between mb-5">
  <div class="col-12 col-xl-9">
    <div class="card card-bordered card-flush h-100">
      <div class="card-header d-flex flex-column flex-sm-row border-bottom-2 py-0">
        <div class="card-title w-100 w-sm-auto flex-center flex-sm-start mt-5 mt-sm-0 mb-3 mb-sm-0">
          <h3 class="fw-bold">Statistics</h3>
        </div>
        <div class="card-toolbar mb-3 mb-sm-0">
          <div class="d-flex w-100 w-sm-auto">
            <div class="fs-6 fw-semibold text-gray-800 align-self-center m-0 me-3">Filter: </div>
            <select class="form-select form-select-solid form-select-sm w-100 w-sm-325px me-3" data-control="select2" data-hide-search="true">
              <optgroup label="Deposit">
                <option value="1" selected>List by highest deposit amounts</option>
                <option value="2">List by highest deposit counts</option>
                <option value="3">List by most rejected transactions</option>
              </optgroup>
              <optgroup label="Clients">
                <option value="4">List VIP's by deposit amounts</option>
                <option value="5">List VIP's by deposit counts</option>
              </optgroup>
              <optgroup label="Other">
                <option value="6">List staff members by approved transactions</option>
              </optgroup>
            </select>
            <button type="button" class="btn btn-sm btn-light" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
              <i class="fs-3 bi bi-box-arrow-down p-0"></i>
            </button>
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-export data-kt-menu="true">
              <div class="menu-item px-3">
                <a class="menu-link px-3" data-export-type="copy">Copy to Clipboard</a>
              </div>
              <div class="menu-item px-3">
                <a class="menu-link px-3" data-export-type="excel">Export as Excel</a>
              </div>
              <div class="menu-item px-3">
                <a class="menu-link px-3" data-export-type="csv">Export as CSV</a>
              </div>
              <div class="menu-item px-3">
                <a class="menu-link px-3" data-export-type="pdf">Export as PDF</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table id="statistics" class="table table-striped table-row-dashed gy-3 gs-7 fs-6 m-0">
            <thead>
              <tr class="fw-bold fs-6 border-bottom-2 border-gray-200">
                <th class="text-center min-w-80px">User ID</th>
                <th class="text-center min-w-80px">Username</th>
                <th class="text-center min-w-150px">Name Surname</th>
                <th class="text-center min-w-95px">Txn Count</th>
                <th class="text-center min-w-125px">Total Deposit</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div id="second-row" class="col-12 col-xl-3">
    <div class="card card-bordered card-flush h-100">
      <div class="card-header position-relative py-0 border-bottom-2">
        <div class="card-title d-flex flex-column flex-center w-100">
          <ul class="nav nav-tabs nav-line-tabs d-flex flex-center w-100 fs-6">
            <li class="nav-item">
              <a class="nav-link text-dark fw-bold border-active-dark border-hover-dark me-2 active" data-bs-toggle="tab" href="#tab-deposits">Deposits</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark fw-bold border-active-dark border-hover-dark mx-3" data-bs-toggle="tab" href="#tab-customers">Highlights</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="tab-deposits" role="tabpanel">
            <div class="row m-0 mb-3">
              <div class="fs-5 fw-bold text-center text-gray-900 w-100 m-0 py-3">Deposit Distribution</div>
              <div id="chart-reports-pie" class="d-flex flex-center p-0"></div>
            </div>
            <div class="row px-5 m-0 mb-5">
              <div class="fs-5 fw-bold text-center text-gray-900 w-100 m-0 pb-3">Deposit Counts</div>
              <div class="d-flex flex-stack">
                <div class="text-gray-800 fw-semibold fs-6 me-2">Papara</div>
                <span class="text-gray-900 fw-bolder fs-6">7216</span>
              </div>
              <div class="separator separator-dashed my-2"></div>
              <div class="d-flex flex-stack">
                <div class="text-gray-800 fw-semibold fs-6 me-2">Matching</div>
                <span class="text-gray-900 fw-bolder fs-6">4279</span>
              </div>
              <div class="separator separator-dashed my-2"></div>
              <div class="d-flex flex-stack">
                <div class="text-gray-800 fw-semibold fs-6 me-2">Bank</div>
                <span class="text-gray-900 fw-bolder fs-6">2150</span>
              </div>
              <div class="separator separator-dashed my-2"></div>
              <div class="d-flex flex-stack">
                <div class="text-gray-800 fw-semibold fs-6 me-2">Cross</div>
                <span class="text-gray-900 fw-bolder fs-6">954</span>
              </div>
              <div class="separator separator-dashed my-2"></div>
              <div class="d-flex flex-stack">
                <div class="text-gray-800 fw-semibold fs-6 me-2">Virtual POS</div>
                <span class="text-gray-900 fw-bolder fs-6">458</span>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="tab-customers" role="tabpanel">
            <div class="row px-5 m-0 mb-5">
              <div class="fs-5 fw-bold text-center text-gray-900 w-100 m-0 mb-5">Clients</div>
              <div class="d-flex flex-stack">
                <div class="text-gray-800 fw-semibold fs-6 me-2">Active Clients</div>
                <span class="text-gray-900 fw-bolder fs-6"><?= $highlights["activeClients"] ?></span>
              </div>
              <div class="separator separator-dashed my-2"></div>
              <div class="d-flex flex-stack">
                <div class="text-gray-800 fw-semibold fs-6 me-2">Matched Clients</div>
                <div class="d-flex align-items-senter">
                  <span class="text-gray-900 fw-bolder fs-6"><?= $highlights["matchedClients"] ?></span>
                </div>
              </div>
              <div class="separator separator-dashed my-2"></div>
              <div class="d-flex flex-stack">
                <div class="text-gray-800 fw-semibold fs-6 me-2">VIP Clients</div>
                <span class="text-gray-900 fw-bolder fs-6"><?= $highlights["vipClients"] ?></span>
              </div>
              <div class="separator separator-dashed my-2"></div>
              <div class="d-flex flex-stack">
                <div class="text-gray-800 fw-semibold fs-6 me-2">Deposit Restricted</div>
                <span class="text-gray-900 fw-bolder fs-6"><?= $highlights["depositRestricted"] ?></span>
              </div>
              <div class="separator separator-dashed my-2"></div>
              <div class="d-flex flex-stack">
                <div class="text-gray-800 fw-semibold fs-6 me-2">Withdraw Restricted</div>
                <span class="text-gray-900 fw-bolder fs-6"><?= $highlights["withdrawRestricted"] ?></span>
              </div>
              <div class="separator separator-dashed my-2"></div>
              <div class="d-flex flex-stack">
                <div class="text-gray-800 fw-semibold fs-6 me-2">Total Clients</div>
                <span class="text-gray-900 fw-bolder fs-6"><?= $highlights["totalClients"] ?></span>
              </div>
            </div>

            <div class="row px-5 m-0 mb-5">
              <div class="fs-5 fw-bold text-center text-gray-900 w-100 mt-3 mb-5">Transactions</div>
              <div class="d-flex flex-stack">
                <div class="text-gray-800 fw-semibold fs-6 me-2">Total Deposit Count</div>
                <span class="text-gray-900 fw-bolder fs-6">4596</span>
              </div>
              <div class="separator separator-dashed my-3"></div>
              <div class="d-flex flex-stack">
                <div class="text-gray-800 fw-semibold fs-6 me-2">Total Withdrawal Count</div>
                <div class="d-flex align-items-senter">
                  <span class="text-gray-900 fw-bolder fs-6">2587</span>
                </div>
              </div>
              <div class="separator separator-dashed my-3"></div>
              <div class="d-flex flex-stack">
                <div class="text-gray-800 fw-semibold fs-6 me-2">Avg. Deposit ToP</div>
                <span class="text-gray-900 fw-bolder fs-6">1dk32s</span>
              </div>
              <div class="separator separator-dashed my-3"></div>
              <div class="d-flex flex-stack">
                <div class="text-gray-800 fw-semibold fs-6 me-2">Avg. Withdrawal ToP</div>
                <span class="text-gray-900 fw-bolder fs-6">12dk45s</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card card-flush card-bordered mb-5 mb-sm-0">
  <div class="card-header py-5">
    <div class="card-title d-block">
      <h3 class="fw-bold m-0">Transaction Summary</h3>
      <div class="text-gray-600 fw-semibold fs-6 mt-1">Transaction summary on a daily basis</div>
    </div>
    <div class="card-toolbar flex-row-fluid flex-nowrap justify-content-end gap-5">
      <button type="button" class="btn btn-light" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
        <i class="fs-3 bi bi-box-arrow-down p-0"></i>
      </button>
      <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-export data-kt-menu="true">
        <div class="menu-item px-3">
          <a class="menu-link px-3" data-export-type="copy">Copy to Clipboard</a>
        </div>
        <div class="menu-item px-3">
          <a class="menu-link px-3" data-export-type="excel">Export as Excel</a>
        </div>
        <div class="menu-item px-3">
          <a class="menu-link px-3" data-export-type="csv">Export as CSV</a>
        </div>
        <div class="menu-item px-3">
          <a class="menu-link px-3" data-export-type="pdf">Export as PDF</a>
        </div>
      </div>
    </div>
  </div>
  <div id="third-row" class="card-body pt-0">
    <div class="table-responsive">
      <table class="table table-striped table-row-dashed fs-6 gy-2" id="transactionReports">
        <thead>
          <tr class="fw-bold fs-6 text-gray-800 px-7">
            <th rowspan="2" class="text-center align-middle border-bottom border-end w-100px">Date</th>
            <th colspan="5" class="text-center border-bottom border-end">Method</th>
            <th colspan="2" class="text-center border-bottom">Total Volume</th>
          </tr>
          <tr class="text-center text-gray-800 fw-bold fs-6 gs-0">
            <th class="min-w-75px text-center">Cross</th>
            <th class="min-w-100px text-center">Bank</th>
            <th class="min-w-75px text-center">Virtual POS</th>
            <th class="min-w-75px text-center">Papara</th>
            <th class="min-w-75px text-center border-end">Matching</th>
            <th class="min-w-75px text-center">Deposit</th>
            <th class="min-w-75px text-center">Withdraw</th>
          </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
          <tr class="fw-bold text-gray-800 border-top">
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>