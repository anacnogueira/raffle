<?php

use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Route;

Route::livewire('/login', 'page/auth/login')->name('login');

Route::livewire('/', 'home')->name('home');
Route::livewire('/{raffle}', 'raffle-application')->name('raffle.application');


Route::middleware('auth')->group(function() {
    Route::get('/logout', LogoutController::class)->name('logout');
    Route::livewire('/admin/raffle', 'page/admin/raffle')
        ->middleware('can:admin')
        ->name('admin.raffle');
});
