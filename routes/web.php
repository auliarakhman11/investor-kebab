<?php

use App\Http\Controllers\AuthController;

use App\Http\Controllers\InvestorController;
use App\Http\Controllers\JurnalController;


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

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [InvestorController::class, 'index'])->name('investor');
    //jurnal
    Route::get('dt-jurnal', [InvestorController::class, 'dtJurnal'])->name('dtJurnal');
    Route::get('dt-peroutlet', [InvestorController::class, 'dtPeroutlet'])->name('dtPeroutlet');

    //end jurnal

});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login_page'])->name('login_page');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
