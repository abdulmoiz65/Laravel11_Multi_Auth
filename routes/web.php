<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login',[LoginController::class,'index'])->name('account.login');
Route::post('/login/authenticate',[LoginController::class,'authenticate'])->name('account.authenticate');
Route::get('/login/dashboard',[DashboardController::class,'dashboard'])->name('account.dashboard');
Route::get('/register',[LoginController::class,'register'])->name('account.register');
Route::post('/register/process-Register',[LoginController::class,'processRegister'])->name('account.processRegister');
