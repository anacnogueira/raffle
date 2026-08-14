<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/login', 'auth/login')->name('login');

Route::middleware('auth')->group(function() {
    Route::livewire('/', 'raffle-application')->name('home');
});
