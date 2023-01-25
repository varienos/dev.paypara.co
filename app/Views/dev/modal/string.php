<div class="modal-header">
  <h2 class="fw-bold">Manage Messages</h2>
  <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close" data-bs-dismiss="modal">
    <span class="svg-icon svg-icon-1">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" /><rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
      </svg>
    </span>
  </div>
</div>
<div class="modal-body scroll-y mx-0 mx-md-5">
  <div id="stringscroll" class="scroll-y h-500px devScrollTable mb-5">
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
            <th class="w-250px">Flag</th>
            <th class="w-150px text-center">Custom ID</th>
            <th>Message</th>
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
  <button type="submit" class="btn btn-dark d-block w-25 mx-auto" data-messages-save-btn>Save</button>
</div>