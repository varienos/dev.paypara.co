<div class="footer py-0 py-sm-4 d-flex flex-lg-column" id="kt_footer">
  <div class="container d-flex flex-row flex-wrap flex-center justify-content-between">
    <div class="order-2 order-sm-1 mb-2 mb-sm-0">
      <span class="text-gray-400 fw-bold fs-7">Rendered in <?php echo(number_format(microtime(true) - CI_INIT_FIRE, 3)); ?> seconds</span>
    </div>
    <div class="d-flex align-items-center text-dark order-2 order-sm-1">
      <div class="text-gray-400 fw-bold fs-6 h-100">Paypara &copy; <?= date('Y') ?></div>
      <div class="badge badge-light ms-3 p-2">v<?= getVer() ?></div>
    </div>
  </div>
</div>