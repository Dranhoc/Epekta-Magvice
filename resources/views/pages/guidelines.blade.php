@extends('partials.template')
@section('content')

<section>
  <div class="container md:d-grid">
    <div class="md:col-span-6">
      <h1>Typographie</h1>
      <h1>Title 1</h1>
      <h2>Title 2</h2>
      <h3>Title 3</h3>
      <h4>Title 4</h4>
      <h5>Title 5</h5>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum impedit a cumque nisi adipisci voluptas minima
        alias placeat aut sapiente ab, dolor similique architecto dolore, maxime blanditiis eos ullam tempora!</p>
      <ul>
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

    </div>
    <div class="md:col-span-6">
      <img src="{{asset("/images/placeholder.jpg")}}" alt="Lake">
    </div>
  </div>
</section>

@endsection