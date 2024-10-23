<header class="g-header">
  <div class="container">
    <div class="flex w-full items-center justify-between py-[14px] xl:justify-start">
      <a href="/">
        <figure class="g-header__logo">
          @svg('logo', 'logo')
        </figure>
      </a>

      @include('partials._header-menu', ['mobile' => false])

      <button class="menu-burger">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>
  </div>

  @include('partials._header-menu', ['mobile' => true])
</header>


{{-- Modal login --}}
{{-- <div class="modal modal-login" data-modal="modal-login">
  <div class="modal__inner">
    <button class="modal__close" data-modal-btn="modal-login">
    @svg('frontoffice/icons/icon-close', 'icon')
    </button>

    <figure class="flex items-center justify-center">
      @svg('logo', 'logo')
    </figure>
    <h2 class="text-center mb-60">On se connait ?</h2>

    <form class="form-login flex flex-col gap-15">
      <input type="email" placeholder="Entrez votre adresse mail" required>
      <input type="password" placeholder="Mot de passe" required>

      <div class="flex gap-15 justify-between pt-30 pb-20">
        <label for="remember" class="flex gap-5 items-center">
          <input type="checkbox" id="remember" class="has-border border-primary">
          Se souvenir de moi
        </label>
        <a href="" class="text-primary font-bold underline hover:no-underline">Mot de passe oublié ?</a>
      </div>

      <button type="submit" class="btn w-full">S'identifier</button>

      <a href="" class="text-center text-20 font-bold pt-30 pb-15">Vous n'avez pas de compte ?</a>

      <div class="flex justify-center">
        <a href="" class="btn btn--grey">S'inscrire</a>
      </div>
    </form>
  </div>
</div> --}}
