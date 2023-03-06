<div class="card card-flush card-bordered">
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
      <table id="transactionReports" class="table table-striped table-row-dashed gy-2 gs-7 fs-6">
        <thead>
          <tr class="fw-bold fs-6 text-gray-800 px-7">
            <th rowspan="2" class="text-center align-middle border-bottom border-end w-100px">Date</th>
            <th colspan="2" class="text-center border-bottom border-end">Deposit</th>
            <th colspan="3" class="text-center border-bottom">Withdrawal</th>
          </tr>
          <tr class="fw-bold fs-6 text-gray-800 gs-0">
            <th class="min-w-175px text-center ps-3">Transaction</th>
            <th class="min-w-175px text-center border-end">Amount</th>
            <th class="min-w-175px text-center">Transaction</th>
            <th class="min-w-175px text-center pe-3">Amount</th>
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
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>