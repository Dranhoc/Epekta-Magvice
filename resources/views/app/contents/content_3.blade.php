<?php $image = $content->picture; ?>

@if($image)
    @if($image->mime_type === 'image/svg+xml')
        <img src="{{ $image->getUrl() }}" alt="" class="{{ $class }}">
    @else
        <img src="{{ $image->getUrl() }}" alt="" class="{{ $class }}">
    @endif
@endif
