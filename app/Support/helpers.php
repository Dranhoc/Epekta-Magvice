<?php

declare(strict_types=1);

use App\Enums\ContentTypes;
use App\Models\Content;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

function temporarySignedRouteLocalized(string $name, Carbon $expiration, array $parameters = [], bool $absolute = true): string
{
    $locale = app()->getLocale();

    return URL::temporarySignedRoute("{$locale}.$name", $expiration, $parameters, $absolute);
}

function signedRouteLocalized(string $name, array $parameters = [], bool $absolute = true): string
{
    $locale = app()->getLocale();

    return URL::signedRoute("{$locale}.$name", $parameters, null, $absolute);
}

function routeLocalized(string $name, array $parameters = [], bool $absolute = true): string
{
    $locale = app()->getLocale();

    return URL::route("{$locale}.$name", $parameters, $absolute);
}

function imageRule(): \RahulHaque\Filepond\Rules\FilepondRule
{
    return Rule::filepond([
        'mimetypes:'.implode(',', config('slym.media.mime-types.image')),
        'max:'.config('media-library.max_file_size') / 1024,
    ]);
}
function getCallingView(array $rejects = []): ?string
{
    $backtrace = debug_backtrace();

    foreach ($backtrace as $trace) {
        if (isset($trace['class'], $trace['object']) && $trace['class'] === \Illuminate\View\View::class) {
            $viewName = $trace['object']->name();
            if (in_array($viewName, $rejects, true)) {
                continue;
            }

            return $viewName;
        }
    }

    return null;
}

function saveContent(string $str, string $name): Content
{
    $strObject = Str::of($str)->trim();

    $content = new Content;
    $content->source_file = getCallingView(['app.contents.content']);

    if ($strObject->startsWith('<img')) {

        preg_match('@src="([^"]+)"@', $str, $match);

        $src = array_pop($match);

        preg_match('@alt="([^"]+)"@', $str, $match);

        $alt = array_pop($match);

        $content->fill([
            'content' => $str,
            'name' => $name,
            'type' => ContentTypes::IMAGE->value,
            'picture_alt' => $alt,
        ]);

        $content->save();

        /** @var string $sourceString */
        $sourceString = $src;

        $content->addMediaFromUrl($sourceString)->toMediaCollection('picture');

        return $content;
    }

    if ($strObject->startsWith('<')) {
        $content->fill([
            'content' => $str,
            'name' => $name,
            'type' => ContentTypes::CONTENT->value,
        ]);
        $content->save();

        return $content;
    }

    $content->fill([
        'title' => $str,
        'name' => $name,
        'type' => ContentTypes::T->value,
    ]);
    $content->save();

    return $content;
}
