<form class="form" action="javascript:" id="modalForm" method="post" enctype="multipart/form-data">
    <input type="hidden" value="<?=$update->id ?>" name="id"></input>
    <input type="hidden" value="reject" name="response"></input>
    <input type="hidden" value="reddedildi" name="status"></input>
    <input type="hidden" value="deposit" name="request"></input>
    <div class="modal-header d-flex align-items-start border-bottom-0 p-7" id="kt_modal_add_customer_header">
        <div class="d-flex flex-column">
            <h2 class="fs-4 fw-bold mb-2">Transaction #<?=$update->transaction_id ?></h2>
            <h2 class="fs-7 fw-semibold text-gray-600"><?= $update->request_time ?></h2>
        </div>
        <button type="button" class="btn btn-icon btn-sm btn-active-icon-primary align-items-start" data-bs-dismiss="modal">
            <span class="svg-icon svg-icon-2qx svg-icon-dark">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="1" d="M6 19.7C5.7 19.7 5.5 19.6 5.3 19.4C4.9 19 4.9 18.4 5.3 18L18 5.3C18.4 4.9 19 4.9 19.4 5.3C19.8 5.7 19.8 6.29999 19.4 6.69999L6.7 19.4C6.5 19.6 6.3 19.7 6 19.7Z" fill="currentColor" />
                    <path d="M18.8 19.7C18.5 19.7 18.3 19.6 18.1 19.4L5.40001 6.69999C5.00001 6.29999 5.00001 5.7 5.40001 5.3C5.80001 4.9 6.40001 4.9 6.80001 5.3L19.5 18C19.9 18.4 19.9 19 19.5 19.4C19.3 19.6 19 19.7 18.8 19.7Z" fill="currentColor" />
                </svg>
            </span>
        </button>
    </div>
    <div class="modal-body py-0 px-7">
        <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">
            <div id="reject-info" class="d-flex flex-column flex-center h-95px mb-5">
                <div class="fs-3 fw-bolder mb-1"><?=$update->gamer_name ?></div>
                <div class="fs-4 fw-bold">₺<?=number_format($update->price,2) ?></div>
            </div>
            <div class="separator theme-light-show border-dark mt-6 mb-5"></div>
            <div class="separator theme-dark-show border-light mt-6 mb-5"></div>
            <div class="d-flex flex-column">
                <!--Tutar-->
                <div class="d-flex mb-3">
                    <div class="d-flex align-items-center me-1">
                        <span class="svg-icon svg-icon-3x svg-icon-dark me-1">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img">
                                <path fill="currentColor" d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10s10-4.47 10-10S17.53 2 12 2m3.1 5.07c.14 0 .28.05.4.16l1.27 1.27c.23.22.23.57 0 .78l-1 1l-2.05-2.05l1-1c.1-.11.24-.16.38-.16m-1.97 1.74l2.06 2.06l-6.06 6.06H7.07v-2.06l6.06-6.06Z"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="d-flex flex-column">
                        <label class="fs-5 fw-semibold">Amount</label>
                        <div class="input-group input-group-solid input-group-sm w-100">
                            <span class="mt-1 me-2">&bull;</span>
                            <input type="text" class="form-control border-0 bg-transparent fs-6 text-gray-600 h-25px p-0" maxlength="9" name="price" value="<?=number_format($update->price,2) ?>">
                        </div>
                    </div>
                </div>
                <!--Açıklama-->
                <div class="d-flex">
                    <div class="d-flex me-1">
                        <span class="svg-icon svg-icon-3x svg-icon-dark mt-1 me-1">
                            <svg viewBox="-23 15 250 250" xmlns="http://www.w3.org/2000/svg">
                                <path fill="currentColor" d="M 104.156 37.32 C 25.11 37.314 -25.047 122.009 12.956 191.32 C 12.725 191.5 23.062 206.457 23.238 206.32 C 23.402 206.613 33.391 216.889 37.507 221.025 C 41.606 225.144 54.156 232.52 54.156 232.52 C 124.361 270.999 209.895 219.048 208.116 139.009 C 206.859 82.492 160.687 37.328 104.156 37.32 Z M 136.156 165.32 L 72.156 165.32 C 65.997 165.32 62.148 158.653 65.227 153.32 C 66.657 150.845 69.298 149.32 72.156 149.32 L 136.156 149.32 C 142.314 149.32 146.163 155.987 143.084 161.32 C 141.655 163.795 139.014 165.32 136.156 165.32 Z M 136.156 133.32 L 72.156 133.32 C 65.997 133.32 62.148 126.653 65.227 121.32 C 66.657 118.845 69.298 117.32 72.156 117.32 L 136.156 117.32 C 142.314 117.32 146.163 123.987 143.084 129.32 C 141.655 131.795 139.014 133.32 136.156 133.32 Z"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="d-flex flex-column w-100">
                        <label class="fs-5 fw-semibold">Description</label>
                        <div class="d-flex align-items-center input-group input-group-solid input-group-sm">
                            <span class="me-2">&bull;</span>
                            <input type="text" class="form-control bg-transparent fs-6 text-gray-600 border-0 h-25px p-0" name="notes" placeholder="Add a description" value="<?=$update->notes ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer border-top-0 d-flex flex-nowrap flex-center px-7 pb-7 pt-6">
        <button type="button" class="btn btn-sm btn-secondary rounded-0 fs-6 fw-bold w-100 h-40px p-0 m-0 me-3" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" id="modalSubmit"class="btn btn-sm btn-dark btn-active-secondary rounded-0 fs-6 fw-bold w-100 h-40px p-0 m-0">Reject</button>
    </div>
</form>