@php

    $content = null;

        if($name !== null) {
            $content = $contents[$name] ?? null;

            if($content === null) {
                $content = saveContent($slot, $name);
                View::share('contents', \App\Models\Content::with(['picture'])->whereIn('type', \App\Enums\ContentTypes::contents())->get()->keyBy('name'));
            }
        }

@endphp

@if($content === null)
    {{ $slot }}
@else
    @include("app.contents.content_{$content->type}")
@endif
