<?php

use App\Http\Livewire\LogsViewer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocaleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/log-viewer', LogsViewer::class)->middleware('auth');

Route::get('lang/{locale}', LocaleController::class)
    ->name('locale');

require __DIR__.'/auth.php';

require __DIR__ . '/dashboard.php';

require __DIR__ . '/manage.php';

Route::get('h', function () {

    $lang = app()->getLocale();

    return config("languages.{$lang}.display_text");

});