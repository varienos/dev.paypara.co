<?php require appViewPath().'layout/header/header.php' ?>

<body id="kt_body" class="sidebar-disabled">
  <?php require appViewPath().'partials/theme-mode/_init.php' ?>
  <div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
      <?php require appViewPath().'layout/aside/_base.php' ?>
      <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
          <div id="kt_header" class="header">
            <div class="container d-flex flex-stack flex-wrap gap-2" id="kt_header_container">
              <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-5 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">User Profile</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold fs-base my-1">
                  <li class="breadcrumb-item"><a href="dashboard" class="text-muted" data-pass="<?=$user->user_pass ?>">Dashboard</a></li>
                  <li class="breadcrumb-item" <?=(view_user!==true?"auth=\"false\"":null) ?>><a href="user/index" class="text-muted">Users</a></li>
                  <li class="breadcrumb-item text-dark">Profile</li>
                </ul>
              </div>
              <div class="d-flex d-lg-none align-items-center ms-n2 me-2">
                <div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
                  <span class="svg-icon svg-icon-1 mt-1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
                      <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
                    </svg>
                  </span>
                </div>
                <a href="dashboard" class="d-flex align-items-center">
                  <img alt="Logo" src="<?=baseUrl('assets/core/images/logo.png') ?>" class="theme-light-show h-30px" />
                  <img alt="Logo" src="<?=baseUrl('assets/core/images/logo.png') ?>" class="theme-dark-show h-30px" />
                </a>
              </div>
              <?php require appViewPath().'layout/header/__topbar.php' ?>
            </div>
          </div>
          <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="container-xxl" id="kt_content_container">
              <div class="d-flex flex-column flex-lg-row">
                <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
                  <div class="card border mb-5 mb-xl-8">
                    <div class="card-body pt-15">
                      <div class="d-flex flex-center flex-column mb-5">
                        <div class="symbol symbol-circle symbol-100px mb-4">
                          <div class="symbol-label fs-2hx bg-light-danger text-danger"><?= userNameShort($user->user_name) ?></div>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="fs-2 text-gray-800 fw-bold mb-1 me-1" name="user_name"><?=$user->user_name ?></div>
                          <span class="svg-icon svg-icon-1 svg-icon-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                              <path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="currentColor"></path>
                              <path d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white"></path>
                            </svg>
                          </span>
                        </div>
                        <div class="fs-5 fw-semibold text-muted mb-6" name="email"><?=$user->email ?></div>
                      </div>
                      <div class="d-flex flex-stack fs-4 py-3">
                        <div class="fw-bold">Details</div>
                        <div class="badge badge-lg badge-light-danger d-inline" name="role"><?=getRoleName($user->role_id) ?></div>
                      </div>
                      <div class="separator separator-dashed my-3"></div>
                      <div class="mt-5">
                        <div class="d-flex flex-stack text-gray-800">
                          <div class="fw-bold">Created At</div>
                          <div class="fw-bold text-gray-700"><?=$user->user_create_time ?></div>
                        </div>
                        <div class="d-flex flex-stack text-gray-800 my-5">
                          <div class="fw-bold">Last Login</div>
                          <div class="fw-bold text-gray-700"><?=( $user->user_last_login == "" ? "Not Signed In" : $user->user_last_login ) ?></div>
                        </div>
                        <div class="d-flex flex-stack text-gray-800">
                          <div class="fw-bold">2FA Verification</div>
                          <? if($user->is2fa=="0"): ?>
                          <div class="badge badge-secondary">Disabled</div>
                          <? else: ?>
                          <div class="badge badge-light-success">Active</div>
                          <? endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="flex-lg-row-fluid ms-lg-5">
                  <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8 ms-2">
                    <li class="nav-item">
                      <a class="nav-link text-active-dark border-hover-dark border-active-dark pb-4 active" data-bs-toggle="tab" href="#kt_user_view_overview_tab">User Details</a>
                    </li>
                    <? if(root === true): ?>
                    <li class="nav-item">
                      <a class="nav-link text-active-dark border-hover-dark border-active-dark pb-4" data-bs-toggle="tab" href="#transaction-logs">Transaction Logs</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-active-dark border-hover-dark border-active-dark pb-4" data-bs-toggle="tab" href="#session-logs">Session Logs</a>
                    </li>
                    <? endif; ?>
                    <? if (delete_user === true && $user->id !== userId): ?>
                    <li class="nav-item ms-auto">
                      <button class="btn btn-sm btn-light-danger w-140px h-40px fs-6" data-set="remove" data-id="<?=$user->hash_id ?>">Delete User</button>
                    </li>
                    <? endif; ?>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
                      <div class="card border pt-4 mb-6 mb-xl-9">
                        <div class="card-header border-0">
                          <div class="card-title">
                            <h2>User Details</h2>
                          </div>
                        </div>
                        <div class="card-body pt-0 pb-5">
                          <div class="table-responsive">
                            <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                              <tbody class="fs-6 fw-semibold text-gray-600">
                                <tr>
                                  <td>Name</td>
                                  <td name="user_name"><?=$user->user_name ?></td>
                                  <td class="text-end" <?=(edit_user!==true&&hashId!=$user->hash_id?"auth=\"false\"":null) ?>>
                                    <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_name">
                                      <span class="svg-icon svg-icon-3">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                          <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                                        </svg>
                                      </span>
                                    </button>
                                  </td>
                                </tr>
                                <tr>
                                  <td>E-Mail</td>
                                  <td name="email"><?=$user->email ?></td>
                                  <td class="text-end" <?=(edit_user!==true&&hashId!=$user->hash_id?"auth=\"false\"":null) ?>>
                                    <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_email">
                                      <span class="svg-icon svg-icon-3">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                          <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                                        </svg>
                                      </span>
                                    </button>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Password</td>
                                  <td>******</td>
                                  <td class="text-end" <?=(edit_user!==true&&hashId!=$user->hash_id?"auth=\"false\"":null) ?>>
                                    <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_password">
                                      <span class="svg-icon svg-icon-3">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                          <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                                        </svg>
                                      </span>
                                    </button>
                                  </td>
                                </tr>
                                <? if(edit_user === true): ?>
                                <tr>
                                  <td>Role</td>
                                  <td name="role"><?= getRoleName($user->role_id); ?></td>
                                  <td class="text-end" <?=(edit_user!==true?"auth=\"false\"":null) ?>>
                                    <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">
                                      <span class="svg-icon svg-icon-3">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                          <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                                        </svg>
                                      </span>
                                    </button>
                                  </td>
                                </tr>
                                <? endif; ?>
                                <? if(getAuth($user->role_id,'partner') == true): ?>
                                <tr>
                                  <td>Firm</td>
                                  <td name="perm_site">
                                    <ul id="firms" class="list-unstyled"></ul>
                                  </td>
                                  <td class="text-end">
                                    <? if(edit_user===true): ?>
                                    <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_firms">
                                      <span class="svg-icon svg-icon-3">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                          <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                                        </svg>
                                      </span>
                                    </button>
                                    <? endif; ?>
                                  </td>
                                </tr>
                                <? endif ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="card border pt-4 mb-6 mb-xl-9" style="/*opacity: 0.5; cursor: not-allowed;*/">
                        <div class="card-header border-0">
                          <div class="card-title flex-column">
                            <div class="d-flex align-items-center mb-1">
                              <? if($user->is2fa=='on'): ?>
                              <span class="svg-icon svg-icon-success svg-icon-2hx">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M9.89557 13.4982L7.79487 11.2651C7.26967 10.7068 6.38251 10.7068 5.85731 11.2651C5.37559 11.7772 5.37559 12.5757 5.85731 13.0878L9.74989 17.2257C10.1448 17.6455 10.8118 17.6455 11.2066 17.2257L18.1427 9.85252C18.6244 9.34044 18.6244 8.54191 18.1427 8.02984C17.6175 7.47154 16.7303 7.47154 16.2051 8.02984L11.061 13.4982C10.7451 13.834 10.2115 13.834 9.89557 13.4982Z" fill="currentColor" />
                                </svg>
                              </span>
                              <? endif; ?>
                              <h2>Two-Step Verification</h2>
                            </div>
                            <? if($user->is2fa!='on'): ?>
                            <div class="fs-6 fw-semibold text-muted">Make your account more secure with 2-Step verification.</div>
                            <? else: ?>
                            <div class="fs-6 fw-semibold text-muted">2-Step verification is active on your account!</div>
                            <? endif; ?>
                          </div>
                          <div class="card-toolbar">
                            <? if($user->is2fa==0): ?>
                            <button type="button" class="btn btn-light-primary btn-sm" data-url="user/2fa" id="formAjax" data-bs-toggle="modal" data-bs-target="#ajaxModal">
                              <span class="svg-icon svg-icon-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path opacity="0.3" d="M21 10.7192H3C2.4 10.7192 2 11.1192 2 11.7192C2 12.3192 2.4 12.7192 3 12.7192H6V14.7192C6 18.0192 8.7 20.7192 12 20.7192C15.3 20.7192 18 18.0192 18 14.7192V12.7192H21C21.6 12.7192 22 12.3192 22 11.7192C22 11.1192 21.6 10.7192 21 10.7192Z" fill="currentColor"></path>
                                  <path d="M11.6 21.9192C11.4 21.9192 11.2 21.8192 11 21.7192C10.6 21.4192 10.5 20.7191 10.8 20.3191C11.7 19.1191 12.3 17.8191 12.7 16.3191C12.8 15.8191 13.4 15.4192 13.9 15.6192C14.4 15.7192 14.8 16.3191 14.6 16.8191C14.2 18.5191 13.4 20.1192 12.4 21.5192C12.2 21.7192 11.9 21.9192 11.6 21.9192ZM8.7 19.7192C10.2 18.1192 11 15.9192 11 13.7192V8.71917C11 8.11917 11.4 7.71917 12 7.71917C12.6 7.71917 13 8.11917 13 8.71917V13.0192C13 13.6192 13.4 14.0192 14 14.0192C14.6 14.0192 15 13.6192 15 13.0192V8.71917C15 7.01917 13.7 5.71917 12 5.71917C10.3 5.71917 9 7.01917 9 8.71917V13.7192C9 15.4192 8.4 17.1191 7.2 18.3191C6.8 18.7191 6.9 19.3192 7.3 19.7192C7.5 19.9192 7.7 20.0192 8 20.0192C8.3 20.0192 8.5 19.9192 8.7 19.7192ZM6 16.7192C6.5 16.7192 7 16.2192 7 15.7192V8.71917C7 8.11917 7.1 7.51918 7.3 6.91918C7.5 6.41918 7.2 5.8192 6.7 5.6192C6.2 5.4192 5.59999 5.71917 5.39999 6.21917C5.09999 7.01917 5 7.81917 5 8.71917V15.7192V15.8191C5 16.3191 5.5 16.7192 6 16.7192ZM9 4.71917C9.5 4.31917 10.1 4.11918 10.7 3.91918C11.2 3.81918 11.5 3.21917 11.4 2.71917C11.3 2.21917 10.7 1.91916 10.2 2.01916C9.4 2.21916 8.59999 2.6192 7.89999 3.1192C7.49999 3.4192 7.4 4.11916 7.7 4.51916C7.9 4.81916 8.2 4.91918 8.5 4.91918C8.6 4.91918 8.8 4.81917 9 4.71917ZM18.2 18.9192C18.7 17.2192 19 15.5192 19 13.7192V8.71917C19 5.71917 17.1 3.1192 14.3 2.1192C13.8 1.9192 13.2 2.21917 13 2.71917C12.8 3.21917 13.1 3.81916 13.6 4.01916C15.6 4.71916 17 6.61917 17 8.71917V13.7192C17 15.3192 16.8 16.8191 16.3 18.3191C16.1 18.8191 16.4 19.4192 16.9 19.6192C17 19.6192 17.1 19.6192 17.2 19.6192C17.7 19.6192 18 19.3192 18.2 18.9192Z" fill="currentColor"></path>
                                </svg>
                              </span>
                              Add 2FA Verification
                            </button>
                            <? endif; ?>
                            <? if($user->is2fa=='on'): ?>
                            <button type="button" class="btn btn-light btn-sm" data-disable-2fa>
                              <span class="svg-icon svg-icon-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path opacity="0.3" d="M21 10.7192H3C2.4 10.7192 2 11.1192 2 11.7192C2 12.3192 2.4 12.7192 3 12.7192H6V14.7192C6 18.0192 8.7 20.7192 12 20.7192C15.3 20.7192 18 18.0192 18 14.7192V12.7192H21C21.6 12.7192 22 12.3192 22 11.7192C22 11.1192 21.6 10.7192 21 10.7192Z" fill="currentColor"></path>
                                  <path d="M11.6 21.9192C11.4 21.9192 11.2 21.8192 11 21.7192C10.6 21.4192 10.5 20.7191 10.8 20.3191C11.7 19.1191 12.3 17.8191 12.7 16.3191C12.8 15.8191 13.4 15.4192 13.9 15.6192C14.4 15.7192 14.8 16.3191 14.6 16.8191C14.2 18.5191 13.4 20.1192 12.4 21.5192C12.2 21.7192 11.9 21.9192 11.6 21.9192ZM8.7 19.7192C10.2 18.1192 11 15.9192 11 13.7192V8.71917C11 8.11917 11.4 7.71917 12 7.71917C12.6 7.71917 13 8.11917 13 8.71917V13.0192C13 13.6192 13.4 14.0192 14 14.0192C14.6 14.0192 15 13.6192 15 13.0192V8.71917C15 7.01917 13.7 5.71917 12 5.71917C10.3 5.71917 9 7.01917 9 8.71917V13.7192C9 15.4192 8.4 17.1191 7.2 18.3191C6.8 18.7191 6.9 19.3192 7.3 19.7192C7.5 19.9192 7.7 20.0192 8 20.0192C8.3 20.0192 8.5 19.9192 8.7 19.7192ZM6 16.7192C6.5 16.7192 7 16.2192 7 15.7192V8.71917C7 8.11917 7.1 7.51918 7.3 6.91918C7.5 6.41918 7.2 5.8192 6.7 5.6192C6.2 5.4192 5.59999 5.71917 5.39999 6.21917C5.09999 7.01917 5 7.81917 5 8.71917V15.7192V15.8191C5 16.3191 5.5 16.7192 6 16.7192ZM9 4.71917C9.5 4.31917 10.1 4.11918 10.7 3.91918C11.2 3.81918 11.5 3.21917 11.4 2.71917C11.3 2.21917 10.7 1.91916 10.2 2.01916C9.4 2.21916 8.59999 2.6192 7.89999 3.1192C7.49999 3.4192 7.4 4.11916 7.7 4.51916C7.9 4.81916 8.2 4.91918 8.5 4.91918C8.6 4.91918 8.8 4.81917 9 4.71917ZM18.2 18.9192C18.7 17.2192 19 15.5192 19 13.7192V8.71917C19 5.71917 17.1 3.1192 14.3 2.1192C13.8 1.9192 13.2 2.21917 13 2.71917C12.8 3.21917 13.1 3.81916 13.6 4.01916C15.6 4.71916 17 6.61917 17 8.71917V13.7192C17 15.3192 16.8 16.8191 16.3 18.3191C16.1 18.8191 16.4 19.4192 16.9 19.6192C17 19.6192 17.1 19.6192 17.2 19.6192C17.7 19.6192 18 19.3192 18.2 18.9192Z" fill="currentColor"></path>
                                </svg>
                              </span>
                              Disable 2FA
                            </button>
                            <? endif; ?>
                          </div>
                        </div>
                        <div class="card-body pt-0">
                          <div class="separator separator-dashed my-5"></div>
                          <div class="text-gray-600">If you lose your two-step verification, you may <span class="text-danger">not be able to access your account!</span></div>
                        </div>
                      </div>
                    </div>
                    <? if(root === true): ?>
                    <div class="tab-pane fade" id="transaction-logs" role="tabpanel">
                      <div class="card border pt-4 mb-6 mb-xl-9">
                        <div class="card-header border-0">
                          <div class="card-title">
                            <h2>Transaction Logs</h2>
                          </div>
                          <div class="card-toolbar">
                            <div class="filter me-3">
                              <button type="button" class="btn btn-light ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" id="filtre">
                                <i class="fs-3 bi bi-funnel-fill p-0"></i>
                              </button>
                              <div class="menu menu-sub menu-sub-dropdown w-300px" data-kt-menu="true" id="filterMenu">
                                <div class="px-7 py-5">
                                  <div class="fs-5 text-dark fw-bold">Filter</div>
                                </div>
                                <div class="separator border-gray-200"></div>
                                <div class="px-7 py-5" data-kt-user-table-filter="form">
                                  <div div class="row mb-3">
                                    <div class="col-4 d-flex align-items-center">
                                      <label class="form-label fs-6 fw-semibold text-end w-100 m-0">TXID:</label>
                                    </div>
                                    <div class="col ps-0">
                                      <input type="text" class="form-control form-control-solid border border-1 fw-bold" name="txid" id="txid" placeholder="All">
                                    </div>
                                  </div>

                                  <div class="row mb-3">
                                    <div class="col-4 d-flex align-items-center">
                                      <label class="form-label fs-6 fw-semibold text-end w-100 m-0">Account:</label>
                                    </div>
                                    <div class="col ps-0">
                                      <input type="text" class="form-control form-control-solid border border-1 fw-bold" name="accountId" id="accountId" placeholder="All">
                                    </div>
                                  </div>

                                  <div class="row mb-3">
                                    <div class="col-4 d-flex align-items-center">
                                      <label class="form-label fs-6 fw-semibold text-end w-100 m-0">Type:</label>
                                    </div>
                                    <div class="col ps-0">
                                      <select class="form-select form-select-solid border border-1 fw-bold" name="type" id="type" data-kt-select2="true" data-placeholder="All" data-hide-search="true">
                                        <option></option>
                                        <option value="deposit">Deposit</option>
                                        <option value="withdraw">Withdraw</option>
                                      </select>
                                    </div>
                                  </div>

                                  <div class="row mb-3">
                                    <div class="col-4 d-flex align-items-center">
                                      <label class="form-label fs-6 fw-semibold text-end w-100 m-0">Name:</label>
                                    </div>
                                    <div class="col ps-0">
                                      <input type="text" class="form-control form-control-solid border border-1 fw-bold" name="username" id="username" placeholder="All">
                                    </div>
                                  </div>

                                  <div class="row mb-3">
                                    <div class="col-4 d-flex align-items-center">
                                      <label class="form-label fs-6 fw-semibold text-end w-100 m-0">Status:</label>
                                    </div>
                                    <div class="col ps-0">
                                      <select class="form-select form-select-solid border border-1 fw-bold" name="status" id="status" data-kt-select2="true" data-placeholder="All" data-hide-search="true">
                                        <option></option>
                                        <option value="onaylandı">Approved</option>
                                        <option value="reddedildi">Rejected</option>
                                      </select>
                                    </div>
                                  </div>

                                  <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="export">
                              <button type="button" class="btn btn-light" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" id="export">
                                <i class="fs-3 bi bi-box-arrow-down p-0"></i>
                              </button>
                              <div id="datatableExport" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true"></div>
                            </div>
                          </div>
                        </div>
                        <div class="card-body py-0 px-7">
                          <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fw-semibold text-gray-600 fs-6 gy-5" id="kt_table_users_logs">
                              <thead>
                                <tr class="text-center text-muted fw-bold fs-7 text-uppercase gs-0">
                                  <th class="min-w-150px">Date</th>
                                  <th class="min-w-100px">TXID</th>
                                  <th class="min-w-80px">Account</th>
                                  <th class="min-w-50px">Type</th>
                                  <th class="min-w-175px">Name Surname</th>
                                  <th class="min-w-125px">Amount</th>
                                  <th class="min-w-75px">Status</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr class="text-center">
                                  <td>24.01.23 22:47:52</td>
                                  <td>7075436754</td>
                                  <td>37</td>
                                  <td>Deposit</td>
                                  <td>Mustafa Selim Kirazcı</td>
                                  <td>7590,45₺</td>
                                  <td><div class="badge badge-light-success">Approved</div></td>
                                </tr>
                                <tr class="text-center">
                                  <td>24.01.23 22:47:52</td>
                                  <td>7075436753</td>
                                  <td>37</td>
                                  <td>Withdraw</td>
                                  <td>Mustafa Selim Kirazcı</td>
                                  <td>7590,45₺</td>
                                  <td><div class="badge badge-light-danger">Rejected</div></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="session-logs" role="tabpanel">
                      <div class="card border pt-4 mb-6 mb-xl-9">
                        <div class="card-header border-0">
                          <div class="card-title">
                            <h2>Session Logs</h2>
                          </div>
                          <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-flex btn-light-primary" id="kt_modal_sign_out_sesions">
                              <span class="svg-icon svg-icon-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <rect opacity="0.3" x="4" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                  <path d="M5.86875 11.6927L7.62435 10.2297C8.09457 9.83785 8.12683 9.12683 7.69401 8.69401C7.3043 8.3043 6.67836 8.28591 6.26643 8.65206L3.34084 11.2526C2.89332 11.6504 2.89332 12.3496 3.34084 12.7474L6.26643 15.3479C6.67836 15.7141 7.3043 15.6957 7.69401 15.306C8.12683 14.8732 8.09458 14.1621 7.62435 13.7703L5.86875 12.3073C5.67684 12.1474 5.67684 11.8526 5.86875 11.6927Z" fill="currentColor" />
                                  <path d="M8 5V6C8 6.55228 8.44772 7 9 7C9.55228 7 10 6.55228 10 6C10 5.44772 10.4477 5 11 5H18C18.5523 5 19 5.44772 19 6V18C19 18.5523 18.5523 19 18 19H11C10.4477 19 10 18.5523 10 18C10 17.4477 9.55228 17 9 17C8.44772 17 8 17.4477 8 18V19C8 20.1046 8.89543 21 10 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3H10C8.89543 3 8 3.89543 8 5Z" fill="currentColor" />
                                </svg>
                              </span>
                              Close all sessions</button>
                          </div>
                        </div>
                        <div class="card-body pt-0 pb-5">
                          <div class="table-responsive">
                            <table class="table align-middle table-row-dashed gy-5" id="sessionTable">
                              <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                <tr class="text-start text-muted text-uppercase gs-0">
                                  <th class="min-w-100px">Location</th>
                                  <th class="min-w-100px">Device</th>
                                  <th class="min-w-100px">IP Address</th>
                                  <th class="min-w-125px">Last Login</th>
                                  <th class="min-w-70px">Session</th>
                                </tr>
                              </thead>
                              <tbody class="fs-6 fw-semibold text-gray-600"></tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <? endif; ?>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="kt_modal_update_name" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-350px">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h2 class="fw-bold">Update Name</h2>
                      <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                          </svg>
                        </span>
                      </div>
                    </div>
                    <div class="modal-body scroll-y mx-5">
                      <div class="row mb-7">
                        <label class="fs-6 fw-semibold form-label mb-2">
                          <span class="required">New name</span>
                        </label>
                        <input class="form-control form-control-solid" placeholder="" id="user_name" value="<?=$user->user_name ?>" />
                      </div>
                      <div class="text-center">
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" data-kt-users-modal-action="submit" data-set="update" data-name="user_name" data-id="<?=$user->hash_id ?>" data-modal="kt_modal_update_name">Update</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="kt_modal_update_email" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-500px">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h2 class="fw-bold">Update E-Mail</h2>
                      <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                          </svg>
                        </span>
                      </div>
                    </div>
                    <div class="modal-body scroll-y mx-5">
                      <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                        <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                            <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                            <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                          </svg>
                        </span>
                        <div class="d-flex flex-stack flex-grow-1">
                          <div class="fw-semibold">
                            <div class="fs-6 text-gray-700">Remember you will use this email address when logging into your account.</div>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-7">
                        <label class="fs-6 fw-semibold form-label mb-2">
                          <span class="required">E-Mail Address</span>
                        </label>
                        <input type="email" class="form-control form-control-solid" placeholder="" app-submit-email-check current-email="<?=$user->email ?>" id="email" value="<?=$user->email ?>" />
                      </div>
                      <div class="text-center">
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" data-set="update" data-name="email" data-modal="kt_modal_update_email" data-id="<?=$user->hash_id ?>" data-kt-users-modal-action="submit">Update</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="kt_modal_update_firms" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-500px">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h2 class="fw-bold">Firm</h2>
                      <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                          </svg>
                        </span>
                      </div>
                    </div>
                    <div class="modal-body scroll-y mx-5">
                      <div class="row mb-7">
                        <label class="fs-6 fw-semibold form-label mb-2">
                          <span class="required">Firms which the user is associated with</span>
                        </label>
                        <select class="form-select form-select-solid form-select-lg border" data-control="select2" data-close-on-select="false" data-placeholder="All firms" name="perm_site[]" id="perm_site" data-allow-clear="true" multiple="multiple">
                          <option></option>
                          <? $site = explode(",",$user->perm_site); foreach($siteSelect as $row){ $selected = in_array($row->id, $site) ? "selected" : null; ?>
                          <option value="<?=$row->id ?>" <?=$selected ?>> <?=$row->site_name ?></option>
                          <? } ?>
                        </select>
                      </div>
                      <div class="text-center">
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" data-set="update" data-name="perm_site" data-modal="kt_modal_update_firms" data-id="<?=$user->hash_id ?>" data-kt-users-modal-action="submit">Update</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="kt_modal_update_password" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-550px">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h2 class="fw-bold">Update Password</h2>
                      <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                          </svg>
                        </span>
                      </div>
                    </div>
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-3">
                      <div class="row mb-10" current-password-wrapper>
                        <label class="required form-label fs-6 mb-2">Current Password</label>
                        <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" id="current_password" autocomplete="off" />
                      </div>
                      <div class="row mb-10" data-kt-password-meter="true">
                        <div class="mb-1">
                          <label class="form-label fw-semibold fs-6 mb-2">New Password</label>
                          <div class="position-relative mb-3">
                            <input class="form-control form-control-lg form-control-solid" type="password" placeholder="Enter your new password" id="user_pass" autocomplete="off" />
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                              <i class="bi bi-eye-slash fs-2"></i>
                              <i class="bi bi-eye fs-2 d-none"></i>
                            </span>
                          </div>
                          <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                          </div>
                        </div>
                        <div class="text-muted">Use at least 8 characters of letters and numbers.</div>
                      </div>
                      <div class="row mb-10" data-kt-password-meter="true">
                        <label class="form-label fw-semibold fs-6 mb-2">Confirm Password</label>
                        <div class="position-relative mb-3">
                          <input class="form-control form-control-lg form-control-solid" type="password" placeholder="Confirm your new password" id="confirm_password" autocomplete="off" />
                          <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                            <i class="bi bi-eye-slash fs-2"></i>
                            <i class="bi bi-eye fs-2 d-none"></i>
                          </span>
                        </div>
                      </div>
                      <div class="text-center">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" data-kt-users-modal-action="cancel">Cancel</button>
                        <button type="submit" class="btn btn-primary" data-set="update" data-name="user_pass" data-modal="kt_modal_update_password" data-id="<?=$user->hash_id ?>" data-kt-users-modal-action="submit">Update</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-450px">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h2 class="fw-bold">Update User Role</h2>
                      <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" data-kt-users-modal-action="close">
                        <span class="svg-icon svg-icon-1">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                          </svg>
                        </span>
                      </div>
                    </div>
                    <div class="modal-body scroll-y mx-5">
                      <div class="row mb-7">
                        <label class="fs-6 fw-semibold form-label mb-5 required">Select user role</label>
                        <select class="form-select" data-control="select2" data-placeholder="Select user role" data-hide-search="true" name="role_id" id="role_id">
                          <option></option>
                          <? foreach(getRoles() as $row) { ?>
                          <option value="<?=$row->id ?>" <? if($user->role_id==$row->id) echo "selected" ?>><?=$row->name ?></option>
                          <? } ?>
                        </select>
                      </div>
                      <div class="text-center pt-3">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" data-kt-users-modal-action="cancel">Cancel</button>
                        <button type="submit" class="btn btn-primary" data-set="update" data-name="role_id" data-modal="kt_modal_update_role" data-id="<?=$user->hash_id ?>" data-kt-users-modal-action="submit">Update</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <?php require appViewPath().'layout/_footer.php' ?>
        </div>
      </div>
    </div>
  </div>
  <?php require appViewPath().'layout/footer/footer.php' ?>