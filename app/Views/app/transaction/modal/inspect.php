<style>
.drawer {
    z-index: 99999999 !important;
}
</style>
<div id="drawer" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#inspect" data-kt-drawer-close="#close-inspect" data-kt-drawer-width="360px" style="border-top-left-radius: .75rem;">
  <div id="inspect-info" class="card w-100 rounded-0">
    <div class="card-header d-flex flex-nowrap bg-transparent border-0 min-h-55px p-0">
      <div class="card-title w-100 m-0">
        <ul id="detailsTab" class="nav nav-tabs nav-line-tabs nav-line-tabs-2x align-items-end fs-6 w-100 h-100 ps-5">
          <li class="nav-item">
            <a class="nav-link active fs-4 fw-semibold text-muted text-active-dark border-hover-dark border-active-dark me-1 p-0 px-2 pb-4" data-bs-toggle="tab" href="#tab_details">Details</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fs-4 fw-semibold text-muted text-active-dark border-hover-dark border-active-dark me-1 p-0 px-2 pb-4" data-bs-toggle="tab" href="#tab_actions">Actions</a>
          </li>
        </ul>
      </div>
      <div class="card-toolbar border-bottom border-2 m-0">
        <button id="close-inspect" class="btn text-hover-dark">
          <span class="svg-icon svg-icon-muted svg-icon-1 m-0">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="1" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"/><rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"/>
            </svg>
          </span>
        </button>
      </div>
    </div>
    <div class="card-body hover-scroll-overlay-y p-0">
      <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active p-5" id="tab_details" role="tabpanel">
            <p class="fs-5 fw-semibold text-center text-gray-900 m-0"><? echo(ucfirst(segment[2])) ?></p>
            <p class="fs-6 text-center text-gray-700 m-0" data-set-date>{date}</p>
            <div class="card shadow-sm mt-13">
              <div class="card-body px-0 pb-0 pt-8">
                <div class="d-flex flex-column rounded-2 w-100 p-0 mt-5">
                  <img class="position-absolute align-self-center border rounded-4 w-50px h-50px" style="top: -27px;" src="<?=baseUrl() ?>/<?=assetsPath() ?>/media/avatar.png"/>
                  <div class="d-flex flex-column flex-center">
                    <a href="javascript:;" data-set-customerLink class="d-flex text-reset text-hover-primary">
                      <p class="fs-3 fw-bolder m-0 me-2 text-dark" data-set-customer>{customer}</p>
                      <span class="svg-icon svg-icon-muted svg-icon-3 align-self-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="1" d="M4.7 17.3V7.7C4.7 6.59543 5.59543 5.7 6.7 5.7H9.8C10.2694 5.7 10.65 5.31944 10.65 4.85C10.65 4.38056 10.2694 4 9.8 4H5C3.89543 4 3 4.89543 3 6V19C3 20.1046 3.89543 21 5 21H18C19.1046 21 20 20.1046 20 19V14.2C20 13.7306 19.6194 13.35 19.15 13.35C18.6806 13.35 18.3 13.7306 18.3 14.2V17.3C18.3 18.4046 17.4046 19.3 16.3 19.3H6.7C5.59543 19.3 4.7 18.4046 4.7 17.3Z" fill="currentColor"/><rect x="21.9497" y="3.46448" width="13" height="2" rx="1" transform="rotate(135 21.9497 3.46448)" fill="currentColor"/><path d="M19.8284 4.97161L19.8284 9.93937C19.8284 10.5252 20.3033 11 20.8891 11C21.4749 11 21.9497 10.5252 21.9497 9.93937L21.9497 3.05029C21.9497 2.498 21.502 2.05028 20.9497 2.05028L14.0607 2.05027C13.4749 2.05027 13 2.52514 13 3.11094C13 3.69673 13.4749 4.17161 14.0607 4.17161L19.0284 4.17161C19.4702 4.17161 19.8284 4.52978 19.8284 4.97161Z" fill="currentColor"/>
                        </svg>
                      </span>
                    </a>
                    <p class="fs-3 fw-bold m-0 mt-1 mb-6" data-set-amount>{amount}</p>
                    <span class="badge badge-light-success fs-7 mb-6" data-set-status>{status}</span>
                  </div>
                  <? if(segment[2] === "deposit"): ?>
                  <div class="card-footer d-flex pe-0 ps-5 py-5">
                    <p class="fs-5 fw-semibold text-gray-700 p-0 m-0 me-2">Account:</p>
                    <a href="javascript:;" data-set-accountLink class="d-flex align-items-center text-reset text-hover-primary p-0">
                      <p class="fs-6 fw-semibold text-gray-900 h-100 m-0 me-1">
                        <span data-set-accountName></span>
                        <small> (<span data-set-accountId></span>)</small>
                      </p>
                      <span class="svg-icon svg-icon-muted svg-icon-5 align-self-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path opacity="1" d="M4.7 17.3V7.7C4.7 6.59543 5.59543 5.7 6.7 5.7H9.8C10.2694 5.7 10.65 5.31944 10.65 4.85C10.65 4.38056 10.2694 4 9.8 4H5C3.89543 4 3 4.89543 3 6V19C3 20.1046 3.89543 21 5 21H18C19.1046 21 20 20.1046 20 19V14.2C20 13.7306 19.6194 13.35 19.15 13.35C18.6806 13.35 18.3 13.7306 18.3 14.2V17.3C18.3 18.4046 17.4046 19.3 16.3 19.3H6.7C5.59543 19.3 4.7 18.4046 4.7 17.3Z" fill="currentColor" /><rect x="21.9497" y="3.46448" width="13" height="2" rx="1" transform="rotate(135 21.9497 3.46448)" fill="currentColor" /><path d="M19.8284 4.97161L19.8284 9.93937C19.8284 10.5252 20.3033 11 20.8891 11C21.4749 11 21.9497 10.5252 21.9497 9.93937L21.9497 3.05029C21.9497 2.498 21.502 2.05028 20.9497 2.05028L14.0607 2.05027C13.4749 2.05027 13 2.52514 13 3.11094C13 3.69673 13.4749 4.17161 14.0607 4.17161L19.0284 4.17161C19.4702 4.17161 19.8284 4.52978 19.8284 4.97161Z" fill="currentColor" />
                        </svg>
                      </span>
                    </a>
                  </div>
                  <? else: ?>
                  <div class="card-footer d-flex flex-column text-center pe-0 ps-5 py-5">
                    <div class="fs-5 fw-bold text-gray-800 w-100 p-0 m-0 mb-1">Account Number</div>
                    <div class="fs-6 fw-semibold text-gray-700 w-100 p-0 m-0">1234567890</div>
                  </div>
                  <? endif; ?>
                </div>
              </div>
            </div>

            <!-- Reserve -->
            <div class="d-none alert bg-light-warning border border-warning border-dashed d-flex align-items-center w-100 p-3 mt-10 mb-5">
              <span class="svg-icon svg-icon-2x svg-icon-warning me-1">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect><rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"></rect><rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"></rect>
                </svg>
              </span>
              <a href="#" class="fs-6 fw-semibold text-dark text-hover-danger m-0">Yanlış onay mı verdin? Buradan iptal et</a>
            </div>

            <div class="separator separator-dashed my-6"></div>

            <div class="row ps-3">
              <h4 class="mb-4 p-0">Transaction Details</h4>
              <table class="table fs-6 fw-semibold gs-0 gy-2 gx-2 m-0">
                <tbody>
                  <tr class="">
                    <td class="text-gray-600 p-0 pb-3">Time:</td>
                    <td class="text-gray-800 p-0 pb-3" data-set-time>{time}</td>
                  </tr>
                  <tr class="">
                    <td class="text-gray-600 p-0 pb-3 w-125px">TXID:</td>
                    <td class="text-gray-800 p-0 pb-3" data-set-txid>{txid}</td>
                  </tr>
                  <tr class="">
                    <td class="text-gray-600 p-0 pb-3">User ID:</td>
                    <td class="text-gray-800 p-0 pb-3" data-set-userId>{user_id}</td>
                  </tr>
                  <tr class="">
                    <td class="text-gray-600 p-0 pb-3">Firm:</td>
                    <td class="text-gray-800 p-0 pb-3" data-set-firm>{firm}</td>
                  </tr>
                  <? if(segment[2] === "deposit"): ?>
                  <tr>
                    <td class="text-gray-600 p-0 pb-3">Method:</td>
                    <td class="p-0 pb-3">
                      <span class="badge bg-danger text-white" data-set-method>{method}</span>
                    </td>
                  </tr>
                  <? endif; ?>
                  <tr id="staff">
                    <td class="text-gray-600 p-0 pb-3">Staff:</td>
                    <td class="text-gray-800 p-0 pb-3" data-set-staff>{staff}</td>
                  </tr>
                  <tr id="processNote">
                    <td class="text-gray-600 p-0 pb-3">Notes:</td>
                    <td class="text-gray-800 p-0 pb-3" data-set-processNote>{notes}</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="separator separator-dashed my-6"></div>

            <div class="row ps-3">
              <h4 class="mb-3 p-0">Customer Note</h4>
              <textarea class="form-control form-control-solid border h-75px p-2" style="resize: none; overflow: auto;" spellcheck="false" disabled data-set-customerNote></textarea>
            </div>
        </div>
        <div class="tab-pane fade p-5" id="tab_actions" role="tabpanel">
          <div class="row m-0">
            <div class="d-flex justify-content-between align-items-center p-0 mt-3 mb-5">
              <h4 class="m-0">Add to Reserves</h4>
              <a href="#" class="btn text-primary text-hover-dark fs-4 p-0">Add</a>
            </div>
            <div class="d-flex p-0">
              <img class="align-self-center rounded-circle w-50px p-0 me-3" src="<?=baseUrl() ?>/<?=assetsPath() ?>/media/avatar.png"/>
              <div class="d-flex flex-column justify-content-center">
                <p class="fs-5 fw-bolder m-0" data-set-customer>{customer}</p>
                <p class="fs-6 fw-semibold text-gray-700 m-0">Reserved At: Deposit</p>
              </div>
            </div>
            <h5 class="mt-7 mb-4 p-0">Reserve Amount</h5>
            <div class="input-group input-group-sm p-0">
              <span class="input-group-text">₺</span>
              <input type="number"class="form-control" min="0.00" max="15000.00" step="0.5" value="250.00"/>
            </div>
            <h5 class="mt-5 mb-4 p-0">Reserve Note</h5>
            <textarea class="form-control border border-gray-300" style="resize: none;" spellcheck="false"></textarea>
          </div>

          <div class="separator separator-dashed my-7"></div>

          <div class="row m-0">
            <h4 class="mb-4 p-0">Customer Permissions</h4>
            <div class="d-flex justify-content-start p-0">
              <div class="d-flex align-items-center p-0 me-3">
                <div class="fs-5 fw-semibold text-dark m-0 me-2">VIP:</div>
                <label class="form-check form-switch form-check-custom form-check-success form-check-solid">
                  <input class="form-check-input h-20px w-40px" type="checkbox" role="switch" id="isVip" data-set="switch" data-id="" name="isVip">
                </label>
              </div>

              <div class="d-flex align-items-center p-0 me-3">
                <div class="fs-5 fw-semibold text-dark m-0 me-2">Deposit:</div>
                <label class="form-check form-switch form-check-custom form-check-success form-check-solid">
                  <input class="form-check-input h-20px w-40px" type="checkbox" role="switch" id="deposit" data-set="switch" data-id="" name="deposit">
                </label>
              </div>

              <div class="d-flex align-items-center p-0">
                <div class="fs-5 fw-semibold text-dark m-0 me-2">Withdraw:</div>
                <label class="form-check form-switch form-check-custom form-check-success form-check-solid">
                  <input class="form-check-input h-20px w-40px" type="checkbox" role="switch" id="withdraw" data-set="switch" data-id="" name="withdraw">
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>