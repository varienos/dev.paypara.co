<form class="form" action="javascript:" id="modalForm" method="post" enctype="multipart/form-data">
  <input type="hidden" value="<?=$update->id ?>" name="id"></input>
  <input type="hidden" value="approve" name="response"></input>
  <input type="hidden" value="onaylandı" name="status"></input>
  <input type="hidden" value="deposit" name="request"></input>
  <div class="modal-header py-3 px-5" id="kt_modal_add_customer_header">
    <h2 class="fs-4 fw-bold">İşlemi Onayla</h2>
    <div id="kt_modal_add_customer_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
      <span class="svg-icon svg-icon-1">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" /><rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
        </svg>
      </span>
    </div>
  </div>
  <div class="modal-body py-5 px-lg-10">
    <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">
      <div class="d-flex flex-column mb-5">
        <span class="badge badge-lg badge-light-dark mx-auto fs-5 mb-1"><?=number_format($update->price,2) ?>₺</span>
        <label class="fs-4 fw-bolder mb-5 text-center text-dark"><?=$update->gamer_name ?></label>
        <label class="fs-5 fw-semibold mb-2 text-center">Yatırımını <span class="fw-bolder border-bottom border-success border-4 text-dark px-1">onaylamak</span> istediğinize emin misiniz?</label>
      </div>
      <div class="d-flex align-items-center">
        <label class="fw-semibold text-end fs-5 w-80px w-md-90px me-3">Tutar:</label>
        <div class="input-group justify-content-between input-group-solid input-group-sm border w-100 mb-3">
        <span class="input-group-text">₺</span>
          <input type="text" class="form-control" name="price" value="<?=$update->price ?>" />
        </div>
      </div>
      <div class="d-flex align-items-center">
        <label class="fs-5 fw-semibold me-3">Açıklama:</label>
        <div class="d-flex align-items-end justify-content-end input-group input-group-solid input-group-sm border">
          <input type="text" class="form-control" name="notes" value="<?=$update->notes ?>" />
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer flex-center py-3">
    <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-sm btn-light border w-90px me-3" data-bs-dismiss="modal">Vazgeç</button>
    <button type="submit" id="modalSubmit" class="btn btn-sm btn-success w-90px">Onayla</button>
  </div>
</form>