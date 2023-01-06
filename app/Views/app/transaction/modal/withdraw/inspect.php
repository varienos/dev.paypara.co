<form class="form" action="javascript:" id="modalForm" method="post" enctype="multipart/form-data">
  <input type="hidden" value="<?=$update->id ?>" name="id"></input>
  <div class="modal-header py-3 px-5" id="kt_modal_add_customer_header">
    <h2 class="fs-4 fw-bold">Transaction <span class="text-gray-700">#<?=$update->transaction_id ?></span></h2>
    <div id="kt_modal_add_customer_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
      <span class="svg-icon svg-icon-1">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" /><rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
        </svg>
      </span>
    </div>
  </div>
  <div class="modal-body pt-5 pb-2 ps-5">
    <div class="row d-flex fs-5">
      <div class="col-12 text-center">
        <div class="fw-bold fs-3 mt-3 mb-5">İşlem Detayları</div>
      </div>
      <div class="col-4 text-end mb-3">
        <label class="fw-bold">Tarih:</label>
      </div>
      <div class="col-8">
        <label class="text-gray-800"><?=$update->request_time ?></label>
      </div>
      <div class="col-4 text-end mb-3">
        <label class="fw-bold">Firma:</label>
      </div>
      <div class="col-8">
        <label class="text-gray-800"><?=$update->site_name ?></label>
      </div>
      <div class="col-4 text-end mb-3">
        <label class="fw-bold">User ID:</label>
      </div>
      <div class="col-8">
        <label class="text-gray-800"><?=$update->gamer_site_id ?></label>
      </div>
      <div class="col-4 text-end mb-3">
        <label class="fw-bold">Müşteri:</label>
      </div>
      <div class="col-8">
        <label class="text-gray-800"><?=$update->gamer_name ?></label>
      </div>
      <div class="col-4 text-end mb-3">
        <label class="fw-bold">Hesap No:</label>
      </div>
      <div class="col-8">
        <label class="text-gray-800"><?=$update->account_number ?></label>
      </div>
      <div class="col-4 text-end mb-3">
        <label class="fw-bold">Tutar:</label>
      </div>
      <div class="col-8">
        <label class="text-gray-800">₺<?= number_format($update->price, 2) ?></label>
      </div>
      <div class="col-4 text-end mb-3">
        <label class="fw-bold">Süre:</label>
      </div>
      <div class="col-8">
        <label class="text-gray-800"><?=$time ?></label>
      </div>
      <?php if($update->status=="onaylandı" || $update->status=="reddedildi") { ?>
        <div class="col-4 text-end mb-3">
          <label class="fw-bold">Personel:</label>
        </div>
        <div class="col-8">
          <label class="text-gray-800"><?=$update->user_name ?></label>
        </div>
      <?php } ?>
      <div class="col-4 text-end mb-3">
        <label class="fw-bold">Durum:</label>
      </div>
      <div class="col-8">
      <?
        if($update->status=="beklemede")
          echo('<div class="badge badge-lg fs-7 text-gray-800 badge-light-warning">Beklemede</div>');

        if($update->status=="işlemde")
          echo('<div class="badge badge-lg fs-7 text-gray-800 badge-light-warning">İşlemde</div>');

        if($update->status=="onaylandı")
          echo('<div class="badge badge-light-success fs-7 px-3">Onaylandı</div>');

        if($update->status=="reddedildi")
          echo('<div class="badge badge-light-danger fs-7 px-3">Reddedildi</div>');
      ?>
      </div>
    </div>
    <div class="row">
      <div class="col-12 text-center">
        <div class="fw-bold fs-3 rotate collapsible collapsed text-center mt-5 mb-7" data-bs-toggle="no-collapse" href="#kt_modal_add_to_reserves" role="button" aria-expanded="true" aria-controls="kt_customer_view_details" onclick="this.childNodes[1].classList.add('rotate-180');" style="opacity: .5; cursor: not-allowed;">Rezervlere Ekle
          <span class="ms-2">
            <span class="svg-icon svg-icon-3">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
              </svg>
            </span>
          </span>
        </div>
      </div>
      <div id="kt_modal_add_to_reserves" class="collapse">
        <div class="row">
          <div class="col-12 d-flex">
            <div class="col-4 text-end">
              <label class="required fw-bold fs-6 mt-2 me-2">Açıklama:</label>
            </div>
            <div class="col-8">
              <div class="input-group input-group-sm mb-5">
                <input type="text" class="form-control mw-75" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-4 text-end">
              <label class="fw-bold fs-6 mt-2">Tutar:</label>
            </div>
            <div class="col-4 pe-0">
              <div class="input-group input-group-sm mb-3">
                <input type="text" value="<?=$update->price ?>" class="form-control mw-75px" />
                <span class="input-group-text">₺</span>
              </div>
            </div>
            <div class="col-4 ps-0">
              <button type="button" class="btn btn-sm btn-light h-35px border">Ekle</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer flex-center py-3">
    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-light border w-90px me-3" data-bs-dismiss="modal">Kapat</button>
  </div>
</form>