<form class="form" action="javascript:" id="modalForm" method="post" enctype="multipart/form-data">
  <input type="hidden" value="<?=$id ?>" name="id"></input>
  <input type="hidden" value="<?=$type ?>" name="dataType"></input>
  <div class="modal-header" id="kt_modal_add_customer_header">
    <h2 class="fw-bold"><? echo $id>0 ? "Edit Account" : "Add New Account" ?></h2>
    <div id="kt_modal_add_customer_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
      <span class="svg-icon svg-icon-1">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" /><rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
        </svg>
      </span>
    </div>
  </div>
  <? if($type==1): ?>
  <div class="modal-body py-10 px-lg-17">
    <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">
      <div class="mb-7">
        <label class="fs-6 fw-semibold mb-2">
          <span class="required">Name Surname</span>
        </label>
        <input type="text" class="form-control form-control-solid border" placeholder="Account holders name and surname" name="account_name" maxlength="40" value="<?=$update->account_name ?>" required />
      </div>
      <div class="mb-7">
        <label class="fs-6 fw-semibold mb-2">
          <span class="required">Account Number</span>
        </label>
        <input type="text" class="form-control form-control-solid border" placeholder="Papara account number" maxlength="10" name="account_number" value="<?=$update->account_number ?>" required />
      </div>
      <div class="fw-bold fs-3 rotate collapsible collapsed mb-7" data-bs-toggle="collapse" href="#kt_modal_add_customer_billing_info" role="button" aria-expanded="false" aria-controls="kt_customer_view_details">
        Account Settings
        <span class="ms-2 rotate-180">
          <span class="svg-icon svg-icon-3">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
            </svg>
          </span>
        </span>
      </div>
      <div id="kt_modal_add_customer_billing_info" class="collapse">
        <div class="mb-7">
          <div class="d-flex flex-unset align-items-center">
            <div class="me-5"><label class="fs-6 fw-semibold">Activate the account?</label></div>
            <label class="form-check form-switch form-check-custom form-check-solid">
              <input class="form-check-input" name="status" type="checkbox" value="on" <? if($update->status=='on') echo "checked"; ?> id="kt_modal_add_customer_billing">
              <span class="form-check-label fw-semibold" for="kt_modal_add_customer_billing">Yes</span>
            </label>
          </div>
        </div>
        <div class="d-flex flex-column mb-7">
          <label class="required fs-6 fw-semibold mb-2">Monthly Deposit Limit</label>
          <div class="fs-7 fw-semibold text-muted mb-2">Account is deactivated at the specified deposit limit</div>
          <div class="input-group input-group-solid border">
            <span class="input-group-text">₺</span>
            <input type="text" class="form-control" value="<?=$update->limitDeposit=="" ? 1000000 : $update->limitDeposit ?>" name="limitDeposit" aria-label="Miktar" />
          </div>
        </div>
        <div class="d-flex flex-column mb-7">
          <label class="required fs-6 fw-semibold mb-2">Monthly Transaction Limit</label>
          <div class="fs-7 fw-semibold text-muted mb-2">Account is deactivated at the specified transactions</div>
          <div class="input-group input-group-solid border">
            <input type="text" class="form-control" value="<?=$update->limitProcess=="" ? 1000 : $update->limitProcess ?>" name="limitProcess" max="1000" maxlength="5" aria-label="Miktar" />
            <span class="input-group-text">transactions</span>
          </div>
        </div>
        <div class="d-flex flex-column mb-7">
          <label class="required fs-6 fw-semibold mb-2">Active Firms</label>
          <div class="fs-7 fw-semibold text-muted mb-2">At which firms the account should be used?</div>
          <select class="form-select form-select-solid form-select-lg border" data-control="select2" data-close-on-select="false" data-placeholder="All firms" name="perm_site[]" data-allow-clear="true" multiple="multiple">
            <option></option>
            <? $site = explode(",",$update->perm_site); foreach($siteSelect as $row){ $selected = in_array($row->id, $site) ? "selected" : null; ?>
            <option value="<?=$row->id ?>" <?=$selected ?>> <?=$row->site_name ?></option>
            <? } ?>
          </select>
        </div>
      </div>
    </div>
  </div>
  <? endif; ?>
  <? if($type==2): ?>
  <div class="modal-body py-10 px-lg-17">
    <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">
      <div class="mb-7">
        <label class="fs-6 fw-semibold mb-2">
          <span class="required">Name Surname</span>
        </label>
        <input type="text" class="form-control form-control-solid border" placeholder="Account holders name and surname" name="account_name" value="<?=$update->account_name ?>" />
      </div>
      <div class="mb-7">
        <label class="fs-6 fw-semibold mb-2">
          <span class="required">Account Number</span>
        </label>
        <input type="text" class="form-control form-control-solid border" placeholder="Papara account number" name="account_number" value="<?=$update->account_number ?>" />
      </div>
      <div class="fw-bold fs-3 rotate collapsible collapsed mb-7" data-bs-toggle="collapse" href="#kt_modal_add_customer_billing_info" role="button" aria-expanded="false" aria-controls="kt_customer_view_details">
        Account Settings
          <span class="ms-2 rotate-180">
            <span class="svg-icon svg-icon-3">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
              </svg>
            </span>
          </span>
      </div>
      <div id="kt_modal_add_customer_billing_info" class="collapse">
        <div class="mb-7">
          <div class="d-flex flex-unset align-items-center">
            <div class="me-5">
              <label class="fs-6 fw-semibold">Activate the account?</label>
            </div>
            <label class="form-check form-switch form-check-custom form-check-solid">
              <input class="form-check-input" name="status" type="checkbox" value="on" <? if($update->status=='on') echo "checked"; ?> id="kt_modal_add_customer_billing">
              <span class="form-check-label fw-semibold" for="kt_modal_add_customer_billing">Yes</span>
            </label>
          </div>
        </div>
        <div class="d-flex flex-column mb-7">
          <label class="required fs-6 fw-semibold mb-2">Clients to be Matched</label>
          <div class="fs-7 fw-semibold text-muted mb-2">Specified number of clients will be matched to account.</div>
          <div class="input-group input-group-solid border">
            <input type="text" class="form-control" value="<?=$update->match_limit=="" ? 5 : $update->match_limit ?>" name="match_limit" />
          </div>
        </div>
        <div class="d-flex flex-column mb-7">
          <label class="required fs-6 fw-semibold mb-2">Monthly Deposit Limit</label>
          <div class="fs-7 fw-semibold text-muted mb-2">Account is deactivated at the specified deposit limit</div>
          <div class="input-group input-group-solid border">
            <span class="input-group-text">₺</span>
            <input type="text" class="form-control" value="<?=$update->limitDeposit=="" ? 1000000 : $update->limitDeposit ?>" name="limitDeposit" aria-label="Miktar" />
            <span class="input-group-text">.00</span>
          </div>
        </div>
        <div class="d-flex flex-column mb-7">
          <label class="required fs-6 fw-semibold mb-2">Monthly Transaction Limit</label>
          <div class="fs-7 fw-semibold text-muted mb-2">Account is deactivated at the specified transactions</div>
          <div class="input-group input-group-solid border">
            <input type="text" class="form-control" value="<?=$update->limitProcess=="" ? 1000 : $update->limitProcess ?>" name="limitProcess" max="1000" maxlength="5" aria-label="Miktar" />
            <span class="input-group-text">transactions</span>
          </div>
        </div>
        <div class="d-flex flex-column mb-7">
          <label class="required fs-6 fw-semibold mb-2">Active Firms</label>
          <div class="fs-7 fw-semibold text-muted mb-2">At which firms the account should be used?</div>
          <select class="form-select form-select-solid form-select-lg border" data-control="select2" data-close-on-select="false" data-placeholder="All firms" name="perm_site[]" data-allow-clear="true" multiple="multiple">
            <option></option>
            <? $site = explode(",",$update->perm_site); foreach($siteSelect as $row){ $selected = in_array($row->id, $site) ? "selected" : null; ?>
            <option value="<?=$row->id ?>" <?=$selected ?>> <?=$row->site_name ?></option>
            <? } ?>
          </select>
        </div>
      </div>
    </div>
  </div>
  <? endif; ?>
  <? if($type==3): ?>
  <div class="modal-body py-10 px-lg-17">
    <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">
      <div class="mb-7">
        <label class="fs-6 fw-semibold mb-2">
          <span class="required">Name Surname</span>
        </label>
        <input type="text" class="form-control form-control-solid border" placeholder="Account holders name and surname" name="account_name" maxlength="40" value="<?=$update->account_name ?>" required />
      </div>
      <div class="mb-7">
        <label class="required fs-6 fw-semibold mb-2">Bank</label>
        <select class="form-select form-select-solid border" name="bank_id" data-control="select2" data-placeholder="Select bank" required>
          <option></option>
          <? foreach(bankArray() as $key=>$value){  ?>
          <option value="<?=$key ?>" <?=($update->bank_id==$key ? "selected" : null) ?>><?=$value ?></option>
          <? } ?>
        </select>
      </div>
      <div class="mb-7">
        <label class="fs-6 fw-semibold mb-2">
          <span class="required">IBAN Number</span>
        </label>
        <input type="text" class="form-control form-control-solid border" placeholder="Bank IBAN Number" maxlength="34" name="account_number" value="<?=$update->account_number ?>" required />
      </div>
      <div class="fw-bold fs-3 rotate collapsible collapsed mb-7" data-bs-toggle="collapse" href="#kt_modal_add_customer_billing_info" role="button" aria-expanded="false" aria-controls="kt_customer_view_details">
        Account Settings
        <span class="ms-2 rotate-180">
          <span class="svg-icon svg-icon-3">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
            </svg>
          </span>
        </span>
      </div>
      <div id="kt_modal_add_customer_billing_info" class="collapse">
        <div class="mb-7">
          <div class="d-flex flex-unset align-items-center">
            <div class="me-5">
              <label class="fs-6 fw-semibold">Activate the account?</label>
            </div>
            <label class="form-check form-switch form-check-custom form-check-solid">
              <input class="form-check-input" name="status" type="checkbox" value="on" <? if($update->status=='on') echo "checked"; ?> id="kt_modal_add_customer_billing">
              <span class="form-check-label fw-semibold" for="kt_modal_add_customer_billing">Yes</span>
            </label>
          </div>
        </div>
          <div class="d-flex flex-column mb-7">
            <label class="required fs-6 fw-semibold mb-2">Monthly Deposit Limit</label>
            <div class="fs-7 fw-semibold text-muted mb-2">Account is deactivated at the specified deposit limit</div>
            <div class="input-group input-group-solid border">
              <span class="input-group-text">₺</span>
              <input type="text" class="form-control" value="<?=$update->limitDeposit=="" ? 1000000 : $update->limitDeposit ?>" name="limitDeposit" aria-label="Miktar" />
            </div>
          </div>
          <div class="d-flex flex-column mb-7">
            <label class="required fs-6 fw-semibold mb-2">Monthly Transaction Limit</label>
            <div class="fs-7 fw-semibold text-muted mb-2">Account is deactivated at the specified transactions</div>
            <div class="input-group input-group-solid border">
              <input type="text" class="form-control" value="<?=$update->limitProcess=="" ? 1000 : $update->limitProcess ?>" name="limitProcess" max="1000" maxlength="5" aria-label="Miktar" />
              <span class="input-group-text">transactions</span>
            </div>
          </div>
          <div class="d-flex flex-column mb-7">
            <label class="required fs-6 fw-semibold mb-2">Active Firms</label>
            <div class="fs-7 fw-semibold text-muted mb-2">At which firms the account should be used?</div>
            <select class="form-select form-select-solid form-select-lg border" data-control="select2" data-close-on-select="false" data-placeholder="All firms" name="perm_site[]" data-allow-clear="true" multiple="multiple">
              <option></option>
              <? $site = explode(",",$update->perm_site); foreach($siteSelect as $row){ $selected = in_array($row->id, $site) ? "selected" : null; ?>
              <option value="<?=$row->id ?>" <?=$selected ?>> <?=$row->site_name ?></option>
              <? } ?>
            </select>
          </div>
      </div>
    </div>
  </div>
  <? endif; ?>
  <div class="modal-footer flex-center">
      <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
      <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary"><? echo $id>0 ? "Update" : "Add" ?></button>
  </div>
</form>