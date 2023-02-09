<div id="accounts-drawer" class="bg-body border-0" data-kt-drawer="true" data-kt-drawer-name="manage-accounts" data-kt-drawer-activate="true" data-kt-drawer-toggle="#accounts-toggle" data-kt-drawer-close="#accounts-drawer-close" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'280px', 'sm': '450px'}" data-kt-drawer-direction="end" style="border-top-left-radius: .75rem;">
  <div class="card w-100 rounded-0" id="accounts-drawer-card">
    <div class="card-header border-0 min-h-150px pt-3 pe-5" id="accounts-drawer-header">
      <div class="card-title flex-column w-100 mb-0">
        <div class="d-flex w-100">
          <h2 class="d-flex flex-center fw-semibold w-100 m-0">
            Manage

            <div class="w-auto border-2 border-bottom border-gray-300">
              <select id="methods" class="fs-2 text-danger mx-2 mt-2 pb-2" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-125px">
                <option value="1" selected>Papara</option>
                <option value="2">Matching</option>
                <option value="3">Bank</option>
              </select>
            </div>

            Accounts
          </h2>

          <div class="btn btn-sm btn-icon btn-active-light-primary" id="accounts-drawer-close">
            <i class="fs-1 bi bi-x"></i>
          </div>
        </div>

        <div class="position-relative w-100 my-7">
          <span class="text-gray-500 position-absolute top-50 translate-middle-y mt-1 ms-5">
            <i class="fs-5 bi bi-search"></i>
          </span>

          <input type="text" class="form-control form-control-lg form-control-solid px-15" name="search" value="" autocomplete="off" placeholder="Search by id, name or account number">

          <span class="d-none position-absolute top-50 end-0 translate-middle-y lh-0 me-5">
            <span class="spinner-border h-15px w-15px align-middle text-muted"></span>
          </span>

          <span class="d-none btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 me-5">
            <i class="fs-5 bi bi-x-lg"></i>
          </span>
        </div>

      </div>
    </div>
    <div class="card-body hover-scroll-overlay-y pt-0" id="accounts-drawer-body"></div>
    <div class="card-footer py-3" id="accounts-drawer-footer">
      <a id="view-all-link" href="account/index/1" target="_blank" class="btn btn-color-gray-600 btn-active-color-primary w-100 h-100">
        View All&nbsp;<i class="bi bi-arrow-right"></i>
      </a>
    </div>
  </div>
</div>