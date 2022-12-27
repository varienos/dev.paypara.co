<div class="container-xxl" id="kt_content_container">
  <div class="row w-100">
    <div class="col-xl-3 p-0 pe-xl-3">
      <div class="card card-bordered bg-success bg-opacity-25 mb-5">
        <div class="card-body">
          <h5 class="card-title fw-semibold text-gray-700 pb-2">Deposit</h5>
          <h3 class="fw-bolder m-0">₺<?= number_format(depositDaily(), 2) ?></h3>
        </div>
      </div>
      <div class="card card-bordered bg-danger bg-opacity-20 mb-5">
        <div class="card-body">
          <h5 class="card-title fw-semibold text-gray-700 pb-2">Withdrawal</h5>
          <h3 class="fw-bolder m-0">₺<?= number_format(withdrawDaily(), 2) ?></h3>
        </div>
      </div>
      <div class="card card-bordered mb-5">
        <div class="card-body">
          <h5 class="card-title fw-semibold text-gray-700 pb-2">Pending Deposit</h5>
          <h3 class="fw-bolder m-0">₺<?= number_format(depositPendingDaily() ,2) ?>
            <? if(pendingProcessDaily('deposit') > 0): ?>
            <span class="text-gray-600 fs-5 fw-semibold"> (<?= pendingProcessDaily('deposit') ?> tx)</span>
            <? endif ?>
          </h3>
        </div>
      </div>
      <div class="card card-bordered mb-5">
        <div class="card-body">
          <h5 class="card-title fw-semibold text-gray-700 pb-2">Pending Withdrawal</h5>
          <h3 class="fw-bolder m-0">₺<?= number_format(withdrawPendingDaily(), 2)?>
            <? if(pendingProcessDaily('withdraw') > 0): ?>
            <span class="text-gray-600 fs-5 fw-semibold"> (<?= pendingProcessDaily('withdraw') ?> tx)</span>
            <? endif ?>
          </h3>
        </div>
      </div>
      <div class="card card-bordered mb-5 mb-xl-0">
        <div class="card-body">
          <h5 class="card-title fw-semibold text-gray-700 pb-2">Approved Transactions</h5>
          <div class="d-flex">
            <h3 class="fs-4 m-0 me-3">Deposit: <span class="text-gray-600 fs-4 fw-semibold"><?=depositProcessDaily() ?></span></h3>
            <h3 class="fs-4 m-0">Withdrawal: <span class="text-gray-600 fs-4 fw-semibold"><?=withdrawProcessDaily() ?></span></h3>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-9 p-0 ps-xl-3">
      <div class="card border mb-5">
        <div class="card-header border-0 pt-5">
          <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-2 mb-1">Weekly Overview</span>
            <span class="text-muted fw-semibold fs-6">Deposit and withdrawal amounts for this week</span>
          </h3>
        </div>
        <div class="card-body">
          <?php
            $withdrawFetchWeekly  = withdrawFetchWeekly();
            $depositFetchWeekly   = depositFetchWeekly();
            foreach (json_decode($withdrawFetchWeekly) as $value) { $withdrawFetchWeeklyCount += $value->dayTotal; }
            foreach (json_decode($depositFetchWeekly) as $value) { $depositFetchWeeklyCount += $value->dayTotal; } ?>
            <script>
              const withdrawFetchWeekly= <?=$withdrawFetchWeekly!=""?$withdrawFetchWeekly:'{[]}'; ?>;
              const depositFetchWeekly = <?=$depositFetchWeekly!=""?$depositFetchWeekly:'{[]}'; ?>;
            </script>
            <? if( $withdrawFetchWeeklyCount>0 or $depositFetchWeeklyCount>0 ): ?>

            <div id="kt_apexcharts_1" style="height: 280px;"></div>
          <?php else: ?>
            <h3 class="d-flex flex-center text-center text-gray-700 m-0" style="height: 295px;">No transactions this week</h3>
          <?php endif ?>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-lg-4">
          <div class="card card-bordered mb-5">
            <div class="card-header min-h-50px mh-50px p-0">
              <h5 class="card-title fw-bold flex-center flex-nowrap text-gray-700 w-100 m-0">Monthly Transaction Average</h5>
            </div>
            <div class="card-body d-flex">
              <div class="col-6 text-center">
                <h5 class="card-title fw-semibold text-gray-700 pb-2">Yatırım</h5>
                <h3 class="fw-bolder text-gray-700 m-0">₺<?= number_format(depositMonthly() / date('t'), 2) ?></h3>
              </div>
              <div class="col-6 text-center">
                <h5 class="card-title fw-semibold text-gray-700 pb-2">Çekim</h5>
                <h3 class="fw-bolder text-gray-700 m-0">₺<?= number_format(withdrawMonthly() / date('t'), 2) ?></h3>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-8">
          <div class="card card-bordered mb-5">
            <div class="card-header min-h-50px mh-50px p-0">
              <h5 class="card-title fw-bold flex-center flex-nowrap text-gray-700 w-100 m-0">Transaction Count</h5>
            </div>
            <div class="card-body">
              <div class="row d-flex">
                <div class="col-6 col-sm-2 text-center p-0 mb-5 mb-sm-0">
                  <h5 class="card-title fw-semibold text-gray-700 pb-0 pb-sm-2">Deposit</h5>
                  <h3 class="fw-bolder text-gray-700 m-0"><?= depositProcessMonthly() ?></h3>
                </div>
                <div class="col-6 col-sm-2 text-center p-0 mb-5 mb-sm-0">
                  <h5 class="card-title fw-semibold text-gray-700 pb-0 pb-sm-2">Withdrawal</h5>
                  <h3 class="fw-bolder text-gray-700 m-0"><?= withdrawProcessMonthly() ?></h3>
                </div>
                <div class="col-6 col-sm-2 text-center p-0 mb-5 mb-sm-0">
                  <h5 class="card-title fw-semibold text-gray-700 pb-0 pb-sm-2">Match</h5>
                  <h3 class="fw-bolder text-gray-700 m-0"><?= matchProcessMonthly() ?></h3>
                </div>
                <div class="col-6 col-sm-2 text-center p-0 mb-5 mb-sm-0">
                  <h5 class="card-title fw-semibold text-gray-700 pb-0 pb-sm-2">Bank</h5>
                  <h3 class="fw-bolder text-gray-700 m-0"><?= bankProcessMonthly() ?></h3>
                </div>
                <div class="col-6 col-sm-2 text-center p-0">
                  <h5 class="card-title fw-semibold text-gray-700 pb-0 pb-sm-2">Cross</h5>
                  <h3 class="fw-bolder text-gray-700 m-0">0</h3>
                </div>
                <div class="col-6 col-sm-2 text-center p-0">
                  <h5 class="card-title fw-semibold text-gray-700 pb-0 pb-sm-2">POS</h5>
                  <h3 class="fw-bolder text-gray-700 m-0">0</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>