<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function home(Request $request): RedirectResponse
    {
        $supportedLocales = config('laravellocalization.localesOrder');

        $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

        if (! in_array($locale, $supportedLocales)) {
            $locale = config('app.locale');
        }

        return redirect()->to("/{$locale}");
    }
}
