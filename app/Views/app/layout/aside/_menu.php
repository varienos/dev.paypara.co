<?php $page = isset($_GET['page']) ? $_GET['page'] : "index"; ?>
<div class="w-100 hover-scroll-overlay-y d-flex pe-2" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu, #kt_aside_menu_wrapper" data-kt-scroll-offset="100">
    <div class="menu menu-column menu-rounded menu-sub-indention menu-active-bg fw-semibold my-auto" id="#kt_aside_menu" data-kt-menu="true">
        <div class="menu-item menu-accordion">
            <a class="menu-link <? if(segment[0] == 'dashboard') { echo 'active'; } ?>" href="dashboard">
                <span class="menu-icon">
                    <span class="svg-icon svg-icon-5">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />
                        </svg>
                    </span>
                </span>
                <span class="menu-title">Dashboard</span>
            </a>
        </div>
        <? if(view_papara_account === true && view_bank_account === true): ?>
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion <? if(segment[0]== 'account') { echo 'hover show'; } ?>">
            <span class="menu-link show">
                <span class="menu-icon">
                    <span class="svg-icon svg-icon-5">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />
                        </svg>
                    </span>
                </span>
                <span class="menu-title">Accounts</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
                <? if(view_papara_account === true): ?>
                <div class="menu-item menu-accordion">
                    <a class="menu-link <? if((segment[0] == 'account' && segment[1] == 'index' && segment[2] == '1')  || (segment[0] == 'account' && segment[1] == 'detail' && segment[3] == '1' ) ) { echo 'active'; } ?>" href="account/index/1">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Papara Accounts</span>
                    </a>
                </div>
                <div class="menu-item menu-accordion">
                    <a class="menu-link <? if((segment[0] == 'account' && segment[1] == 'index' && segment[2] == '2') || (segment[0] == 'account' && segment[1] == 'detail' && segment[3] == '2' )) { echo 'active'; } ?>" href="account/index/2">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Matching Accounts</span>
                    </a>
                </div>
                <? endif ?>
                <? if(view_bank_account === true): ?>
                <div class="menu-item disable menu-accordion">
                    <a class="menu-link <? if((segment[0] == 'account' && segment[1] == 'index' && segment[2] == '3') || (segment[0] == 'account' && segment[1] == 'detail' && segment[3] == '3' )) { echo 'active'; } ?>" href="account/index/3">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Bank Accounts</span>
                    </a>
                </div>
                <? endif ?>
            </div>
        </div>
        <? endif ?>
        <? if(view_transaction_deposit === true && view_transaction_withdraw === true): ?>
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion <? if(segment[0]== 'transaction') { echo 'hover show'; } ?>">
            <span class="menu-link">
                <span class="menu-icon">
                    <span class="svg-icon svg-icon-5">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />
                        </svg>
                    </span>
                </span>
                <span class="menu-title">Transactions</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
                <? if(view_transaction_deposit === true): ?>
                <div class="menu-item">
                    <a class="menu-link <? if(segment[0] == 'transaction' && segment[1] == 'index' && segment[2] == 'deposit' ) { echo 'active'; } ?>" href="transaction/index/deposit">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Deposits</span>
                    </a>
                </div>
                <? endif ?>
                <? if(view_transaction_withdraw === true): ?>
                <div class="menu-item">
                    <a class="menu-link <? if(segment[0] == 'transaction' && segment[1] == 'index' && segment[2] == 'withdraw' ) { echo 'active'; } ?>" href="transaction/index/withdraw">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Withdrawals</span>
                    </a>
                </div>
                <? endif ?>
                <? if(view_reserved === true): ?>
                <div class="menu-item">
                    <a class="menu-link disabled disable " href="javascript:;">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title disabled">Reserves</span>
                    </a>
                </div>
                <? endif ?>
            </div>
        </div>
        <? endif ?>
        <? if(view_customer === true): ?>
        <div class="menu-item menu-accordion">
            <a class="menu-link <? if(segment[0] == 'customer' ) { echo 'active'; } ?>" href="customer/index">
                <span class="menu-icon">
                    <span class="svg-icon svg-icon-5">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />
                        </svg>
                    </span>
                </span>
                <span class="menu-title">Customers</span>
            </a>
        </div>
        <? endif ?>
        <? if(view_report === true): ?>
        <div class="menu-item menu-accordion">
            <a class="menu-link <? if(segment[0] == 'reports' ) { echo 'active'; } ?>" href="reports/index">
                <span class="menu-icon">
                    <span class="svg-icon svg-icon-5">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />
                        </svg>
                    </span>
                </span>
                <span class="menu-title">Reports</span>
            </a>
        </div>
        <? endif ?>
        <? if(view_user === true): ?>
        <div class="menu-item menu-accordion">
            <a class="menu-link <? if(segment[0] == 'user' ) { echo 'active'; } ?>" href="user/index">
                <span class="menu-icon">
                    <span class="svg-icon svg-icon-5">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />
                        </svg>
                    </span>
                </span>
                <span class="menu-title">Users</span>
            </a>
        </div>
        <? endif ?>
        <? if(view_setting === true || view_firm === true): ?>
        <div class="menu-item menu-accordion">
            <a class="menu-link <? if(segment[0] == 'setting' ) { echo 'active'; } ?>" href="setting">
                <span class="menu-icon">
                    <span class="svg-icon svg-icon-5">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />
                            <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />
                        </svg>
                    </span>
                </span>
                <span class="menu-title">Settings</span>
            </a>
        </div>
        <? endif ?>
    </div>
</div>