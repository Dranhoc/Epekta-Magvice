<div class="bg-header"></div>
<header class="g-header">
  <div class="g-header__content">


    <div class="flex w-full">
      <a href="/">
        <figure class="g-header__logo">
          @svg('logo', 'logo')
        </figure>
      </a>

      @include('partials._header-menu', ['mobile' => false])
    </div>

    <button class="menu-burger">
      <span></span>
      <span></span>
      <span></span>
    </button>


    @include('partials._header-menu', ['mobile' => true])

  </div>
</header>
