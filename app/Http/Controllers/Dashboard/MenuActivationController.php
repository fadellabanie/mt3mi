<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuActivationController extends Controller
{
    public function products()
    {
        return view('dashboard.activation.products');
    }

    public function categories()
    {
        return view('dashboard.activation.categories');
    }

    public function sizes()
    {
        return view('dashboard.activation.sizes');
    }

    public function tags()
    {
        return view('dashboard.activation.tags');
    }

    public function modifiers()
    {
        return view('dashboard.activation.modifiers');
    }
}
