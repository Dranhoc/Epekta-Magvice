@extends('partials.template')
@section('content')
  <section>
    <div class="md:d-grid container">
      <div class="md:col-span-6">
        <h1>Typographie</h1>
        <h1>Niveau 1 - 50/60 Poppins Semibold</h1>
        <h2>Niveau 2 - 45/55 - Poppins Regular</h2>
        <h3>Niveau 3 - 35/45 - Popppins Semibold</h3>
        <h4>Niveau 4 - 26/36 - Poppins Bold</h4>
        <h5>Niveau 5 - 22/28 - 10% space letter - Poppins light</h5>
        <h6>Niveau 6 - 20/26 - Poppins Semibold</h6>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum impedit a cumque nisi adipisci voluptas minima
          alias placeat aut sapiente ab, dolor similique architecto dolore, maxime blanditiis eos ullam tempora!</p>
        <ul class="text-ul">
          <li>liste li classique</li>
          <li>liste li classique</li>
        </ul>

        <ul class="list-accordions mt-20">
          <li class="accordion">
            <button class="accordion__button">Accordion #1
              @svg('frontoffice/icons/icon-chevron', 'icon')</button>
            <div class="accordion__content">
              <div class="accordion__inner">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut laborum nulla nam fuga eveniet hic dolores
                  porro fugiat perferendis, vero facere rem laboriosam inventore impedit sapiente. Ducimus et beatae ea?
                </p>
              </div>
            </div>
          </li>
          <li class="accordion">
            <button class="accordion__button">Accordion #2
              @svg('frontoffice/icons/icon-chevron', 'icon')</button>
            <div class="accordion__content">
              <div class="accordion__inner">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut laborum nulla nam fuga eveniet hic dolores
                  porro fugiat perferendis, vero facere rem laboriosam inventore impedit sapiente. Ducimus et beatae ea?
                </p>
              </div>
            </div>
          </li>
        </ul>

        <div class="mt-20 flex gap-20">
          <button class="btn">Primary button</button>
          <button class="btn btn--secondary">Secondary button</button>
        </div>

        <div class="my-20 flex gap-20">
          <div class="test-button">Super button</div>
          <button class="test-button">Super button</button>
        </div>

        <div class="md:col-span-6">
          <img src="{{ asset('/images/placeholder.jpg') }}" alt="Lake">
        </div>
      </div>
  </section>
@endsection
