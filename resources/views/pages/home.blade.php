@extends('partials.template')
@section('content')
  <section class="s-hero py-200">
    <figure class="s-hero__visual">
      <img src="{{ asset('/images/header-bg.jpg') }}" alt="Background of a nature scene">
    </figure>
    <div class="s-hero__content lg:d-grid container">
      <div class="lg:col-span-8 xl:col-span-7 2xl:col-span-6">
        <h5>En tant que manager ou chef d’entreprise</h5>
        <h1>Sécurisez vos données et optimiser l’efficacité de vos collaborateurs</h1>
        <h6>Magvice est votre partenaire IT, expert belge en solutions de parcs informatiques, en gestion de réseaux et en
          cybersécrurité.</h6>
        <button class="btn btn--secondary btn--hero">Voir les images Magvice</button>
      </div>
    </div>
  </section>

  <div class="lg:d-grid container relative">
    <div class="card-gradient-border card-gradient-border--emergency">
      <div class="card-gradient-border__content">
        <h3>Vous êtes victime d’un piratage informatique&nbsp;?</h3>
        <div class="deco-gradient"></div>
        <p>Contactez-nous sans plus tarder et lancer le plan sauvetage de Magvice.</p>
        <a href="/" class="btn">Appel d’urgence 0000 00 00 00</a>
      </div>
    </div>
  </div>

  <section>
    <div class="lg:d-grid container">
      <div class="col-span-12">
        <h2 class="mb-30 text-center">Liste de cartes dans un slider</h2>
      </div>

      <div class="col-span-10 col-start-2">
        <div class="swiper slider-cards">
          <div class="swiper-wrapper">
            <div class="swiper-slide">@include('components.card', ['new' => false, 'option' => false])</div>
            <div class="swiper-slide">@include('components.card', ['new' => false, 'option' => true])</div>
            <div class="swiper-slide">@include('components.card', ['new' => true, 'option' => false])</div>
            <div class="swiper-slide">@include('components.card', ['new' => false, 'option' => false])</div>
            @if ($page === 'home')
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
    <div class="lg:d-grid container">
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
