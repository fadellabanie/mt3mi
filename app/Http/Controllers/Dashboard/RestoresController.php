<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class RestoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Restore Data')->only('edit');
    }
    public function __invoke()
    {
        return view('dashboard.restores.index');
    }
}
