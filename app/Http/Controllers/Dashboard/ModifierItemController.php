<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Modifier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModifierItemController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Modifier $modifier)
    {
        return view('dashboard.modifier-items.index', [
            'modifier' => $modifier
        ]);
    }
}
