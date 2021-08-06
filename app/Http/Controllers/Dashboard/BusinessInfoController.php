<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class BusinessInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Work Information')->only('edit');
    }
    public function __invoke()
    {
        return view('dashboard.settings.business-info');
    }
}
