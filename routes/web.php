<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Bank\BankController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [AuthController::class, 'index'])->name('viewLogin');
Route::post('login', [AuthController::class, 'authenticate'])->name('login');


Route::group(['middleware'=> 'auth'], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('bank')->group(function() {
        Route::get('/create', [BankController::class, 'create'])->name('create');
        Route::post('/display', [BankController::class, 'display'])->name('display');
        Route::get('/edit', [BankController::class, 'edit'])->name('edit');
        Route::patch('/update', [BankController::class, 'update'])->name('update');
        Route::delete('/delete', [BankController::class, 'delete'])->name('delete');
        Route::post('/deposit', [BankController::class, 'deposit'])->name('deposit');
        Route::get('/withdraw', [BankController::class, 'withdraw'])->name('withdraw');
        Route::post('search', [BankController::class, 'search'])->name('search');
    });
});
