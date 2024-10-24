@extends('partials.template')
@section('content')
  <section class="s-hero py-0">
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
    <div class="col-span-5"></div>
  </section>

  <section class="py-0">
    <div class="lg:d-grid container">

      <div class="card-gradient-border card-gradient-border--emergency">
        <div class="card-gradient-border__content">
          <h3>Vous êtes victime d’un piratage informatique&nbsp;?</h3>
          <div class="deco-gradient"></div>
          <p>Contactez-nous sans plus tarder et lancer le plan sauvetage de Magvice.</p>
          <a href="/" class="btn">Appel d’urgence 0000 00 00 00</a>
        </div>
      </div>
    </div>
  </section>

  @include('sections.section-partners')

  <section>
    <div class="lg:d-grid container">

      <div class="col-span-8">
        <h5>Nos services en cybersécurité</h5>
        <h2>De l’installation de parc informatique à une gérance partielle ou totale </h2>
        <div class="deco-gradient"></div>
        <p class="title-7">Bien s’assurer avec Magvice, c’est éviter des plaintes de vos clients en cas de
          dommage et donc
          éviter une
          faillite éventuelle à votre entreprise !</p>
      </div>
      <div class="col-span-2 col-start-10 my-40 lg:my-0">
        @svg('frontoffice.pages.home.logo')
      </div>

      <div class="col-span-6 mt-40 lg:pr-20">
        <figure class="mb-20">@svg('frontoffice.pages.home.security')</figure>
        <h4>Assurez la conformité de sécurité de votre infrastructure</h4>
        <p>Le but est d’aider les entreprises à renforcer la sécurité de leurs datacenters (serveurs/données/applications,
          réseaux, etc...), de leurs terminaux (ordinateurs, appareils mobiles) et des actifs publics...</p>
        <div class="flex flex-wrap gap-20">
          <button class="btn">Mise en conformité</button>
          <button class="btn btn--secondary">Demander un test GRATUIT</button>
        </div>
      </div>

      <div class="col-span-6 mt-80">
        <figure class="mb-20">@svg('frontoffice.pages.home.user')</figure>
        <h4>Assurez la conformité de sécurité de votre infrastructure</h4>
        <p>Le but est d’aider les entreprises à renforcer la sécurité de leurs datacenters (serveurs/données/applications,
          réseaux, etc...), de leurs terminaux (ordinateurs, appareils mobiles) et des actifs publics...</p>
        <div class="flex flex-wrap gap-20">
          <button class="btn">Mise en conformité</button>
          <button class="btn btn--secondary">Demander un test GRATUIT</button>
        </div>
      </div>

      <div class="col-span-12">
        <figure class="my-80">
          <img class="max-h-[561px] w-full rounded-20 object-cover" src="{{ asset('/images/home/hero-worker.jpg') }}"
            alt="Background of a nature scene">
        </figure>
      </div>


      <div class="col-span-4 pr-40">
        <figure class="mb-20">@svg('frontoffice.pages.home.user')</figure>
        <h4>Assurez la conformité de sécurité de votre infrastructure</h4>
        <p>Le but est d’aider les entreprises à renforcer la sécurité de leurs datacenters (serveurs/données/applications,
          réseaux, etc...), de leurs terminaux (ordinateurs, appareils mobiles) et des actifs publics...</p>
        <button class="btn">Mise en conformité</button>
      </div>
      <div class="col-span-4 pr-40">
        <figure class="mb-20">@svg('frontoffice.pages.home.user')</figure>
        <h4>Assurez la conformité de sécurité de votre infrastructure</h4>
        <p>Le but est d’aider les entreprises à renforcer la sécurité de leurs datacenters (serveurs/données/applications,
          réseaux, etc...), de leurs terminaux (ordinateurs, appareils mobiles) et des actifs publics...</p>
        <button class="btn">Mise en conformité</button>
      </div>
      <div class="col-span-4 pr-20">
        <figure class="mb-20">@svg('frontoffice.pages.home.user')</figure>
        <h4>Assurez la conformité de sécurité de votre infrastructure</h4>
        <p>Le but est d’aider les entreprises à renforcer la sécurité de leurs datacenters (serveurs/données/applications,
          réseaux, etc...), de leurs terminaux (ordinateurs, appareils mobiles) et des actifs publics...</p>
        <button class="btn">Mise en conformité</button>
      </div>


    </div>
  </section>

  {{-- <section>
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
  </section> --}}
@endsection
