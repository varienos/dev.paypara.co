<div class="d-flex flex-column text-center my-auto">
  <img class="h-100px h-md-125px mb-8" src="<?= base_url() ?><?=assetsPath() ?>/iframe/images/svg/warning.svg">
  <p class="fs-2x fw-bolder text-gradient">Geçersiz İşlem</p>
  <p class="fs-3 fw-semibold">Denediğin işlemin süresi doldu veya artık geçersiz<br>Lütfen geri dönerek yeni talep oluştur</p>
</div>

<div class="d-flex flex-row justify-content-center align-items-start w-100 h-15 z-index-1">
  <button id="exit-btn" type="button" onclick="javascript:history.back();" class="btn btn-secondary fs-6 w-100px w-md-125px">Çıkış Yap</button>
</div>