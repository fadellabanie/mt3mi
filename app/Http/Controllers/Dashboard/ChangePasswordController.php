<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class ChangePasswordController extends Controller
{
    public function __invoke()
    {
        return view('dashboard.profile.change-password');
    }
}
