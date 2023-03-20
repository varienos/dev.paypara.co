<!-- Pending Transaction -->
<div class="d-flex flex-column text-center">
  <p class="fs-6 text-muted mb-2">TXID: #<?= $pendingTransaction ?></p>
  <img class="h-100px h-md-150px mb-3" src="<?= base_url() ?><?=assetsPath() ?>/iframe/images/svg/pending-tx.svg">
  <div class="mw-550px fw-normal fs-5 fs-sm-3">
    <p class="m-0 mb-2 mb-md-4"><span class="text-gradient fw-bold">Aktif yatırım talebin var ve şu an kontrol ediliyor.</span></p>
    <p class=" m-0 mb-4 mb-md-6">Ödemeni yaptıysan endişelenme, bakiyen bir kaç dakika içerisinde hesabına yansımış olacak.</p>
    <p class="m-0">Sabrın için teşekkürler <i class="bi bi-heart-fill fs-4 text-danger"></i></p>
  </div>
</div>