<div class="footer py-0 py-sm-4">
  <div class="container">
    <div class="d-flex flex-column flex-sm-row flex-wrap flex-center justify-content-sm-between text-gray-500 fw-bold fs-7 mb-5 mb-sm-0">
        <div class="d-none d-sm-flex">Rendered in <?php echo(number_format(microtime(true) - CI_INIT_FIRE, 3)); ?> seconds.</div>
        <div>
          <span class="d-none d-sm-inline">Server Time: </span>
          <span class="server-time"><? echo (new DateTime())->format('d.m.Y - H:i:s'); ?></span>
        </div>
        <div class="d-flex align-items-center gap-2">
          <div>v<?= getVer() ?></div>
          <div>Paypara &copy; <?= date('Y') ?></div>
          <div class="latency"><span class="latency-badge badge badge-success badge-circle w-8px h-8px"></span> -</div>
        </div>
    </div>
  </div>
</div>