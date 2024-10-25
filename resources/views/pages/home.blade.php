@extends('partials.template')
@section('content')
  <section class="s-hero py-0">

    <figure class="s-hero__visual">
      <img src="{{ asset('/images/header-bg.jpg') }}" alt="Background of a nature scene">
    </figure>

    <div class="s-hero__content lg:d-grid container">
      <div class="col-span-8 xl:col-span-6 xl:col-start-2">
        <h5>En tant que manager ou chef d’entreprise</h5>
        <h1>Sécurisez vos données et optimiser l’efficacité de vos collaborateurs</h1>
        <h6 class="lg:w-[60%] xl:w-full">Magvice est votre partenaire IT, expert belge en solutions de parcs informatiques,
          en gestion de réseaux et en
          cybersécrurité.</h6>
        <button class="btn btn--secondary btn--hero">Voir les images Magvice</button>
      </div>
    </div>

  </section>


  <section class="py-0">
    <div class="lg:d-grid container">

      <div class="card-gradient-border card-gradient-border--floating full-w-mobile">
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
  <div class="deco-ellipse deco-ellipse--bottom">@svg('frontoffice.deco-ellipse')</div>


  <section class="s-description">
    <div class="lg:d-grid container">

      <div class="col-span-7 col-start-2">
        <h5>Nos services en cybersécurité</h5>
        <h2>De l’installation de parc informatique à une gérance partielle ou totale </h2>
        <div class="deco-gradient"></div>
        <p class="title-7">Bien s’assurer avec Magvice, c’est éviter des plaintes de vos clients en cas de
          dommage et donc
          éviter une
          faillite éventuelle à votre entreprise !</p>
      </div>
      <div class="col-span-2 col-start-9 my-40 lg:my-0">
        @svg('frontoffice.pages.home.logo')
      </div>

      <div class="col-span-5 col-start-2 mt-80 lg:mt-60 lg:pr-20">
        <figure class="mb-20">@svg('frontoffice.pages.home.security')</figure>
        <h4>Assurez la conformité de sécurité de votre infrastructure</h4>
        <p>Le but est d’aider les entreprises à renforcer la sécurité de leurs datacenters (serveurs/données/applications,
          réseaux, etc...), de leurs terminaux (ordinateurs, appareils mobiles) et des actifs publics...</p>
        <div class="flex flex-wrap gap-20">
          <button class="btn">Mise en conformité</button>
          <button class="btn btn--secondary">Demander un test GRATUIT</button>
        </div>
      </div>

      <div class="col-span-5 mt-80 lg:mt-100">
        <figure class="mb-20">@svg('frontoffice.pages.home.user')</figure>
        <h4>Améliorez les compétences de votre équipe avec des solutions modernes et hybrides</h4>
        <p>Permettre aux collaborateurs de travailler de n’importe où à tout moment d’une manière sécurisée et optimisée.
        </p>
        <div class="flex flex-wrap gap-20">
          <button class="btn">Gestion de réseau</button>
          <button class="btn btn--secondary">Voir les avantages d’une externalisation</button>
        </div>
      </div>

      <div class="col-span-10 col-start-2">
        <figure class="my-80">
          <img class="max-h-[561px] w-full rounded-20 object-cover" src="{{ asset('/images/home/hero-worker.jpg') }}"
            alt="Working man with a lot of cables">
        </figure>
      </div>


      <div class="flex flex-col gap-x-80 lg:col-span-12 lg:flex-row xl:col-span-10 xl:col-start-2">
        <div class="mt-80 lg:mt-0 lg:w-1/3">
          <figure class="mb-20">@svg('frontoffice.pages.home.password')</figure>
          <h4>Profitez des services gérés de Magvice</h4>
          <p>Economiser de l’argent et du temps en fournissant à votre entreprise un environnement sûr pour héberger vos
            services et applications.</p>
          <button class="btn">Voir les services gérés</button>
        </div>
        <div class="mt-80 lg:mt-0 lg:w-1/3">
          <figure class="mb-20">@svg('frontoffice.pages.home.web-security')</figure>
          <h4>Mise en place du matériel et conception de réseaux</h4>
          <p>Aider les entreprises à concevoir des réseaux WiFi optimaux, à construire de grands réseaux câblés, à
            façonner
            leur datacenter et à fournir...</p>
          <button class="btn">Voir le support matériel</button>
        </div>
        <div class="mt-80 lg:mt-0 lg:w-1/3">
          <figure class="mb-20">@svg('frontoffice.pages.home.light-alert')</figure>
          <h4>Récupérez vos données après sinistre</h4>
          <p>S’assurer, qu’en cas de catastrophe, d’être toujours en mesure de fonctionner correctement dans un minimum de
            temps prédéfini.</p>
          <button class="btn">Voir les garanties Magvice</button>
        </div>
      </div>


    </div>
  </section>


  <div class="deco-ellipse deco-ellipse--top">@svg('frontoffice.deco-ellipse')</div>
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
  <div class="deco-ellipse deco-ellipse--bottom deco-ellipse--grey">@svg('frontoffice.deco-ellipse')</div>


  <section class="-mt-35 bg-custom-grey py-0">
    <div class="lg:d-grid container">

      <div class="card-gradient-border full-w-mobile col-span-10 col-start-2 lg:-my-70">
        <div class="card-gradient-border__content !text-center lg:p-60">
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


  <section class="s-values lg:pb-60 lg:pt-180">
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

        <p class="title-7 mb-80 mt-40 lg:my-80">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse
          varius enim
          in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam
          libero vitae erat.</p>

        <div class="flex w-full flex-col gap-80 md:flex-row md:gap-40">
          <div class="md:w-1/2">
            <figure class="mb-20">@svg('frontoffice.pages.home.password')</figure>
            <h4>Une organisation sans faille et un process établi</h4>
            <p class="mt-25">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros
              elementum
              tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla.</p>
            <button class="btn md:mt-40">En savoir plus sur Gaétan</button>
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
  <div class="deco-ellipse deco-ellipse--bottom">@svg('frontoffice.deco-ellipse')</div>


  <section class="s-prices">
    <div class="lg:d-grid container">

      <div class="col-span-12 xl:col-span-10 xl:col-start-2">
        <h5>Des prix abordables et sur-mesure</h5>
        <h2>Packs tarifaires</h2>
        <div class="deco-gradient"></div>
        <p class="title-7 mb-80">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia, rerum doloremque.
          Explicabo placeat veniam libero voluptas aliquid distinctio animi recusandae.</p>

        <h4>Service + gérance</h4>
        <p class="s-prices__content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in
          eros
          elementum tristique.
        </p>
        <h4>Service sans gérance</h4>
        <p class="s-prices__content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in
          eros
          elementum tristique.
        </p>
        <h4>Service mi-géré</h4>
        <p class="s-prices__content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in
          eros
          elementum tristique.
        </p>
        <a href="/" class="btn btn--secondary mt-30">Voir tous les packs tarifaires</a>
      </div>

    </div>
  </section>

  <section class="py-0">
    <div class="lg:d-grid container">

      <div class="card-gradient-border card-gradient-border--floating card-gradient-border--prices full-w-mobile">
        <div class="card-gradient-border__content !px-20">

          <div class="flex flex-col justify-between gap-x-50 gap-y-20 sm:flex-row lg:items-center">
            <div>
              <h4 class="mb-10 font-semibold">Basic plan</h4>
              <p class="mb-0">Lorem ipsum dolor.</p>
            </div>
            <p class="mb-0 text-[57px] font-bold text-primary">€149<span class="text-30">/mois</span></p>
          </div>

          <div class="deco-grey"></div>

          <p>Includes:</p>
          <ul class="text-ul flex flex-col justify-between gap-x-30 sm:flex-row">
            <div class="sm:w-1/2">
              <li>@svg('frontoffice.icons.icon-chevron')Feature text goes here</li>
              <li>@svg('frontoffice.icons.icon-chevron')Feature text goes here</li>
              <li>@svg('frontoffice.icons.icon-chevron')Feature text goes here</li>
              <li>@svg('frontoffice.icons.icon-chevron')Feature text goes here</li>
              <li>@svg('frontoffice.icons.icon-chevron')Feature text goes here</li>
            </div>

            <div class="sm:w-1/2">
              <li>@svg('frontoffice.icons.icon-chevron')Feature text goes here</li>
              <li>@svg('frontoffice.icons.icon-chevron')Feature text goes here</li>
              <li>@svg('frontoffice.icons.icon-chevron')Feature text goes here</li>
              <li>@svg('frontoffice.icons.icon-chevron')Feature text goes here</li>
            </div>
          </ul>

          <div class="deco-grey"></div>

          <a href="/" class="btn mb-40 w-full">Je suis intéressé(e)</a>
        </div>
      </div>

    </div>
  </section>


  <section class="lg:pb-20 lg:pt-[320px]">
    <div class="lg:d-grid container">

      <div class="col-span-12">

        <div class="swiper slider-photos">
          <div class="swiper-wrapper">
            @for ($i = 1; $i < 5; $i++)
              <div class="swiper-slide">
                <figure class="slider-photos__visual">
                  <img src="{{ asset('images/home/slider-photos/slider' . $i . '.jpg') }}" alt="">
                </figure>
              </div>
            @endfor
            @for ($i = 1; $i < 5; $i++)
              <div class="swiper-slide">
                <figure class="slider-photos__visual">
                  <img src="{{ asset('images/home/slider-photos/slider' . $i . '.jpg') }}" alt="">
                </figure>
              </div>
            @endfor
          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </div>
  </section>


  <div class="deco-ellipse deco-ellipse--top">@svg('frontoffice.deco-ellipse')</div>
  <section class="s-testimonies bg-custom-grey">
    <div class="lg:d-grid container">
      <div class="col-span-10 col-start-2 text-center">

        <h5 class="mb-15">De vrais témoignages avec de vrais enjeux</h5>
        <h3>Ils témoignent de leur confiance</h3>
        <div class="flex justify-center gap-5">
          @for ($i = 0; $i < 5; $i++)
            @svg('frontoffice.icons.star')
          @endfor
        </div>

        <div class="swiper slider-testimonies">
          <div class="swiper-wrapper">

            @for ($i = 0; $i < 4; $i++)
              <div class="swiper-slide">
                <div class="px-40 lg:px-150">
                  <h6 class="text-center">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius
                    enim
                    in
                    eros
                    elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam
                    libero
                    vitae erat."</h6>
                  <div class="flex h-60 items-center justify-center gap-x-20">
                    <figure><img src="{{ asset('/images/home/avatar1.png') }}" alt="avatar of Gaétan"></figure>
                    <div class="flex flex-col justify-center text-left">
                      <p class="title-7 mb-0">John Doe</p>
                      <p class="mb-0">Position, Company name</p>
                    </div>
                    <div class="separator-gradient"></div>
                    @svg('frontoffice.sections.partners.placeholder2')
                  </div>
                </div>
              </div>
            @endfor
          </div>

          <div class="swiper-pagination"></div>
          <div class="swiper-button swiper-button-prev swiper-button-testimonies">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#C11794" />
            </svg>
          </div>
          <div class="swiper-button swiper-button-next swiper-button-testimonies">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 4L10.59 5.41L16.17 11H4V13H16.17L10.59 18.59L12 20L20 12L12 4Z" fill="#C11794" />
            </svg>
          </div>
        </div>

      </div>
    </div>
  </section>
  <div class="deco-ellipse deco-ellipse--bottom">@svg('frontoffice.deco-ellipse')</div>


  <section class="s-dyk py-30 lg:py-90">
    <div class="lg:d-grid container">

      <div class="col-span-6">
        <h5>Retrouvez toute l’actualité simplifiée</h5>
        <h2>Le saviez-vous&nbsp;?</h2>
        <div class="deco-gradient"></div>
        <p class="title-7 mb-30">Lorem ipsum dolor sit amet, consectetur adipLorem ipsum dolor sit amet, consectetur
          adipiscing
          elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. iscing elit. </p>
        <a href="/" class="btn btn--secondary mb-80">Voir tous les articles de blog</a>
      </div>

      <div class="col-span-6 flex flex-col gap-y-80">
        <article class="a-resume">
          <figure>
            <img src="{{ asset('/images/home/laptop.png') }}" alt="Picture of a laptop">
          </figure>
          <div class="a-resume__content">
            <span class="a-resume__date">Publié le 00/00/00</span>
            <h6>Un monitoring aurait pu sauver des vies le 11 septembre</h6>
            <p>le service It s’est occupé de transfert les données avant de mourir dans la cave d’une tour. D’où
              l’importance d’automatiser&nbsp;!</p>
            <button>Lire tout l'article @svg('frontoffice/icons/icon-chevron-right')</button>
          </div>
        </article>

        <article class="a-resume">
          <figure>
            <img src="{{ asset('/images/home/anonymous.png') }}" alt="Picture of a hacker">
          </figure>
          <div class="a-resume__content">
            <span class="a-resume__date">Publié le 00/00/00</span>
            <h6>Une nouvelle norme de conformité devra être mise en vigueur à partir de janvier 2025</h6>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim...</p>
            <button>Lire tout l'article @svg('frontoffice/icons/icon-chevron-right')</button>
          </div>
        </article>
      </div>



    </div>
  </section>

  <div class="deco-ellipse deco-ellipse--top">@svg('frontoffice.deco-ellipse')</div>
  <section class="s-newsletter">
    <div class="lg:d-grid container">
      <div class="col-span-6 col-start-4 text-center">
        <h3 class="mb-25">Inscrivez-vous à la newsletter</h3>
        <p class="title-7 text-white">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.
        </p>
        <form action="">
          <div class="mt-40 flex flex-wrap items-center justify-center gap-20">
            <input class="max-w-[400px] !rounded-10 !p-[12px] !text-grey" type="email"
              placeholder="Entrez votre e-mail">
            <button class="btn">S'inscrire</button>
          </div>
      </div>
      <div class="col-span-4 col-start-5 mt-20 flex items-center gap-10">
        <input class="rounded-[5px] !border-2 !border-bluelight p-2" type="checkbox" name="privacy">
        <label for="privacy">Vous acceptez notre
          <a href="/" class="underline"> politique de confidentialité</a>
        </label>
      </div>
      </form>

  </section>
  <div class="deco-ellipse deco-ellipse--bottom">@svg('frontoffice.deco-ellipse')</div>


  <section class="s-faq pb-80">
    <div class="lg:d-grid container">

      <div class="col-span-7 lg:w-[88%]">
        <h5>Ne restez pas sans réponses</h5>
        <h2>Posez-nous vos questions</h2>
        <div class="deco-gradient"></div>
        <p class="title-7 mb-30">Lorem ipsum dolor sit amet, consectetur adipLorem ipsum dolor sit amet, consectetur
          adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. iscing elit. </p>

        <div class="swiper slider-questions">
          <div class="swiper-wrapper" data-anim="slide-right-multiple" data-offset="200">
            @for ($i = 0; $i < 4; $i++)
              <div class="swiper-slide">

                <article class="s-faq__slider">
                  <div class="dialog mb-20">
                    <h6>“Sommes-nous préparés à réagir en cas de cyber-attaque&nbsp;?”</h6>
                  </div>
                  <div class="dialog dialog--right">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse
                    varius enim in eros elementum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in
                    eros elemm dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elemm
                    tristique. Duis cursus, mi quis viverra ornare."</div>
                </article>

              </div>
            @endfor
          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

      <figure class="s-faq__visual col-span-5">
        <img src="{{ asset('/images/home/big-gaetan.png') }}" alt="Big picture of Gaétan">
      </figure>
    </div>
  </section>


  <section class="py-0 lg:-mb-[141px]">
    <div class="lg:d-grid container">

      <div class="card-gradient-border full-w-mobile col-span-10 col-start-2">
        <div class="card-gradient-border__content !text-center">
          <h5>Besoin d’y voir plus clair&nbsp;?</h5>
          <h3>Vous avez des questions&nbsp;?</h3>
          <div class="deco-gradient mx-auto"></div>
          <p class="title-7">Toutes les questions ne resterons pas sans réponses. Nous reviendrons vers vous dans les
            24h.
          </p>
          <div class="mb-20 mt-40 flex flex-wrap justify-center gap-20">
            <a href="/" class="btn">Contactez-nous&nbsp;!</a>
            <a href="/" class="btn btn--secondary">Voir toutes les FAQ</a>
          </div>
        </div>
      </div>

    </div>
  </section>
@endsection
