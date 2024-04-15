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
    return view('home');
})->name('home');

Route::get('/login', 'LoginController@index')->name('login');
Route::get('/redirect', [LoginController::class, 'redirect'])->name('redirect');
Route::get('/register', 'LoginController@register')->name('register');

Route::post('/login', 'LoginController@login')->name('login.post');
Route::get('/logout', 'LoginController@logout')->name('logout');
Route::post('/register', 'LoginController@registeruser')->name('register.post');

Route::post('/subscribe', 'LoginController@subscribeuser')->name('subscribe.post');

//Superadmin routes
Route::post('/dashboard', 'SuperadminController@index')->name('superadmin.index');

Route::post('/createcategory', 'SuperadminController@registercategory')->name('superadmin.registercategory');
Route::post('/createservices', 'SuperadminController@registerservices')->name('superadmin.registerservices');
Route::get('/fetch-services', 'SuperadminController@fetchServices')->name('superadmin.fetchservices');
Route::get('/fetch-categories', 'SuperadminController@fetchCategories')->name('fetch.categories');
Route::post('/delete-service', 'SuperadminController@deleteService')->name('delete-service');



Route::post('/clientdashboard', 'ClientController@index')->name('client.index');
Route::post('/getservices', 'ClientController@getservices')->name('client.getservices');

// Route::post('/usersdashboard', 'SuperadminController@superuser')->name('superadmin.users');
// Route::post('/servicesdashboard', 'SuperadminController@superservices')->name('superadmin.services');
// Route::post('/addservicesdashboard', 'SuperadminController@addservices')->name('superadmin.addservices');
// Route::post('/revenuedashboard', 'SuperadminController@revenue')->name('superadmin.revenue');


    // Route::group(['middleware' => 'WhoIsUser'], function() {

    //     Route::resource('admin','AdminController');

    //     Route::resource('roles','Role\RolesController');

    //     Route::resource('users','Users\UsersController');

    //     //Route::resource('posts','Posts\PostsController');

    //     Route::resource('userroles','UserRoles\UserRolesController');

    // });






