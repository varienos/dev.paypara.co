<form class="form" action="javascript:" id="roleForm" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?=$role->id ?>" />
    <div class="modal-header">
        <h2 class="fw-bold"><?=($role->id>0 ? "Yetkiyi Düzenle" : "Yeni Yetki Ekle")?></h2>
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close" data-bs-dismiss="modal">
            <span class="svg-icon svg-icon-1">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                </svg>
            </span>
        </div>
    </div>
    <div class="modal-body scroll-y mx-0 mx-md-5 mt-2 mb-4">
        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_roles_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_roles_header" data-kt-scroll-wrappers="#kt_modal_roles_scroll" data-kt-scroll-offset="300px">
          <div class="row mb-3">
            <div class="col-12 col-md-3 d-flex align-items-center">
                <label class="col-form-label fw-bold p-0 pb-1 fs-5 required">Yetki adı</label>
            </div>
            <div class="col-12 col-md-9 d-flex align-items-center">
                <input type="text" class="form-control form-control-solid border h-40px" placeholder="Yetki adı girin" name="name" value="<?=$role->name ?>">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12 col-md-3 d-flex align-items-center">
              <label class="col-form-label fw-bold p-0 pb-1 fs-5">Hesap Türü</label>
            </div>
            <div class="col-12 col-md-9 d-flex align-items-center">
              <select class="form-select form-select-solid border h-40px" id="accountType" data-control="select2" data-hide-search="true">
                <option>Normal Hesap</option>
                <option value="1" <? if($role->partner==1): ?>selected<? endif; ?>>Partner Hesabı</option>
                <option value="2" <? if($role->root==1): ?>selected<? endif; ?>>Kök Kullanıcı</option>
              </select>
              <input type="hidden" name="partner" value="<?=$role->partner ?>" />
              <input type="hidden" name="root" value="<?=$role->root ?>" />
            </div>
          </div>
          <div class="row">
            <div class="accordion accordion-icon-toggle" id="kt_accordion_1">
              <div class="accordion-header pt-3 pb-1 d-flex show" data-bs-toggle="collapse" data-bs-target="#kt_accordion_item_1">
                  <span class="accordion-icon">
                      <span class="svg-icon svg-icon-4">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor"></rect><path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor"></path>
                          </svg>
                      </span>
                  </span>
                  <h3 class="fs-5 form-label fw-bold mb-1 ms-2">Hesap Yönetimi</h3>
              </div>
              <div class="fs-6 show ps-2 ps-md-7" id="kt_accordion_item_1" data-bs-parent="#kt_accordion_1">
                  <ul class="ps-0 ps-md-8">
                      <!--Papara Hesapları-->
                      <li>
                          <div class="d-flex mt-1 mb-3">
                              <label class="form-check form-check-sm form-check-custom form-check-solid fw-semibold min-w-150px me-0 me-md-5">Papara hesaplarını: </label>
                              <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                  <input class="form-check-input" type="checkbox" value="1" <? if($role->view_papara_account==1): ?>checked="checked"<? endif; ?> name="view_papara_account">
                                  <span class="form-check-label">Görür</span>
                              </label>
                              <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                  <input class="form-check-input" type="checkbox" value="1" <? if($role->edit_papara_account==1): ?>checked="checked"<? endif; ?> name="edit_papara_account">
                                  <span class="form-check-label">Düzenler</span>
                              </label>
                              <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                  <input class="form-check-input" type="checkbox" value="1" <? if($role->add_papara_account==1): ?>checked="checked"<? endif; ?> name="add_papara_account">
                                  <span class="form-check-label">Ekler</span>
                              </label>
                              <label class="form-check form-check-sm form-check-danger form-check-custom form-check-solid">
                                  <input class="form-check-input" type="checkbox" value="1" <? if($role->delete_papara_account==1): ?>checked="checked"<? endif; ?> name="delete_papara_account">
                                  <span class="form-check-label">Siler</span>
                              </label>
                          </div>
                      </li>
                      <!--Banka Hesapları-->
                      <li>
                          <div class="d-flex mb-3">
                              <label class="form-check form-check-sm form-check-custom form-check-solid fw-semibold min-w-150px me-0 me-md-5">Banka hesaplarını: </label>
                              <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                  <input class="form-check-input" type="checkbox" value="1" <? if($role->view_bank_account==1): ?>checked="checked"<? endif; ?> name="view_bank_account">
                                  <span class="form-check-label">Görür</span>
                              </label>
                              <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                  <input class="form-check-input" type="checkbox" value="1" <? if($role->edit_bank_account==1): ?>checked="checked"<? endif; ?> name="edit_bank_account">
                                  <span class="form-check-label">Düzenler</span>
                              </label>
                              <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                  <input class="form-check-input" type="checkbox" value="1" <? if($role->add_bank_account==1): ?>checked="checked"<? endif; ?> name="add_bank_account">
                                  <span class="form-check-label">Ekler</span>
                              </label>
                              <label class="form-check form-check-sm form-check-danger form-check-custom form-check-solid">
                                  <input class="form-check-input" type="checkbox" value="1" <? if($role->delete_bank_account==1): ?>checked="checked"<? endif; ?> name="delete_bank_account">
                                  <span class="form-check-label">Siler</span>
                              </label>
                          </div>
                      </li>
                  </ul>
              </div>
            </div>
            <!-- Finansal İşlemler -->
            <div class="accordion accordion-icon-toggle" id="kt_accordion_2">
                <div class="accordion-header pt-3 pb-1 d-flex show" data-bs-toggle="collapse" data-bs-target="#kt_accordion_item_2">
                    <span class="accordion-icon">
                        <span class="svg-icon svg-icon-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor"></path>
                            </svg>
                        </span>
                    </span>
                    <h3 class="fs-5 form-label fw-bold mb-1 ms-2">Finansal İşlemler</h3>
                </div>
                <div class="fs-6 show ps-2 ps-md-7" id="kt_accordion_item_2" data-bs-parent="#kt_accordion_2">
                    <ul class="ps-0 ps-md-8">
                        <!--Yatırımlar-->
                        <li>
                            <div class="d-flex mt-1 mb-3">
                                <label class="form-check form-check-sm form-check-custom form-check-solid fw-semibold min-w-150px me-0 me-md-5">Yatırımları: </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->view_transaction_deposit==1): ?>checked="checked"<? endif; ?> name="view_transaction_deposit">
                                    <span class="form-check-label">Görür</span>
                                </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->edit_transaction_deposit==1): ?>checked="checked"<? endif; ?> name="edit_transaction_deposit">
                                    <span class="form-check-label">Düzenler</span>
                                </label>
                            </div>
                        </li>
                        <!--Çekimler-->
                        <li>
                            <div class="d-flex mt-1 mb-3">
                                <label class="form-check form-check-sm form-check-custom form-check-solid fw-semibold min-w-150px me-0 me-md-5">Çekimleri: </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->view_transaction_withdraw==1): ?>checked="checked"<? endif; ?> name="view_transaction_withdraw">
                                    <span class="form-check-label">Görür</span>
                                </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->edit_transaction_withdraw==1): ?>checked="checked"<? endif; ?> name="edit_transaction_withdraw">
                                    <span class="form-check-label">Düzenler</span>
                                </label>
                            </div>
                        </li>
                        <!--Rezerveler-->
                        <li>
                            <div class="d-flex mt-1 mb-3">
                                <label class="form-check form-check-sm form-check-custom form-check-solid fw-semibold min-w-150px me-0 me-md-5">Rezerveleri: </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->view_reserved==1): ?>checked="checked"<? endif; ?> name="view_reserved">
                                    <span class="form-check-label">Görür</span>
                                </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->edit_reserved==1): ?>checked="checked"<? endif; ?> name="edit_reserved">
                                    <span class="form-check-label">Düzenler</span>
                                </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->add_reserved==1): ?>checked="checked"<? endif; ?> name="add_reserved">
                                    <span class="form-check-label">Ekler</span>
                                </label>
                                <label class="form-check form-check-sm form-check-danger form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->delete_reserved==1): ?>checked="checked"<? endif; ?> name="delete_reserved">
                                    <span class="form-check-label">Siler</span>
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Müşteri Yönetimi -->
            <div class="accordion accordion-icon-toggle" id="kt_accordion_3">
                <div class="accordion-header pt-3 pb-1 d-flex show" data-bs-toggle="collapse" data-bs-target="#kt_accordion_item_3">
                    <span class="accordion-icon">
                        <span class="svg-icon svg-icon-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor"></path>
                            </svg>
                        </span>
                    </span>
                    <h3 class="fs-5 form-label fw-bold mb-1 ms-2">Müşteri Yönetimi</h3>
                </div>
                <div class="fs-6 show ps-2 ps-md-7" id="kt_accordion_item_3" data-bs-parent="#kt_accordion_3">
                    <ul class="ps-0 ps-md-8">
                        <!--Müşteriler-->
                        <li>
                            <div class="d-flex mt-1 mb-3">
                                <label class="form-check form-check-sm form-check-custom form-check-solid fw-semibold min-w-150px me-0 me-md-5">Müşterileri: </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->view_customer==1): ?>checked="checked"<? endif; ?> name="view_customer">
                                    <span class="form-check-label">Görür</span>
                                </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->edit_customer==1): ?>checked="checked"<? endif; ?> name="edit_customer">
                                    <span class="form-check-label">Düzenler</span>
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Raporlama -->
            <div class="accordion accordion-icon-toggle" id="kt_accordion_4">
                <div class="accordion-header pt-3 pb-1 d-flex collapsed" data-bs-toggle="collapse" data-bs-target="#kt_accordion_item_4">
                    <span class="accordion-icon">
                        <span class="svg-icon svg-icon-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor"></path>
                            </svg>
                        </span>
                    </span>
                    <h3 class="fs-5 form-label fw-bold mb-1 ms-2">Raporlama</h3>
                </div>
                <div class="fs-6 collapse ps-2 ps-md-7" id="kt_accordion_item_4" data-bs-parent="#kt_accordion_4">
                    <ul class="ps-0 ps-md-8">
                        <!--Raporlama-->
                        <li>
                            <div class="d-flex mt-1 mb-3">
                                <label class="form-check form-check-sm form-check-custom form-check-solid fw-semibold min-w-150px me-0 me-md-5">Raporları: </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->view_report==1): ?>checked="checked"<? endif; ?> name="view_report">
                                    <span class="form-check-label">Görür</span>
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Kullanıcı Yönetimi -->
            <div class="accordion accordion-icon-toggle" id="kt_accordion_5">
                <div class="accordion-header pt-3 pb-1 d-flex collapsed" data-bs-toggle="collapse" data-bs-target="#kt_accordion_item_5">
                    <span class="accordion-icon">
                        <span class="svg-icon svg-icon-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor"></path>
                            </svg>
                        </span>
                    </span>
                    <h3 class="fs-5 form-label fw-bold mb-1 ms-2">Kullanıcı Yönetimi</h3>
                </div>
                <div class="fs-6 collapse ps-2 ps-md-7" id="kt_accordion_item_5" data-bs-parent="#kt_accordion_5">
                    <ul class="ps-0 ps-md-8">
                        <!--Kullanıcılar-->
                        <li>
                            <div class="d-flex mt-1 mb-3">
                                <label class="form-check form-check-sm form-check-custom form-check-solid fw-semibold min-w-150px me-0 me-md-5">Kullanıcıları: </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->view_user==1): ?>checked="checked"<? endif; ?> name="view_user">
                                    <span class="form-check-label">Görür</span>
                                </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->edit_user==1): ?>checked="checked"<? endif; ?> name="edit_user">
                                    <span class="form-check-label">Düzenler</span>
                                </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->add_user==1): ?>checked="checked"<? endif; ?> name="add_user">
                                    <span class="form-check-label">Ekler</span>
                                </label>
                                <label class="form-check form-check-sm form-check-danger form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->delete_user==1): ?>checked="checked"<? endif; ?> name="delete_user">
                                    <span class="form-check-label">Siler</span>
                                </label>
                            </div>
                        </li>
                        <!--Yetkilendirme-->
                        <li>
                            <div class="d-flex mt-1 mb-3">
                                <label class="form-check form-check-sm form-check-custom form-check-solid fw-semibold min-w-150px me-0 me-md-5">Yetkilendirmeyi: </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->view_role==1): ?>checked="checked"<? endif; ?> name="view_role">
                                    <span class="form-check-label">Görür</span>
                                </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->edit_role==1): ?>checked="checked"<? endif; ?> name="edit_role">
                                    <span class="form-check-label">Düzenler</span>
                                </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->add_role==1): ?>checked="checked"<? endif; ?> name="add_role">
                                    <span class="form-check-label">Ekler</span>
                                </label>
                                <label class="form-check form-check-sm form-check-danger form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->delete_role==1): ?>checked="checked"<? endif; ?> name="delete_role">
                                    <span class="form-check-label">Siler</span>
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Sistem Ayarları -->
            <div class="accordion accordion-icon-toggle" id="kt_accordion_6">
                <div class="accordion-header pt-3 pb-1 d-flex collapsed" data-bs-toggle="collapse" data-bs-target="#kt_accordion_item_6">
                    <span class="accordion-icon">
                        <span class="svg-icon svg-icon-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor"></rect>
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor"></path>
                            </svg>
                        </span>
                    </span>
                    <h3 class="fs-5 form-label fw-bold mb-1 ms-2">Sistem Ayarları</h3>
                </div>
                <div class="fs-6 collapse ps-2 ps-md-7" id="kt_accordion_item_6" data-bs-parent="#kt_accordion_6">
                    <ul class="ps-0 ps-md-8">
                        <!--Sistem Ayarları-->
                        <li>
                            <div class="d-flex mt-1 mb-3">
                                <label class="form-check form-check-sm form-check-custom form-check-solid fw-semibold min-w-150px me-0 me-md-5">Ayarları: </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->view_setting==1): ?>checked="checked"<? endif; ?>  name="view_setting">
                                    <span class="form-check-label">Görür</span>
                                </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->edit_setting==1): ?>checked="checked"<? endif; ?>  name="edit_setting">
                                    <span class="form-check-label">Düzenler</span>
                                </label>
                            </div>
                        </li>
                        <!--Firmalar-->
                        <li>
                            <div class="d-flex mt-1 mb-3">
                                <label class="form-check form-check-sm form-check-custom form-check-solid fw-semibold min-w-150px me-0 me-md-5">Firmaları: </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->view_firm==1): ?>checked="checked"<? endif; ?>  name="view_firm">
                                    <span class="form-check-label">Görür</span>
                                </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->edit_firm==1): ?>checked="checked"<? endif; ?>  name="edit_firm">
                                    <span class="form-check-label">Düzenler</span>
                                </label>
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->add_firm==1): ?>checked="checked"<? endif; ?>  name="add_firm">
                                    <span class="form-check-label">Ekler</span>
                                </label>
                                <label class="form-check form-check-sm form-check-danger form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" <? if($role->delete_firm==1): ?>checked="checked"<? endif; ?>  name="delete_firm">
                                    <span class="form-check-label">Siler</span>
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
          </div>
        </div>
        <div class="text-center pt-10">
            <button type="button" class="btn btn-light me-3" d="modalRoleCancel" data-bs-dismiss="modal">Vazgeç</button>
            <button type="submit" class="btn btn-primary" id="modalRoleSubmit"><?=($role->id>0 ? "Güncelle" : "Ekle") ?></button>
        </div>
    </div>
</form>