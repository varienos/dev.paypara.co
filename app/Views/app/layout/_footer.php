<div class="footer py-0 py-sm-4 d-flex flex-lg-column" id="kt_footer">
  <div class="container d-flex flex-column flex-sm-row flex-wrap flex-center justify-content-sm-between mb-5 mb-sm-0">
    <div class="order-2 order-sm-1 mb-2 mb-sm-0">
      <span class="text-gray-500 fw-bold fs-7">Rendered in <?php echo(number_format(microtime(true) - CI_INIT_FIRE, 3)); ?> seconds.
        <span class="latency">Server latency: <span class="latency-badge badge badge-success badge-circle w-8px h-8px"></span> -</span>
      </span>
    </div>
    <div class="order-2 order-sm-1">
      <div class="d-flex align-items-center">
        <div class="text-gray-500 fw-bold fs-6 h-100">Paypara &copy; <?= date('Y') ?></div>
        <div class="badge badge-light ms-3 p-2">v<?= getVer() ?></div>
      </div>
    </div>
  </div>
</div>