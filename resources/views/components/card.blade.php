<a href="" class="card">
  <figure class="card__visual">
    <img src="{{ asset('images/visual-card.jpg') }}" alt="Photo d'une maison">
    @svg('frontoffice/heart', 'frontoffice/heart')

    @if($new)<p class="badge badge--secondary">Nouveau</p>@endif
    @if($option)<p class="badge">Option</p>@endif
  </figure>
  <div class="card__content">
    <h3>Maison en vente - titre possible sur 2 lignes max.</h3>
    <div class="flex justify-between gap-10">
      <p class="price">230 000 €</p>
    </div>
    <ul class="card__icons">
      <li>
        @svg('frontoffice/icons/icon-chambre', 'icon')
        <p>2</p>
      </li>
      <li>
        @svg('frontoffice/icons/icon-shower', 'icon')
        <p>0</p>
      </li>
      <li>
        @svg('frontoffice/icons/icon-piece', 'icon')
        <p>12 pieces</p>
      </li>
      <li>
        @svg('frontoffice/icons/icon-dimensions', 'icon')
        <p>000 m2</p>
      </li>
    </ul>
  </div>
</a>