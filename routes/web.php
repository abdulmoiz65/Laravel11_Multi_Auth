<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'account'], function () {
   
    //guest middleware
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login',[LoginController::class,'index'])->name('account.login');
        Route::post('/login/authenticate',[LoginController::class,'authenticate'])->name('account.authenticate');
        Route::get('/register',[LoginController::class,'register'])->name('account.register');
        Route::post('/register/process-Register',[LoginController::class,'processRegister'])->name('account.processRegister');
    });
    //authenticated middleware
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/login/dashboard',[DashboardController::class,'dashboard'])->name('account.dashboard');
        Route::get('/logout',[LoginController::class,'logout'])->name('account.logout');
    });

});

// admin.guest and admin.auth is our alias middleware

Route::group(['prefix' => 'admin'], function () {
    //guest middleware
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [AdminLoginController::class, 'adminLogin'])->name('admin.login');
        Route::post('/login/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });
    //authenticated middleware
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
});




