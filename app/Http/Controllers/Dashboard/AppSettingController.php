<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class AppSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Application Settings')->only('edit');
    }
    public function __invoke()
    {
        return view('dashboard.settings.app-settings');
    }
}
