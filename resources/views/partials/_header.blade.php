<div class="bg-header"></div>
<header class="g-header">
  <div class="container">

    <div class="g-header__content">
      <figure class="g-header__logo">
        <a href="/">
          @svg('logo', 'logo')
        </a>
      </figure>

      <nav class="g-header__nav">
        <div class="g-header__subnav">
          <a href="#about">À&nbsp;propos</a>
          <div class="submenu">
            <button class="submenu__button">Services @svg('frontoffice.icons.icon-chevron-right')</button>
            <nav class="submenu__subnav submenu__subnav--services">
              <a href="#service-1">Mise en conformité</a>
              <a href="#service-2">Gestion du réseau</a>
              <a href="#service-3">Services gérés</a>
              <a href="#service-4">Matériel informatique</a>
              <a href="#service-5">Garantie Magvice</a>
            </nav>
          </div>
          <a href="#prices">Tarifs</a>
          <a href="#testimonies">Témoignages</a>
          <a href="#faq">FAQ</a>
          <a href="#blog" class="3xl:px-30">Blog</a>
        </div>
        <div class="g-header__subnav">
          <button class="btn btn--secondary" href="/contact">Assistance à distance</button>
          <button class="btn" href="/contact">Contact</button>
          <div class="submenu">
            <button class="submenu__button">FR @svg('frontoffice.icons.icon-chevron-right')</button>
            <nav class="submenu__subnav">
              <a href="/">NL</a>
              <a href="/">EN</a>
              <a href="/">FR</a>
            </nav>
          </div>
        </div>
      </nav>

      <button class="menu-burger">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>

  </div>

  </div>
</header>



<nav class="nav-mobile">
  <div class="nav-mobile__header">
    <figure class="flex">
      <a href="/">
        @svg('logo', 'logo')
      </a>
    </figure>
    <button class="menu-burger">
      <span></span>
      <span></span>
      <span></span>
    </button>
  </div>


  <div class="nav-mobile__subnav">
    <a href="#about">À&nbsp;propos</a>
    <div class="submenu">
      <button class="submenu__button">Services @svg('frontoffice.icons.icon-chevron-right')</button>
      <nav class="submenu__subnav">
        <a href="#service-1">Mise en conformité</a>
        <a href="#service-2">Gestion du réseau</a>
        <a href="#service-3">Services gérés</a>
        <a href="#service-4">Matériel informatique</a>
        <a href="#service-5">Garantie Magvice</a>
      </nav>
    </div>
    <a href="#prices">Tarifs</a>
    <a href="#testimonies">Témoignages</a>
    <a href="#faq">FAQ</a>
    <a href="#blog" class="3xl:px-30">Blog</a>
  </div>
  <div class="nav-mobile__subnav">
    <button class="btn btn--secondary" href="/contact">Assistance à distance</button>
    <button class="btn -mt-10" href="/contact">Contact</button>
    <div class="submenu">
      <button class="submenu__button closed">FR @svg('frontoffice.icons.icon-chevron-right')</button>
      <nav class="submenu__subnav closed">
        <a href="/">NL</a>
        <a href="/">EN</a>
        <a href="/">FR</a>
      </nav>
    </div>
  </div>

</nav>
