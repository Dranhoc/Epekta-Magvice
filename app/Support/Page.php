<?php

declare(strict_types=1);

namespace App\Support;

class Page
{
    public static function loadPage(string $pathInfo): \App\Models\Page
    {
        $pathInfo = str_replace('/'.app()->getLocale().'/', '', $pathInfo);
        $page = self::searchPage(
            $pathInfo,
            app()->getLocale()
        );

        if ($page === null) {
            $page = self::searchPage(
                $pathInfo,
                'fr'
            );
        }

        if ($page === null || $page->translate('slug', '', false)) {
            abort(404);
        }

        return $page;
    }

    protected static function searchPage(string $path, ?string $locale = null): ?\App\Models\Page
    {
        if (empty($path)) {
            return \App\Models\Page::find(1);
        }

        $page = \App\Models\Page::whereTranslatedSlug($path, $locale)->orderByDesc('id')->firstOrNew();

        if ($page->exists) {
            return $page;
        }

        $lastSlashPos = strrpos($path, '/');

        if ($lastSlashPos === false) {
            return null;
        }

        return self::searchPage(substr($path, 0, $lastSlashPos));
    }
}
