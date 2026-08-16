<?php

use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Route;

Route::livewire('/login', 'page/auth/login')->name('login');

Route::livewire('/', 'raffle-application')->name('home');


Route::middleware('auth')->group(function() {
    Route::get('/logout', LogoutController::class)->name('logout');
    Route::livewire('/admin/raffle', 'page/admin/raffle')
        ->middleware('can:admin')
        ->name('admin.raffle');
});
