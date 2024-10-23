@extends('partials.template')

@section('content')
    <section class="main main--website" data-barba="container" data-barba-namespace="contact">
        @php $form = $page->form @endphp
        @include('components.form')
    </section>
@endsection


