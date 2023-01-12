<?php require appViewPath().'layout/header/header.php' ?>

<body id="kt_body" class="sidebar-disabled">
<?php require appViewPath().'partials/theme-mode/_init.php' ?> <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid"> <?php require appViewPath().'layout/aside/_base.php' ?> <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div id="kt_header" class="header">
                        <div class="container d-flex flex-stack flex-wrap gap-2" id="kt_header_container">
                            <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-5 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                                <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1" data-page-title data-account-type></h1>
                                <ul class="breadcrumb breadcrumb-dot fw-semibold fs-base my-1">
                                    <li class="breadcrumb-item text-muted">
                                        <a href="dashboard" class="text-muted">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item text-muted">Transactions</li>
                                    <li class="breadcrumb-item text-dark" data-page-title></li>
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
                                    <img alt="Logo" src="<?=baseUrl('assets/branding/logo.png') ?>" class="theme-light-show h-30px" />
                                    <img alt="Logo" src="<?=baseUrl('assets/branding/logo.png') ?>" class="theme-dark-show h-30px" />
                                </a>
                            </div> <?php require appViewPath().'layout/header/__topbar.php' ?>
                        </div>
                    </div>
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <div class="container-xxl" id="kt_content_container">
                            <div class="card border">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-title w-100 w-xxl-auto">
                                        <div class="d-flex align-items-center w-100 w-xxl-auto my-1">
                                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <input type="text" data-kt-customer-table-filter="search" id="search" id="searchStr" class="form-control form-control-solid border border-1 w-100 w-xxl-225px ps-15" placeholder="Search transaction" />
                                        </div>
                                    </div>
                                    <div class="card-toolbar w-100 w-xxl-auto">
                                        <div class="d-flex flex-wrap justify-content-center justify-content-xxl-end gap-3 w-100 w-xxl-auto">
                                            <input class="form-control form-control-solid border border-1 mw-225px" placeholder="Select a date range" value="<?=date("Y-m-d") ?>" name="transactionDate" id="transactionDate" />
                                            <button type="button" class="btn btn-light mw-125px" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" id="filtre">
                                                <span class="svg-icon svg-icon-2">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor" />
                                                    </svg>
                                                </span>Filter</button>
                                            <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="filterMenu">
                                                <div class="px-7 py-5">
                                                    <div class="fs-5 text-dark fw-bold">Filter Settings</div>
                                                </div>
                                                <div class="separator border-gray-200"></div>
                                                <div class="px-7 py-5" data-kt-user-table-filter="form">
                                                    <div class="row mb-3">
                                                        <div class="col-4 d-flex align-items-center">
                                                            <label class="form-label fs-6 fw-semibold text-end w-100 m-0">Method:</label>
                                                        </div>
                                                        <div class="col ps-0">
                                                            <select class="form-select form-select-solid border border-1 fw-bold" name="method" id="method" data-kt-select2="true" data-placeholder="All" data-allow-clear="true" data-hide-search="true" app-onchange-datatable-reload>
                                                                <option></option>
                                                                <option value="bank">Bank</option>
                                                                <option value="papara">Papara</option>
                                                                <option value="cross">Cross</option>
                                                                <option value="match">Match</option>
                                                                <option value="pos">Virtual POS</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-4 d-flex align-items-center">
                                                            <label class="form-label fs-6 fw-semibold text-end w-100 m-0">Firm:</label>
                                                        </div>
                                                        <div class="col ps-0">
                                                            <select class="form-select form-select-solid border border-1 fw-bold" name="siteId" id="siteId" data-kt-select2="true" data-placeholder="All" data-allow-clear="true" data-hide-search="true" app-onchange-datatable-reload>
                                                                <option></option>
                                                                <? $site = explode(",",$update->perm_site); foreach($siteSelect as $row){ ?>
                                                                <option value="<?=$row->id ?>"> <?=$row->site_name ?></option>
                                                                <? } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-4 d-flex align-items-center">
                                                            <label class="form-label fs-6 fw-semibold text-end w-100 m-0">Account:</label>
                                                        </div>
                                                        <div class="col ps-0">
                                                            <input type="text" class="form-control form-control-solid border border-1 fw-bold" name="accountIdFilter" id="accountIdFilter" placeholder="All" app-onchange-datatable-reload>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-4 d-flex align-items-center">
                                                            <label class="form-label fs-6 fw-semibold text-end w-100 m-0">Status:</label>
                                                        </div>
                                                        <div class="col ps-0">
                                                            <select class="form-select form-select-solid border border-1 fw-bold" name="status" id="status" data-kt-select2="true" data-placeholder="All" data-allow-clear="true" data-hide-search="true" app-onchange-datatable-reload>
                                                                <option></option>
                                                                <option value="beklemede">Pending</option>
                                                                <option value="onaylandı">Approved</option>
                                                                <option value="reddedildi">Rejected</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-end">
                                                        <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset" app-onclick-datatable-reset>Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                            <a class="btn btn-light ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" id="islemler">Actions <span class="svg-icon svg-icon-2 me-0">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6" data-kt-menu="true">
                                                <div class="menu-item px-5">
                                                    <div class="menu-content text-muted pb-2 px-5 fs-7 text-uppercase">Actions</div>
                                                </div>
                                                <? if((segment[2] == "deposit" && edit_transaction_deposit === true) || segment[2] == "withdraw" && edit_transaction_withdraw === true): ?>
                                                <div class="menu-item px-3">
                                                    <div class="menu-content px-3">
                                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                                            <div class="form-check-label text-gray-800 fs-6 ps-2 me-3" for="notifications">Notifications</div>
                                                            <input class="form-check-input w-30px h-20px" type="checkbox" value="" name="notifications" <? if(notificationSound==1): ?>checked="checked"
                                                            <? endif; ?> id="notifications" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <? endif ?>
                                                <div class="menu-item px-3">
                                                    <div class="menu-content px-3">
                                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                                            <div class="form-check-label text-gray-800 fs-6 ps-2 me-3" for="sync">Auto Refresh</div>
                                                            <input class="form-check-input w-30px h-20px" type="checkbox" value="" " name=" sync" checked="checked" id="sync" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <? if((segment[2] == "deposit" && edit_transaction_deposit === true) || segment[2] == "withdraw" && edit_transaction_withdraw === true): ?>
                                                <div class="separator my-3"></div>
                                                <div class="menu-item px-5">
                                                    <div class="menu-content text-muted pb-2 px-5 fs-7 text-uppercase" data-page-title></div>
                                                </div>
                                                <div class="menu-item ps-5" id="reject-all-button">
                                                    <a class="menu-link text-danger ps-5">Reject pending transactions</a>
                                                </div>
                                                <? endif ?>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-light" id="refresh">
                                            <span class="svg-icon svg-icon-2 m-0">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M14.5 20.7259C14.6 21.2259 14.2 21.826 13.7 21.926C13.2 22.026 12.6 22.0259 12.1 22.0259C9.5 22.0259 6.9 21.0259 5 19.1259C1.4 15.5259 1.09998 9.72592 4.29998 5.82592L5.70001 7.22595C3.30001 10.3259 3.59999 14.8259 6.39999 17.7259C8.19999 19.5259 10.8 20.426 13.4 19.926C13.9 19.826 14.4 20.2259 14.5 20.7259ZM18.4 16.8259L19.8 18.2259C22.9 14.3259 22.7 8.52593 19 4.92593C16.7 2.62593 13.5 1.62594 10.3 2.12594C9.79998 2.22594 9.4 2.72595 9.5 3.22595C9.6 3.72595 10.1 4.12594 10.6 4.02594C13.1 3.62594 15.7 4.42595 17.6 6.22595C20.5 9.22595 20.7 13.7259 18.4 16.8259Z" fill="currentColor" />
                                                    <path opacity="0.3" d="M2 3.62592H7C7.6 3.62592 8 4.02592 8 4.62592V9.62589L2 3.62592ZM16 14.4259V19.4259C16 20.0259 16.4 20.4259 17 20.4259H22L16 14.4259Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" id="export">
                                            <span class="svg-icon svg-icon-2 m-0">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="1" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor" />
                                                    <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="currentColor" />
                                                    <path opacity="1" d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </button>
                                        <div id="datatableExport" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-row-bordered align-middle dataTable fs-6 gy-3" id="datatable_content">
                                            <thead datatable-head></thead>
                                            <tbody class="fw-semibold text-gray-700"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <?php require appViewPath().'layout/_footer.php' ?>
                </div>
            </div>
        </div>
        <?php require appViewPath().'transaction/drawer/'.$request.'/inspect.php' ?>
        <?php require appViewPath().'layout/footer/footer.php' ?>
