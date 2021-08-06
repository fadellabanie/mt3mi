<?php

namespace App\Http\Controllers;

class LocaleController extends Controller
{
    public function __invoke($locale)
    {
        if (! in_array($locale, config('app.supported_languages'))) {
            $locale = app()->getLocale();
        }

        app()->setLocale($locale);

        session()->put('locale', $locale);

        return back();
    }
}
