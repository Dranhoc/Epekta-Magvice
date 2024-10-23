<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\ContentTypes;
use App\Models\Content;
use App\Models\Page;
use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\HttpFoundation\Response;

class Share
{
    public function handle(Request $request, Closure $next): Response
    {
        LaravelLocalization::setLocale();

        View::share('pages', Page::all()->keyBy('id'));
        View::share('settings', Setting::all()->keyBy('key')->map(fn ($setting) => $setting->value));
        View::share('contents', Content::with(['picture'])->whereIn('type', ContentTypes::contents())->get()->keyBy('name'));

        return $next($request);
    }
}
