<?php

use App\Actions\Export\ExportCSV;
use App\Http\Controllers;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('robots.txt', [Controllers\SEOController::class, 'robots']);
Route::get('media/{uuid}', Controllers\SignedMediaController::class)
    ->middleware('signed')
    ->name('media');

Route::get('/test', function () {
    return (new ExportCSV)->export(User::class, ['id', 'name', 'email']);
});

Route::get('/', [Controllers\RedirectController::class, 'home']);
Route::get('/home', static fn () => redirect('/'));
Route::view('/guidelines', 'pages.guidelines')->name('guidelines');

foreach (config('laravellocalization.localesOrder') as $locale) {
    Route::group(['prefix' => $locale], function () use ($locale) {
        Route::get('/', [Controllers\PageController::class, 'index']);

        try {
            Page::all()
                ->each(static function (Page $page) use ($locale) {
                    $routeName = $page->route_name ?? \Illuminate\Support\Str::uuid()->toString();
                    $method = $page->method ?? [Controllers\PageController::class, 'render'];

                    Route::get($page->translate('slug', $locale), $method)->name("{$locale}.{$routeName}");

                    if ($page->model) {
                        Route::get("{$page->translate('slug', $locale)}/{slug?}/{id?}", $page->method)
                            ->where('slug', '[a-z0-9/-]+[^0-9]')
                            ->name("{$locale}.{$routeName}-single");
                    }
                });
        } catch (\Exception $e) {

        }
    });
}
