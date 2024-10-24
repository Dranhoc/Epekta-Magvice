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

      <div class="card-gradient-border card-gradient-border--emergency full-w-mobile">
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


  <section class="s-description">
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

      <div class="col-span-6 mt-80 lg:mt-60 lg:pr-20">
        <figure class="mb-20">@svg('frontoffice.pages.home.security')</figure>
        <h4>Assurez la conformité de sécurité de votre infrastructure</h4>
        <p>Le but est d’aider les entreprises à renforcer la sécurité de leurs datacenters (serveurs/données/applications,
          réseaux, etc...), de leurs terminaux (ordinateurs, appareils mobiles) et des actifs publics...</p>
        <div class="flex flex-wrap gap-20">
          <button class="btn">Mise en conformité</button>
          <button class="btn btn--secondary">Demander un test GRATUIT</button>
        </div>
      </div>

      <div class="col-span-6 mt-80 lg:mt-100">
        <figure class="mb-20">@svg('frontoffice.pages.home.user')</figure>
        <h4>Améliorez les compétences de votre équipe avec des solutions modernes et hybrides</h4>
        <p>Permettre aux collaborateurs de travailler de n’importe où à tout moment d’une manière sécurisée et optimisée.
        </p>
        <div class="flex flex-wrap gap-20">
          <button class="btn">Gestion de réseau</button>
          <button class="btn btn--secondary">Voir les avantages d’une externalisation</button>
        </div>
      </div>

      <div class="col-span-12">
        <figure class="my-80">
          <img class="max-h-[561px] w-full rounded-20 object-cover" src="{{ asset('/images/home/hero-worker.jpg') }}"
            alt="Working man in a datacenter">
        </figure>
      </div>


      <div class="col-span-4 mt-80 lg:mt-0 lg:pr-40">
        <figure class="mb-20">@svg('frontoffice.pages.home.password')</figure>
        <h4>Profitez des services gérés de Magvice</h4>
        <p>Economiser de l’argent et du temps en fournissant à votre entreprise un environnement sûr pour héberger vos
          services et applications.</p>
        <button class="btn">Voir les services gérés</button>
      </div>
      <div class="col-span-4 mt-80 lg:mt-0 lg:pr-40">
        <figure class="mb-20">@svg('frontoffice.pages.home.web-security')</figure>
        <h4>Mise en place du matériel et conception de réseaux</h4>
        <p>Aider les entreprises à concevoir des réseaux WiFi optimaux, à construire de grands réseaux câblés, à façonner
          leur datacenter et à fournir...</p>
        <button class="btn">Voir le support matériel</button>
      </div>
      <div class="col-span-4 mt-80 lg:mt-0 lg:pr-40">
        <figure class="mb-20">@svg('frontoffice.pages.home.light-alert')</figure>
        <h4>Récupérez vos données après sinistre</h4>
        <p>S’assurer, qu’en cas de catastrophe, d’être toujours en mesure de fonctionner correctement dans un minimum de
          temps prédéfini.</p>
        <button class="btn">Voir les garanties Magvice</button>
      </div>


    </div>
  </section>


  <section class="s-hero s-hero--security">

    <figure class="s-hero__visual">
      <img class="w-full overflow-hidden object-cover" src="{{ asset('/images/home/hero-router.jpg') }}"
        alt="Background of a router">
    </figure>

    <div class="container relative">
      <div class="s-hero--security__content scrolling-content">
        @for ($i = 0; $i < 20; $i++)
          <h2 class="scrolling-text">Service de protection</h2>
          <h2 class="scrolling-text">Cybersécurité</h2>
        @endfor
      </div>
    </div>

  </section>


  <section class="bg-custom-grey py-0">
    <div class="lg:d-grid container">

      <div class="card-gradient-border full-w-mobile col-span-10 col-start-2">
        <div class="card-gradient-border__content !text-center">
          <h5>Besoin d’y voir plus clair ?</h5>
          <h3>Profitez d’un diagnostic GRATUIT concernant la situation actuelle de votre structure</h3>
          <div class="deco-gradient mx-auto"></div>
          <p class="title-7">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros
            elementum tristique.
          </p>
          <a href="/" class="btn">Demandez un rendez-vous</a>
        </div>
      </div>

    </div>
  </section>


  <section class="s-values pb-60 pt-180">
    <div class="lg:d-grid container">

      <div class="col-span-6">
        <h5>Valeurs Magvice</h5>
        <h2>Gaétan, votre assureur en informatique qui vous accompagne pas à pas dans l’univers du cloud</h2>
        <div class="deco-gradient"></div>
        <figure class="s-values__visual">
          <img src="{{ asset('/images/home/gaetan.jpg') }}" alt="Picture of Gaétan">
        </figure>
      </div>

      <div class="col-span-6">

        <p class="mb-80 mt-40 lg:my-80">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim
          in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam
          libero vitae erat.</p>

        <div class="flex w-full flex-col gap-80 md:flex-row md:gap-40">
          <div class="md:w-1/2">
            <figure class="mb-20">@svg('frontoffice.pages.home.password')</figure>
            <h4>Une organisation sans faille et un process établi</h4>
            <p class="mt-25">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros
              elementum
              tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla.</p>
            <button class="btn md:mt-80">En savoir plus sur Gaétan</button>
          </div>
          <div class="md:w-1/2">
            <figure class="mb-20">@svg('frontoffice.pages.home.light-alert')</figure>
            <h4>Un suivi en toute transparence et modulable</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros
              elementum
              tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla.</p>
          </div>
        </div>

      </div>

    </div>
  </section>


  <section class="s-iframe py-0">
    <div class="lg:d-grid container">

      <div class="col-span-10 col-start-2">
        <figure class="flex justify-center">
          <iframe class="aspect-[150/73] w-full rounded-20 shadow-xl" src="https://www.youtube.com/embed/L8E7cZWBuq8"
            title="Voici Le Plus Grand Data Center Au Monde" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </figure>
      </div>

    </div>
  </section>

  <section class="bg-primary">
    <div class="lg:d-grid container">

      <div class="col-span-6 xl:col-span-5 xl:col-start-2">
        <h3 class="text-white">Long heading is what you see here in this feature section</h3>
        <div class="deco-gradient"></div>
      </div>

      <div class="col-span-12 mt-60 xl:col-span-10 xl:col-start-2">
        <div class="key-numbers">
          <div>
            <h6>10<span>X</span></h6>
            <p>Argumentaire 01</p>
          </div>
          <div class="key-numbers__big">
            <h6>30<span>%</span></h6>
            <p>Argumentaire 02</p>
          </div>
          <div>
            <h6>79&nbsp;000</h6>
            <p>Argumentaire 03</p>
          </div>
        </div>
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
