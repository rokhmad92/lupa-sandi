<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

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

Route::controller(LoginController::class)->group(function() {
    Route::get('/', 'index');
    Route::post('/', 'login');
    Route::get('/register', 'registerView');
    Route::post('/register', 'store');
    Route::get('/forgot', 'forgotView');
    Route::post('/forgot', 'sendEmail');
    Route::get('/forgot/reset/{token}', 'showResetPassword')->name('show.reset.password');
    Route::get('/forgot/reset', 'reset');
});
