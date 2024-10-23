<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/admin/{any?}', static function () {
    return view('pages.admin');
})->name('admin')->where('any', '.*');
Route::get('/admin/reset-password', static function (Request $request) {
    redirect($request->getRequestUri());
})->name('admin.password.reset');
