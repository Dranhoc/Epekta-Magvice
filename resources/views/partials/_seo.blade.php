@php /** @var \App\Models\Page $page */ @endphp

<meta charset="UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

@isset($current)
    <title>{{ $current->alt('seo_title', config('app.name')) }}</title>
    <meta name="description" itemprop="description" content="{{ $current->alt('seo_description') }}"/>
    <meta property="og:title" content="{{ $current->alt('seo_title') }}"/>
    <meta property="og:description" content="{{ $current->alt('seo_description') }}"/>
    @if($current->seo_image)
        <meta property="og:image" content="{{ $current->seo_image->getFullUrl() }}"/>
    @endif
    <meta property="og:url" content="{{ \Illuminate\Support\Facades\URL::current() }}"/>
    <meta property="og:type" content="{{ $current->alt('seo_type', 'website') }}"/>
@else
    <title>{{ config('app.name') }}</title>
@endisset

<meta property="og:site_name" content="{{ config('app.name') }}"/>
<meta property="og:locale" content="{{ app()->getLocale() }}"/>
