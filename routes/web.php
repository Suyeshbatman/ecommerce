<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', 'LoginController@index')->name('login');
Route::get('/redirect', [LoginController::class, 'redirect'])->name('redirect');
Route::get('/register', 'LoginController@register')->name('register');

Route::post('/login', 'LoginController@login')->name('login.post');
Route::get('/logout', 'LoginController@logout')->name('logout');
Route::post('/register', 'LoginController@registeruser')->name('register.post');


    // Route::group(['middleware' => 'WhoIsUser'], function() {

    //     Route::resource('admin','AdminController');

    //     Route::resource('roles','Role\RolesController');

    //     Route::resource('users','Users\UsersController');

    //     //Route::resource('posts','Posts\PostsController');

    //     Route::resource('userroles','UserRoles\UserRolesController');

    // });

