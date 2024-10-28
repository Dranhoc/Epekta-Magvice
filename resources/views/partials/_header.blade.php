<div class="bg-header"></div>
<header class="g-header">
  <div class="g-header__content justify-between 2xl:justify-start">

    <figure class="g-header__logo">
      <a href="/">
        @svg('logo', 'logo')
      </a>
    </figure>

    @include('partials._header-menu', ['mobile' => false])
    @include('partials._header-menu', ['mobile' => true])

    <button class="menu-burger">
      <span></span>
      <span></span>
      <span></span>
    </button>

  </div>
</header>
