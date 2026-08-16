<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/login', 'auth/login')->name('login');
Route::livewire('/', 'raffle-application')->name('home');


Route::middleware('auth')->group(function() {
     Route::livewire('/admin/raffle', 'page/admin/raffle')->name('admin.raffle');
});
