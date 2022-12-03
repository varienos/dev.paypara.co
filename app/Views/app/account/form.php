<form class="form" action="javascript:" id="modalForm" method="post" enctype="multipart/form-data">
  <input type="hidden" value="<?=$id ?>" name="id"></input>
  <input type="hidden" value="<?=$type ?>" name="dataType"></input>
  <div class="modal-header" id="kt_modal_add_customer_header">
    <h2 class="fw-bold"><? echo $id>0 ? "Hesabı Düzenle" : "Yeni Hesap Ekle" ?></h2>
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
      <div class="fv-row mb-7">
        <label class="fs-6 fw-semibold mb-2">
          <span class="required">Ad Soyad</span>
        </label>
        <input type="text" class="form-control form-control-solid border" placeholder="Hesap sahibi adı ve soyadı" name="account_name" maxlength="40" value="<?=$update->account_name ?>" required />
      </div>
      <div class="fv-row mb-7">
        <label class="fs-6 fw-semibold mb-2">
          <span class="required">Hesap Numarası</span>
        </label>
        <input type="text" class="form-control form-control-solid border" placeholder="Papara hesap numarası" maxlength="10" name="account_number" value="<?=$update->account_number ?>" required />
      </div>
      <div class="fw-bold fs-3 rotate collapsible mb-7" data-bs-toggle="collapse" href="#kt_modal_add_customer_billing_info" role="button" aria-expanded="false" aria-controls="kt_customer_view_details">
        Hesap Ayarları 
        <span class="ms-2 rotate-180">
          <span class="svg-icon svg-icon-3">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
            </svg>
          </span>
        </span>
      </div>
      <div id="kt_modal_add_customer_billing_info" class="collapse">
        <div class="fv-row mb-7">
          <div class="d-flex flex-unset align-items-center">
            <div class="me-5"><label class="fs-6 fw-semibold">Hesap aktif edilsin mi?</label></div>
            <label class="form-check form-switch form-check-custom form-check-solid">
              <input class="form-check-input" name="status" type="checkbox" value="on" <? if($update->status=='on') echo "checked"; ?> id="kt_modal_add_customer_billing">
              <span class="form-check-label fw-semibold" for="kt_modal_add_customer_billing">Evet</span>
            </label>
          </div>
        </div>
        <div class="d-flex flex-column mb-7 fv-row">
          <label class="required fs-6 fw-semibold mb-2">Aylık Yatırım Limiti</label>
          <div class="fs-7 fw-semibold text-muted mb-2">Belirtilen limite gelindiğinde hesap otomatik pasife alınır</div>
          <div class="input-group input-group-solid border">
            <span class="input-group-text">₺</span>
            <input type="text" class="form-control" value="<?=$update->limitDeposit=="" ? 1000000 : $update->limitDeposit ?>" name="limitDeposit" id="kt_inputmask_1" aria-label="Miktar" />
          </div>
        </div>
        <div class="d-flex flex-column mb-7 fv-row">
          <label class="required fs-6 fw-semibold mb-2">Aylık İşlem Limiti</label>
          <div class="fs-7 fw-semibold text-muted mb-2">Belirtilen işlem sayısında hesap pasife alınır</div>
          <div class="input-group input-group-solid border">
            <span class="input-group-text">İşlem</span>
            <input type="text" class="form-control" value="<?=$update->limitProcess=="" ? 1000 : $update->limitProcess ?>" name="limitProcess" id="kt_inputmask_1" max="1000" maxlength="4" aria-label="Miktar" />
          </div>
        </div>
        <div class="d-flex flex-column mb-7 fv-row">
          <label class="required fs-6 fw-semibold mb-2">Kullanılacak Firmalar</label>
          <div class="fs-7 fw-semibold text-muted mb-2">Hesap hangi firmalarda kullanılsın?</div>
          <select class="form-select form-select-solid form-select-lg border" data-control="select2" data-close-on-select="false" data-placeholder="Tüm firmalar" name="perm_site[]" data-allow-clear="true" multiple="multiple">
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
      <div class="fv-row mb-7">
        <label class="fs-6 fw-semibold mb-2">
          <span class="required">Ad Soyad</span>
        </label>
        <input type="text" class="form-control form-control-solid border" placeholder="Hesap sahibi adı ve soyadı" name="account_name" value="<?=$update->account_name ?>" />
      </div>
      <div class="fv-row mb-7">
        <label class="fs-6 fw-semibold mb-2">
          <span class="required">Hesap Numarası</span>
        </label>
        <input type="text" class="form-control form-control-solid border" placeholder="Papara hesap numarası" name="account_number" value="<?=$update->account_number ?>" />
      </div>
      <div class="fw-bold fs-3 rotate collapsible mb-7" data-bs-toggle="collapse" href="#kt_modal_add_customer_billing_info" role="button" aria-expanded="false" aria-controls="kt_customer_view_details">
        Hesap Ayarları
          <span class="ms-2 rotate-180">
            <span class="svg-icon svg-icon-3">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
              </svg>
            </span>
          </span>
      </div>
      <div id="kt_modal_add_customer_billing_info" class="collapse">
        <div class="fv-row mb-7">
          <div class="d-flex flex-unset align-items-center">
            <div class="me-5">
              <label class="fs-6 fw-semibold">Hesap aktif edilsin mi?</label>
            </div>
            <label class="form-check form-switch form-check-custom form-check-solid">
              <input class="form-check-input" name="status" type="checkbox" value="on" <? if($update->status=='on') echo "checked"; ?> id="kt_modal_add_customer_billing">
              <span class="form-check-label fw-semibold" for="kt_modal_add_customer_billing">Evet</span>
            </label>
          </div>
        </div>
        <div class="d-flex flex-column mb-7 fv-row">
          <label class="required fs-6 fw-semibold mb-2">Eşleşecek Oyuncu Sayısı</label>
          <div class="fs-7 fw-semibold text-muted mb-2">Hesaba belirtilen sayı kadar üye eşleştirilir</div>
          <div class="input-group input-group-solid border">
            <input type="text" class="form-control" value="<?=$update->match_limit=="" ? 5 : $update->match_limit ?>" name="match_limit" />
          </div>
        </div>
        <div class="d-flex flex-column mb-7 fv-row">
          <label class="required fs-6 fw-semibold mb-2">Aylık Yatırım Limiti</label>
          <div class="fs-7 fw-semibold text-muted mb-2">Belirtilen limite gelindiğinde hesap otomatik pasife alınır</div>
          <div class="input-group input-group-solid border">
            <span class="input-group-text">₺</span>
            <input type="text" class="form-control" value="<?=$update->limitDeposit=="" ? 1000000 : $update->limitDeposit ?>" name="limitDeposit" id="kt_inputmask_1" aria-label="Miktar" />
            <span class="input-group-text">.00</span>
          </div>
        </div>
        <div class="d-flex flex-column mb-7 fv-row">
          <label class="required fs-6 fw-semibold mb-2">Aylık İşlem Limiti</label>
          <div class="fs-7 fw-semibold text-muted mb-2">Belirtilen işlem sayısında hesap pasife alınır</div>
          <div class="input-group input-group-solid border">
            <span class="input-group-text">İşlem</span>
            <input type="text" class="form-control" value="<?=$update->limitProcess=="" ? 1000 : $update->limitProcess ?>" name="limitProcess" id="kt_inputmask_1" max="1000" maxlength="4" aria-label="Miktar" />
          </div>
        </div>
        <div class="d-flex flex-column mb-7 fv-row">
          <label class="required fs-6 fw-semibold mb-2">Kullanılacak Firmalar</label>
          <div class="fs-7 fw-semibold text-muted mb-2">Hesap hangi firmalarda kullanılsın?</div>
          <select class="form-select form-select-solid form-select-lg border" data-control="select2" data-close-on-select="false" data-placeholder="Tüm firmalar" name="perm_site[]" data-allow-clear="true" multiple="multiple">
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
      <div class="fv-row mb-7">
        <label class="fs-6 fw-semibold mb-2">
          <span class="required">Ad Soyad</span>
        </label>
        <input type="text" class="form-control form-control-solid border" placeholder="Hesap sahibi adı ve soyadı" name="account_name" maxlength="40" value="<?=$update->account_name ?>" required />
      </div>
      <div class="fv-row mb-7">
        <label class="required fs-6 fw-semibold mb-2">Banka</label>
        <select class="form-select form-select-solid border" name="bank_id" data-control="select2" data-placeholder="Banka seçin" required>
          <option></option>
          <? foreach(bankArray() as $key=>$value){  ?>
          <option value="<?=$key ?>" <?=($update->bank_id==$key ? "selected" : null) ?>><?=$value ?></option>
          <? } ?>
        </select>
      </div>
      <div class="fv-row mb-7">
        <label class="fs-6 fw-semibold mb-2">
          <span class="required">IBAN Numarası</span>
        </label>
        <input type="text" class="form-control form-control-solid border" placeholder="Banka IBAN Numarası" maxlength="34" name="account_number" value="<?=$update->account_number ?>" required />
      </div>
      <div class="fw-bold fs-3 rotate collapsible mb-7" data-bs-toggle="collapse" href="#kt_modal_add_customer_billing_info" role="button" aria-expanded="false" aria-controls="kt_customer_view_details">
        Hesap Ayarları 
        <span class="ms-2 rotate-180">
          <span class="svg-icon svg-icon-3">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
            </svg>
          </span>
        </span>
      </div>
      <div id="kt_modal_add_customer_billing_info" class="collapse">
        <div class="fv-row mb-7">
          <div class="d-flex flex-unset align-items-center">
            <div class="me-5">
              <label class="fs-6 fw-semibold">Hesap aktif edilsin mi?</label>
            </div>
            <label class="form-check form-switch form-check-custom form-check-solid">
              <input class="form-check-input" name="status" type="checkbox" value="on" <? if($update->status=='on') echo "checked"; ?> id="kt_modal_add_customer_billing">
              <span class="form-check-label fw-semibold" for="kt_modal_add_customer_billing">Evet</span>
            </label>
          </div>
        </div>
          <div class="d-flex flex-column mb-7 fv-row">
            <label class="required fs-6 fw-semibold mb-2">Aylık Yatırım Limiti</label>
            <div class="fs-7 fw-semibold text-muted mb-2">Belirtilen limite gelindiğinde hesap otomatik pasife alınır</div>
            <div class="input-group input-group-solid border">
              <span class="input-group-text">₺</span>
              <input type="text" class="form-control" value="<?=$update->limitDeposit=="" ? 1000000 : $update->limitDeposit ?>" name="limitDeposit" id="kt_inputmask_1" aria-label="Miktar" />
            </div>
          </div>
          <div class="d-flex flex-column mb-7 fv-row">
            <label class="required fs-6 fw-semibold mb-2">Aylık İşlem Limiti</label>
            <div class="fs-7 fw-semibold text-muted mb-2">Belirtilen işlem sayısında hesap pasife alınır</div>
            <div class="input-group input-group-solid border">
              <span class="input-group-text">İşlem</span>
              <input type="text" class="form-control" value="<?=$update->limitProcess=="" ? 1000 : $update->limitProcess ?>" name="limitProcess" id="kt_inputmask_1" max="1000" maxlength="4" aria-label="Miktar" />
            </div>
          </div>
          <div class="d-flex flex-column mb-7 fv-row">
            <label class="required fs-6 fw-semibold mb-2">Kullanılacak Firmalar</label>
            <div class="fs-7 fw-semibold text-muted mb-2">Hesap hangi firmalarda kullanılsın?</div>
            <select class="form-select form-select-solid form-select-lg border" data-control="select2" data-close-on-select="false" data-placeholder="Tüm firmalar" name="perm_site[]" data-allow-clear="true" multiple="multiple">
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
      <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">Vazgeç</button>
      <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary"><? echo $id>0 ? "Hesabı Güncelle" : "Ekle" ?></button>
  </div>
</form>