<div class="modal-header border-0 pt-4 pb-4" style="background-color: #151521 !important;">
  <h2 class="fw-bold text-white mx-auto">Development Console</h2>
  <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close" data-bs-dismiss="modal">
    <span class="svg-icon svg-icon-1">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" /><rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
      </svg>
    </span>
  </div>
</div>
<div class="modal-body m-0 p-0">
  <div class="fs-6 text-white scroll-y h-550px p-5 pb-10" id="devConsole" style="font-family: 'Courier New', monospace; background-color: #151521 !important;">
    <ul id="console">
      <li id="notice">👋 Hello <span class="fw-bold text-success"><?= getSession('user_name') ?>!</span> Type 'help' to get help.</li>
      <li id="notice">🧑‍💻 Running Paypara v<?= getVer() ?> with 🐘 PHP v<?= PHP_VERSION ?>
        served with ⚙️ <?= $_SERVER['SERVER_SOFTWARE']; ?> and ⚙️ <?= PHP_SAPI ?> on 🐧 <?= PHP_OS ?>
      </li>
      <li id="notice"><?= !isExec() ? '✅' : '❌' ?> Development server 'exec' function is
        <?= !isExec() ? '<span class="text-success fw-bold">enabled 😃</span>' : '<span class="text-danger fw-bold">disabled 😟</span>' ?>
      </li>
      <li id="notice">🐘 PHPInfo: <a href="<?= base_url('dev/phpInfo') ?>" target='_blank'>Dev Env <i class="bi bi-link-45deg text-primary"></i></a> <a href="https://app.paypara.co/dev/phpInfo" target='_blank'>Prod Env <i class="bi bi-link-45deg text-primary"></i></a></li>

      <li id="notice">🏭 API Postman: <a href="https://dev.paypara.co/deploy/documents/dev/postman/api.dev.paypara.co.postman.json" target='_blank'>Dev Env <i class="bi bi-link-45deg text-primary"></i></a> <a href="https://dev.paypara.co/deploy/documents/dev/postman/api.paypara.co.postman.json" target='_blank'>Prod Env <i class="bi bi-link-45deg text-primary"></i></a></li>

      <li id="waiting" class="cmdloading"><br />⚡ Waiting your input ⚡</li>
    </ul>
    <div class="input-group h-50px">
      <span class="theme-dark-show input-group-text bg-transparent border-0 px-0 text-white"><? echo strtolower(getSession('user_name')) ?>@paypara.dev:</span>
      <input id="cmd" type="text" class="form-control fs-4 text-white bg-transparent border-0" placeholder="$" />
  </div>
</div>