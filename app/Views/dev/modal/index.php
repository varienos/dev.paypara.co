<div class="modal-header">
  <h2 class="fw-bold" style="font-family: 'VT323', monospace;"> >_ DEV CONSOLE</h2>
  <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close" data-bs-dismiss="modal">
    <span class="svg-icon svg-icon-1">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
      </svg>
    </span>
  </div>
</div>
<div class="modal-body scroll-y mx-0 mx-md-5">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
  <div>
    <div class="mb-5">
      <div class="flex-column current" data-kt-stepper-element="content">
        <div class="scroll-y h-500px mb-10" id="devConsole" style="background:#041526; font-family: 'VT323', monospace; font-size:15px; color:#a5c5e5; padding: 15px; border-radius:10px">
          <ul id="console">
            <li>Hello
              <?= getSession('user_name') ?>
              ! Need Help ? cmd 'help' first.
            </li>
            <li>Paypara v.<?= getVer() ?> ~ PHP
              v.<?= PHP_VERSION ?>
              <?= $_SERVER['SERVER_SOFTWARE']; ?>
              ~ OS:<?= PHP_OS ?> ~
              LSIP:<?= PHP_SAPI  ?>
            </li>
            <li>Development server 'exec' function
              <?= !isExec() ? '<span style="color:green">enable</span>' : '<span style="color:red">disable</span>' ?>
            </li>
            <li>phpinfo::development <a href='<?= base_url('dev/phpInfo') ?>' target='_blank'><i class="bi bi-link-45deg"></i> dev.paypara.co/dev/phpInfo</a></li>
            <li>phpinfo::production <a href='https://app.paypara.co/dev/phpInfo' target='_blank'><i class="bi bi-link-45deg"></i> app.paypara.co/dev/phpInfo</a></li>
            <li>api.postman::development <a href='https://dev.paypara.co/deploy/documents/dev/postman/api.dev.paypara.co.postman.json' target='_blank'><i class="bi bi-paperclip"></i> api.dev.paypara.co.postman.json</a></li>
            <li>api.postman::production <a href='https://dev.paypara.co/deploy/documents/dev/postman/api.paypara.co.postman.json' target='_blank'><i class="bi bi-paperclip"></i> api.paypara.co.postman.json</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="mb-5">
      <div class="flex-column current" data-kt-stepper-element="content">
        <input type="text" style="font-family: 'VT323', monospace;" class="form-control form-control-solid" placeholder="cmd" id="cmd">
      </div>
    </div>
  </div>
</div>