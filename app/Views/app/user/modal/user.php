<form class="form" action="javascript:" id="modalForm" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="modal-header" id="kt_modal_add_user_header">
        <h2 class="fw-bold">Add New User</h2>
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close"
            data-bs-dismiss="modal">
            <span class="svg-icon svg-icon-1">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)"
                        fill="currentColor" />
                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                        fill="currentColor" />
                </svg>
            </span>
        </div>
    </div>
    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
            data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
            data-kt-scroll-offset="300px">
            <div class="mb-7">
                <label class="required fw-semibold fs-6 mb-2">Name</label>
                <input type="text" name="user_name" class="form-control form-control-solid border mb-3 mb-lg-0" />
            </div>
            <div class="mb-7">
                <label class="required fw-semibold fs-6 mb-2" autocomplete="off" value="">E-Mail</label>
                <input type="email" name="email" app-submit-email-check class="form-control form-control-solid border mb-3 mb-lg-0" />
            </div>
            <div class="mb-7">
                <label class="required fw-semibold fs-6 mb-2" autocomplete="off" value="">Password</label>
                <input type="password" name="user_pass" class="form-control form-control-solid border mb-3 mb-lg-0" />
            </div>
            <div class="mb-7">
                <label class="required fw-semibold fs-6 mb-5">User Role</label>
                <select class="form-select form-select-solid border" name="role_id" data-control="select2"
                    data-placeholder="Select role" data-hide-search="true">
                    <option></option>
                    <? foreach(getRoles() as $row){ ?>
                    <option value="<?=$row->id ?>"><?=$row->name ?></option>
                    <? } ?>
                </select>

            </div>
            <div class="mb-7">
                <label class="required fw-semibold fs-6 mb-5">Associated Firms</label>
                <select class="form-select form-select-solid form-select-lg border" data-control="select2"
                    data-close-on-select="false" data-placeholder="All firms" name="perm_site[]"
                    data-allow-clear="true" multiple="multiple">
                    <option></option>
                    <? $site = explode(",",$update->perm_site); foreach($siteSelect as $row){ $selected = in_array($row->id, $site) ? "selected" : null; ?>
                    <option value="<?=$row->id ?>" <?=$selected ?>> <?=$row->site_name ?></option>
                    <? } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer flex-center">
        <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3"
            data-bs-dismiss="modal">Cancel</button>
        <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">Add User</button>
    </div>
</form>