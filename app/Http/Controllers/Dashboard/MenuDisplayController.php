<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuDisplayController extends Controller
{
    public function categories()
    {
        return view('dashboard.display.categories');
    }

    public function tags()
    {
        return view('dashboard.display.tags');
    }
}
