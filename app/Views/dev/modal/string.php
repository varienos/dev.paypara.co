<div class="modal-header">
    <h2 class="fw-bold" style="font-family: 'VT323', monospace;">>_ STRING MANAGE</h2>
    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close" data-bs-dismiss="modal">
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
<div class="modal-body scroll-y mx-0 mx-md-5">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">

    <!--begin::Form-->
    <div>
        <div class=" mb-5">
        <div class="flex-column current" data-kt-stepper-element="content">
        <div class="scroll-y h-500px fv-row mb-10 devScrollTable" id="stringscroll">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                            <th width="250">> Flag</th>
                            <th width="150" style="width:100px; text-align:center;">> Custom ID</th>
                            <th>> String</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach (getStrings() as $row) { ?>
                        <tr>
                            <td><input type="text" class="form-control form-control-solid" placeholder="name@example.com" value="<?=$row->flag ?>" disabled><input type="hidden" value="<?=$row->id ?>" name="id[]"></td>
                            <td><input type="text" style="text-align:center;" class="form-control form-control-solid" value="<?=$row->custom_id ?>" name="custom_id[]"></td>
                            <td><input type="text" class="form-control form-control-solid" value="<?=$row->string ?>" name="string[]"></td>
                        </tr>
                        <? } ?>
                    </tbody>
                </table>
            </div>
                        </div>
        </div>
    </div>
    <!--begin::Group-->
    <div class="mb-5">
        <!--begin::Step 1-->
        <div class="flex-column current" data-kt-stepper-element="content">
            <!--begin::Input group-->
            <div class="fv-row">
                <div class="d-grid gap-2">
                    <button type="submit" data-srings-save-btn class="btn btn-primary" style="font-family: 'VT323', monospace;">SAVE</button>
                </div>
            </div>
        </div>
        <!--begin::Step 1-->
    </div>
    <!--end::Actions-->

    <!--end::Form-->
</div>
</div>