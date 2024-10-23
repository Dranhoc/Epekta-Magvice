@extends('partials.template')
@section('content')

<section class="s-hero">
  <figure class="s-hero__visual">
    <img src="{{asset("/images/bg-header.jpeg")}}" alt="Background of a nature scene">
  </figure>
  <div class="container s-hero__content">
    <h1>Hero section</h1>
    <h3>hello world :)</h3>
  </div>
</section>

<section>
  <div class="container lg:d-grid">
    <div class="col-span-12">
      <h2 class="text-center mb-30">Liste de cartes dans un slider</h2>
    </div>

    <div class="col-span-10 col-start-2">
      <div class="swiper slider-cards">
        <div class="swiper-wrapper">
          <div class="swiper-slide">@include('components.card', ['new' => false, 'option' => false])</div>
          <div class="swiper-slide">@include('components.card', ['new' => false, 'option' => true])</div>
          <div class="swiper-slide">@include('components.card', ['new' => true, 'option' => false])</div>
          <div class="swiper-slide">@include('components.card', ['new' => false, 'option' => false])</div>
          @if($page === 'home')
          <div class="swiper-slide">@include('components.card', ['new' => false, 'option' => false])</div>
          <div class="swiper-slide">@include('components.card', ['new' => false, 'option' => false])</div>
          @endif
        </div>
      </div>
      <div class="swiper-button swiper-button-prev swiper-button-cards"></div>
      <div class="swiper-button swiper-button-next swiper-button-cards"></div>
    </div>
  </div>
</section>

<section>
  <div class="container lg:d-grid">
    <h2 class="col-span-12 text-center">Tableau</h2>
    <table class="col-span-8 col-start-3">
      <thead>
        <tr>
          <th>Column 1</th>
          <th>Column 2</th>
          <th>Column 3</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Row 1, Col 1</td>
          <td>Row 1, Col 2</td>
          <td>Row 1, Col 3</td>
        </tr>
        <tr>
          <td>Row 2, Col 1</td>
          <td>Row 2, Col 2</td>
          <td>Row 2, Col 3</td>
        </tr>
        <tr>
          <td>Row 3, Col 1</td>
          <td>Row 3, Col 2</td>
          <td>Row 3, Col 3</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3">Footer</td>
        </tr>
      </tfoot>
    </table>

  </div>
</section>

@endsection
