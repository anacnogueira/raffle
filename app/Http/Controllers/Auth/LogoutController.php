<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;


class LogoutController
{
    public function __invoke()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return Route::redirect('login');
    }

}
