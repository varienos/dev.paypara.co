<?php

namespace Config;
// Create a new instance of our RouteCollection class.
$routes = Services::routes();
// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}
/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
 */
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
// We get a performance increase by specifying the default
// route since we don't have to scan directories.
if (SUBDOMAIN == "api") {
    $routes->setDefaultNamespace('App\Controllers');
    $routes->setDefaultController('Api');
    $routes->setDefaultMethod('index');
    $routes->setTranslateURIDashes(false);
    $routes->set404Override(static function () {
        echo view('api/404');
    });
    $routes->add('/', 'Api::index');
    $routes->add('/v1', 'Api::index');
    $routes->add('/v1/newPayment', 'Api::newPayment');
    $routes->add('/v1/dataSend', 'Api::dataSend');
    $routes->add('/v1/dataRecive', 'Api::dataRecive');
    $routes->add('/v1/token', 'Api::token');
    $routes->add('/v1/output', 'Api::output');
    $routes->add('/v1/get-limits', 'Api::limit');
    $routes->add('/v1/new-deposit', 'Api::deposit');
    $routes->add('/v1/new-deposit/(:any)', 'Api::deposit/$1');
    $routes->add('/v1/new-deposit/(:any)/(:any)', 'Api::deposit/$1/$2');
    $routes->add('/v1/tokenStatus/(:any)', 'Api::tokenStatus/$1');
    $routes->add('/v1/approve/(:any)/(:any)', 'Api::approve/$1/$2');
    $routes->add('/v1/new-withdraw', 'Api::withdraw');
    $routes->add('/v1/status', 'Api::status');
    $routes->add('/v1/new-payment', 'Api::newPayment');
} elseif (SUBDOMAIN == "pay") {
    $routes->setDefaultNamespace('App\Controllers');
    $routes->setDefaultController('Pay');
    $routes->setDefaultMethod('papara');
    $routes->setTranslateURIDashes(false);
    $routes->set404Override(static function () {
        echo view('pay/404');
    });
    $routes->add('/papara/(:any)', 'Pay::papara/$1');
} elseif (SUBDOMAIN == "demo") {
    $routes->setDefaultNamespace('App\Controllers');
    $routes->setDefaultController('Demo');
    $routes->setDefaultMethod('index');
    $routes->setTranslateURIDashes(false);
    $routes->set404Override(static function () {
        echo view('demo/404');
    });
    $routes->add('/new-demo', 'Demo::index');
    $routes->add('/papara/(:any)', 'Demo::papara/$1');
} else {
    $routes->setDefaultNamespace('App\Controllers');
    $routes->setDefaultController('Boot');
    $routes->setDefaultMethod('index');
    $routes->setTranslateURIDashes(false);
    $routes->set404Override(static function () {
        echo view('404');
    });
    $routes->add('/', 'Boot::index');
    $routes->add('/secure/login', 'Secure::login');
    $routes->add('/secure/authentication', 'Secure::authentication');
    $routes->add('/secure/2fa', 'Secure::twoFa');
    $routes->add('/secure/2fa/(:any)', 'Secure::twoFa/$1');
    $routes->add('/secure/2fa/(:any)/(:any)', 'Secure::twoFa/$1/$2');
    $routes->add('/secure/signout', 'Secure::signout');
    $routes->add('/reports/index', 'Reports::index');
    $routes->add('/dashboard', 'Dashboard::index');
    $routes->add('/dashboard/(:any)', 'Dashboard::index/$1');
    $routes->add('/account/index', 'Account::index');
    $routes->add('/account/index/(:any)', 'Account::index/$1');
    $routes->add('/account/form/(:any)', 'Account::form/$1');
    $routes->add('/account/form/(:any)/(:any)', 'Account::form/$1/$2');
    $routes->add('/account/delete/(:any)', 'Account::delete/$1');
    $routes->add('/account/detail/(:any)', 'Account::detail/$1');
    $routes->add('/account/detail/(:any)/(:any)', 'Account::detail/$1/$2');
    $routes->add('/account/listMatch/(:any)', 'Account::listMatch/$1');
    $routes->add('/account/listDisableMatch/(:any)', 'Account::listDisableMatch/$1');
    $routes->add('/account/accountTotalMatch/(:any)', 'Account::accountTotalMatch/$1');
    $routes->add('/account/removeMatch/(:any)', 'Account::removeMatch/$1');
    $routes->add('/account/customerQuery', 'Account::customerQuery');
    $routes->add('/account/match/(:any)', 'Account::match/$1');
    $routes->add('/account/save', 'Account::save');
    $routes->add('/account/datatable/(:any)', 'Account::datatable/$1');
    $routes->add('/account/include/(:any)', 'Account::include/$1');
    $routes->add('/account/transaction/(:any)', 'Account::transaction/$1');
    $routes->add('/account/status/(:any)/(:any)', 'Account::status/$1/$2');
    $routes->add('/account/status/(:any)/(:any)/(:any)', 'Account::status/$1/$2/$3');
    $routes->add('/customer/index', 'Customer::index');
    $routes->add('/customer/detail/(:any)/(:any)', 'Customer::detail/$1/$2');
    $routes->add('/customer/datatable', 'Customer::datatable');
    $routes->add('/customer/include/(:any)', 'Customer::include/$1');
    $routes->add('/customer/save/(:any)/(:any)', 'Customer::save/$1/$2');
    $routes->add('/customer/switch/(:any)/(:any)/(:any)', 'Customer::switch/$1/$2/$3');
    $routes->add('/user/activity', 'User::activity');
    $routes->add('/user/index', 'User::index');
    $routes->add('/user/roles', 'User::roles');
    $routes->add('/user/check', 'User::check');
    $routes->add('/user/2fa', 'User::twoFa');
    $routes->add('/user/detail/(:any)', 'User::detail/$1');
    $routes->add('/user/remove/(:any)', 'User::remove/$1');
    $routes->add('/user/update/(:any)', 'User::update/$1');
    $routes->add('/user/switch/(:any)/(:any)/(:any)', 'User::switch/$1/$2/$3');
    $routes->add('/user/modal', 'User::modal');
    $routes->add('/user/role/(:any)', 'User::role/$1');
    $routes->add('/user/sessiontable/(:any)', 'User::sessiontable/$1');
    $routes->add('/user/save', 'User::save');
    $routes->add('/user/saveRole', 'User::saveRole');
    $routes->add('/user/removeRole/(:any)', 'User::removeRole/$1');
    $routes->add('/user/datatable', 'User::datatable');
    $routes->add('/user/datatableRole', 'User::datatableRole');
    $routes->add('/user/include/(:any)', 'User::include/$1');
    $routes->add('/client/json', 'Client::json');
    $routes->add('/client/save', 'Client::save');
    $routes->add('/client/datatable', 'Client::datatable');
    $routes->add('/client/detail/(:any)', 'Client::detail/$1');
    $routes->add('/client/remove/(:any)', 'Client::remove/$1');
    $routes->add('/client/switch/(:any)/(:any)/(:any)', 'Client::switch/$1/$2/$3');
    $routes->add('/transaction/index/(:any)', 'Transaction::index/$1');
    $routes->add('/transaction/notificationSound/(:any)', 'Transaction::notificationSound/$1');
    $routes->add('/transaction/getNotificationSoundStatus', 'Transaction::getNotificationSoundStatus');
    $routes->add('/transaction/include/(:any)', 'Transaction::include/$1');
    $routes->add('/transaction/modal/(:any)/(:any)/(:any)', 'Transaction::modal/$1/$2/$3');
    $routes->add('/transaction/datatable/(:any)', 'Transaction::datatable/$1');
    $routes->add('/transaction/customerTransactionTable/(:any)', 'Transaction::customerTransactionTable/$1');
    $routes->add('/transaction/update', 'Transaction::update');
    $routes->add('/transaction/accounts', 'Transaction::listAccounts');
    $routes->add('/settings', 'Settings::index');
    $routes->add('/settings/update', 'Settings::update');
    $routes->add('/reports/data', 'Reports::data');
    $routes->add('/json/resources', 'Json::resources');
    $routes->add('/dev', 'Dev::index');
    $routes->add('/dev/latency', 'Dev::ping');
    $routes->add('/dev/jsVariables', 'Dev::jsVariables');
    $routes->add('/dev/console', 'Dev::console');
    $routes->add('/dev/string', 'Dev::string');
    $routes->add('/dev/phpInfo', 'Dev::phpInfo');
    $routes->add('/dev/twoFA', 'Dev::twoFA');
    $routes->add('/dev/twoFA/(:any)', 'Dev::twoFA/$1');
    $routes->add('/dev/errorHandler/(:any)', 'Dev::errorHandler/$1');
}
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
