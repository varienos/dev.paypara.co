<form class="form" action="javascript:" id="2fa" method="post" enctype="multipart/form-data" data-secret="<?=$secret ?>">
    <div class="modal-header">
        <h2 class="fw-bold">Kimlik Doğrulama Ekle</h2>
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close" data-bs-dismiss="modal">
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
    <div class="modal-body scroll-y mx-5 mx-xl-10 my-2">
        <div class="fw-semibold fs-3 text-gray-800 d-flex flex-column justify-content-center mb-5">
            <div class="text-center mb-5" data-kt-add-auth-action="qr-code-label">
                <div class="mb-5 fs-6">
                    <ul class="list-unstyled d-flex justify-content-center gap-5">
                        <li>
                            <a href="https://apps.apple.com/us/app/google-authenticator/id388497605" target="_blank"
                                class="text-reset text-hover-dark"><i class="bi bi-apple fs-3 me-2"></i>iOS</a>
                        </li>
                        <li>
                            <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2"
                                target="_blank" class="text-reset text-hover-dark"><i
                                    class="bi bi-android2 fs-3 me-2"></i>Android</a>
                        </li>
                        <li>
                            <? if(getBrowser=='Chrome'): ?>
                                <a href="https://chrome.google.com/webstore/detail/authenticator/bhghoamapcdpbohphigoooaddinpkbai" target="_blank" class="text-reset text-hover-dark"><i class="bi bi-browser-chrome fs-3 me-2"></i>Chrome</a>
                            <? endif; ?>
                            <? if(getBrowser=='Firefox'): ?>
                                <a href="https://addons.mozilla.org/en-US/firefox/addon/auth-helper" target="_blank" class="text-reset text-hover-dark"><i class="bi bi-browser-firefox fs-3 me-2"></i>Firefox</a>
                            <? endif; ?>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="text-center mb-8" data-set-2fa-qr>
                Cihazınıza Authenticator uygulaması kurun ve aşağıdaki QR kodunu taratın.
            </div>
            <div class="d-flex flex-center mb-5" data-set-2fa-qr>
                <img src="<?= $qr ?>" class="h-200px" alt="Bu QR kodunu taratın" />
            </div>
            <div class="text-center mb-5 d-none" data-set-2fa-manual>
                Authenticator uygulamasını açın, yeni hesap ekleye tıklayın ve aşağıdaki kodu yazın.
            </div>
            <div class="border rounded p-5 d-flex  d-none flex-center" data-set-2fa-manual>
                <div class="fs-1"><?= $manuel ?></div>
            </div>
            <div class="text-center mb-8 d-none" data-set-2fa-verify>
                Authenticator uygulamasında gözüken kodu girin ve işlemi doğrulayın.
            </div>
            <div class="d-flex flex-center mb-5 d-none" data-set-2fa-verify>
                <input type="num" class="form-control form-control-solid text-center w-50 mx-auto" verificationCode maxlength="6" name="verificationCode" id="verificationCode" autocomplete="off" placeholder="Kodu girin"/>
            </div>
        </div>
        <div class="d-flex flex-center">
            <div class="btn btn-light-primary" data-set-2fa-qr data-action-button-qr>Kodu Manuel Gir</div>
            <div class="btn btn-light-primary d-none" data-set-2fa-manual data-action-button-manual>Barkod Tarat</div>
            <div class="btn btn-light-info ms-2" data-set-2fa-next data-action-button-next>Etkinleştir</div>
            <div class="btn btn-light-primary d-none" data-set-2fa-verify data-action-button-back>Geri Dön</div>
            <div class="btn btn-light-success ms-2 d-none" data-set-2fa-verify data-action-button-verify>Doğrula</div>
        </div>
    </div>
</form>