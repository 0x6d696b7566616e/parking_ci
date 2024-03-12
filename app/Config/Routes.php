<?php

namespace Config;

use App\Controllers\Auth;
use App\Controllers\AuthGuard;
use App\Controllers\Dashboard\GuardDashboard;
use App\Controllers\Dashboard\StudentDashboard;
use App\Controllers\EmailVerification;
use App\Controllers\ErrorPage;
use App\Controllers\ForgotPassword;
use App\Controllers\GuardManagement;
use App\Controllers\Parking\Guard\AprovedRequestToGetOut as GuardAprovedRequestToGetOut;
use App\Controllers\Parking\Student\AprovedRequestToGetOut as StudentAprovedRequestToGetOut;
use App\Controllers\Parking\Student\RequestToGetOut;
use App\Controllers\Profile\IdCard;
use App\Controllers\Search;
use App\Controllers\UpdateProfile\GuardUpdateProfile;
use App\Controllers\UpdateProfile\StudentUpdateProfile;
use App\Controllers\Vehicle\StudentCreateVehicle;
use App\Controllers\Vehicle\StudentDeleteVehicle;
use App\Controllers\Vehicle\StudentUpdateVehicle;
use App\Controllers\Vehicle\StudentVehicle;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
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

// error routes
$routes->get('403', [ErrorPage::class, 'unauthorize']);
$routes->get('404', [ErrorPage::class, 'notfound']);
$routes->get('500', [ErrorPage::class, 'server_error']);


// auth routes 
$routes->group('/', ['filter' => 'guest'], function ($routes) {
    $routes->get('', [Auth::class, 'get_login']);
    $routes->get('login', [Auth::class, 'get_login']);
    $routes->get('register', [Auth::class, 'get_register']);

    $routes->post('login', [Auth::class, 'post_login']);
    $routes->post('register', [Auth::class, 'post_register']);
});


// guard routes
$routes->group('/guard', ['filter' => 'guest'], function ($routes) {
    $routes->get('login', [AuthGuard::class, 'get_login']);
    $routes->post('login', [AuthGuard::class, 'post_login']);
});    

$routes->group('/guard', ['filter' => ['auth', 'guard', 'admin_guard', 'complete_profile', 'email_verify']], function ($routes) {
    $routes->get('', [GuardManagement::class, 'index']);
    $routes->post('activate/(:num)', [GuardManagement::class, 'activate/$1']);
    $routes->post('inactivate/(:num)', [GuardManagement::class, 'inactivate/$1']);

    $routes->get('register', [AuthGuard::class, 'get_register']);
    $routes->post('register', [AuthGuard::class, 'post_register']);
});

$routes->group('/guard/dashboard', ['filter' => ['auth', 'guard', 'complete_profile', 'email_verify']], function ($routes) {
    $routes->get('', [GuardDashboard::class, 'index']);

    $routes->get('scan', [GuardAprovedRequestToGetOut::class, 'scan_barcode']);
    $routes->get('aproved', [GuardAprovedRequestToGetOut::class, 'aproved']);
});

$routes->group('/guard/dashboard', ['filter' => ['auth', 'guard']], function ($routes) {
    $routes->get('update-profile', [GuardUpdateProfile::class, 'index']);
    $routes->post('update-nip', [GuardUpdateProfile::class, 'post_update_nip']);
    $routes->post('update-email', [GuardUpdateProfile::class, 'post_update_email']);
    $routes->post('update-profile', [GuardUpdateProfile::class, 'post_basic_data']);
});

// dashboard students routes
$routes->group('/dashboard', ['filter' => ['auth', 'student']], function ($routes) {
    $routes->get('update-profile', [StudentUpdateProfile::class, 'index']);
    $routes->post('update-nim', [StudentUpdateProfile::class, 'post_update_nim']);
    $routes->post('update-email', [StudentUpdateProfile::class, 'post_update_email']);
    $routes->post('update-profile', [StudentUpdateProfile::class, 'post_basic_data']);
});

$routes->group('/dashboard', ['filter' => ['auth', 'student', 'complete_profile', 'email_verify']], function ($routes) {
    $routes->get('', [StudentDashboard::class, 'index']);

    $routes->get('vehicles', [StudentVehicle::class, 'index']);
    $routes->get('create-vehicle', [StudentCreateVehicle::class, 'index']);
    $routes->get('update-vehicle/(:num)', [StudentUpdateVehicle::class, 'index/$1']);
    $routes->get('delete-vehicle/(:num)', [StudentDeleteVehicle::class, 'index/$1']);
    $routes->post('create-vehicle', [StudentCreateVehicle::class, 'post_create_vehicle']);
    $routes->post('update-vehicle/(:num)', [StudentUpdateVehicle::class, 'post_update_vehicle/$1']);

    $routes->get('request-to-get-out/(:num)', [RequestToGetOut::class, 'index/$1']);
    $routes->get('request-list', [RequestToGetOut::class, 'request_to_get_out_list']);
    $routes->get('delete-request-to-get-out/(:num)', [RequestToGetOut::class, 'delete_request_to_get_out/$1']);
    $routes->post('request-to-get-out/(:num)', [RequestToGetOut::class, 'request_to_get_out/$1']);

    $routes->get('aproved-list', [StudentAprovedRequestToGetOut::class, 'aproved_request_list']);
});


// global with protected routes
$routes->group('/', ['filter' => 'auth'], function ($routes) {
    $routes->get('logout', [Auth::class, 'logout']);
    $routes->get('id-card', [IdCard::class, 'index']);
    $routes->get('guard-id-card', [IdCard::class, 'guard_id_card']);
    $routes->get('guard-profile', [IdCard::class, 'current_guard_id_card']);
    $routes->get('verify-your-email', [EmailVerification::class, 'must_verify']);
    $routes->post('request-to-verify', [EmailVerification::class, 'request_to_verify']);
});

$routes->group('/', ['filter' => ['auth', 'complete_profile', 'email_verify']], function ($routes) {
    $routes->get('search', [Search::class, 'index']);
    $routes->get('aproved-request/(:num)', [StudentAprovedRequestToGetOut::class, 'aproved_request/$1']);
});


// global with routes
$routes->group('/', function ($routes) {
    $routes->get('verify-email/(:any)', [EmailVerification::class, 'get_verify_email/$1']);
    $routes->post('verify-email', [EmailVerification::class, 'post_verify_email']);

    $routes->get('forgot-password', [ForgotPassword::class, 'index']);
    $routes->post('forgot-password', [ForgotPassword::class, 'request_send_email']);

    $routes->get('reset-password/(:any)', [ForgotPassword::class, 'get_reset_password/$1']);
    $routes->post('reset-password', [ForgotPassword::class, 'post_reset_password']);
});

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
