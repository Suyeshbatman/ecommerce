<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperadminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Auth Routes

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::get('/checklogin', 'LoginController@index')->name('login');
Route::get('/userlogin', 'LoginController@userlogin')->name('userlogin');
Route::get('/redirect', [LoginController::class, 'redirect'])->name('redirect');
Route::get('/register', 'LoginController@register')->name('register');

Route::post('/login', 'LoginController@login')->name('login.post');
Route::get('/logout', 'LoginController@logout')->name('logout');
Route::post('/register', 'LoginController@registeruser')->name('register.post');



//Superadmin routes
Route::post('/dashboard', 'SuperadminController@index')->name('superadmin.index');

Route::post('/createcategory', 'SuperadminController@registercategory')->name('superadmin.registercategory');
Route::post('/createservices', 'SuperadminController@registerservices')->name('superadmin.registerservices');
Route::get('/fetch-services', 'SuperadminController@fetchServices')->name('superadmin.fetchservices');
Route::get('/fetch-categories', 'SuperadminController@fetchCategories')->name('fetch.categories');
Route::post('/delete-service', 'SuperadminController@deleteService')->name('delete-service');
Route::post('/update-paid-status', [SuperadminController::class, 'updatePaidStatus'])->name('update.paid.status');
Route::post('/edit-service/{id}', 'SuperadminController@editService')->name('superadmin.editservice');


//Client routes
Route::post('/clientdashboard', 'ClientController@index')->name('client.index');
Route::post('/getservices', 'ClientController@getservices')->name('client.getservices');
Route::post('/createavailableservices', 'ClientController@createavailableservices')->name('client.createavailableservices');
Route::post('/getdifficulty', 'ClientController@getdifficulty')->name('client.getdifficulty');
Route::get('/fetchuserdata', 'ClientController@fetchuserdata')->name('client.fetchuserdata');
Route::post('/getuserdata', 'ClientController@getuserdata')->name('client.getuserdata');
Route::post('/edituserprofile', 'ClientController@edituserprofile')->name('client.edituserprofile');
Route::post('/getservicedata', 'ClientController@getservicedata')->name('client.getservicedata');
Route::post('/edituserservice', 'ClientController@edituserservice')->name('client.edituserservice');
Route::post('/deleteuserservice', 'ClientController@deleteuserService')->name('client.deleteuserservice');
Route::get('/fetchappointmentdata', 'ClientController@fetchappointmentdata')->name('client.fetchappointmentdata');

Route::post('/appointmentactions', 'ClientController@appointmentactions')->name('client.appointmentactions');
Route::get('/fetchrevenuedata', 'ClientController@fetchrevenuedata')->name('client.fetchrevenuedata');
// Route::post('/usersdashboard', 'SuperadminController@superuser')->name('superadmin.users');
// Route::post('/servicesdashboard', 'SuperadminController@superservices')->name('superadmin.services');
// Route::post('/addservicesdashboard', 'SuperadminController@addservices')->name('superadmin.addservices');
// Route::post('/revenuedashboard', 'SuperadminController@revenue')->name('superadmin.revenue');


//Normal User Routes
Route::post('/subscribe', 'LoginController@subscribeuser')->name('subscribe.post');
Route::post('/getavailableservice', 'HomeController@fetchavailableservice')->name('fetch.availableservice');
Route::post('/requestavailableservice', 'HomeController@requestavailableservice')->name('request.reqavailableservice');
Route::get('/cartdata', 'HomeController@getcartdata')->name('cartdata');
Route::post('/filter-by-category', 'HomeController@filterbycategory')->name('filter.category');
Route::post('/filter-by-service', 'HomeController@filterbyservice')->name('filter.service');


